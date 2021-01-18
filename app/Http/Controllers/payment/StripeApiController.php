<?php

namespace App\Http\Controllers\Payment;

use App\CancellationPenalty;
use App\User;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Account;
use App\Transaction;
use Stripe\Customer;
use App\SessionBonus;
use App\PaymentMethod;
use Stripe\AccountLink;
use Stripe\SetupIntent;
use Illuminate\Http\Request;
use App\Session as AppSession;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\CancellationPenaltyFailed;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ChargeRefunded;
use Illuminate\Support\Facades\Session;
use App\Notifications\ChargeRefundUpdated;
use App\Notifications\ExtraSessionBonus;
use App\Notifications\InvoicePaymentFailed;
use App\Notifications\NotEnoughBalance;
use App\Notifications\PayoutFailed;
use App\Notifications\PayoutPaid;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UnpaidInvoiceReminder;
use Illuminate\Support\Facades\Cache;

class StripeApiController extends Controller
{
    private static $CANCEL_PENALTY_AMOUNT = 500;
    private static $APPLICATION_FEE_PERCENT = 0.1;
    CONST CUSTOMER_HAS_CARDS_CACHE_KEY = 'CUSTOMER_HAS_CARDS';

    public function __construct() {
        if (env('APP_ENV') == 'local'){
            Stripe::setApiKey(env('STRIPE_TEST_KEY'));
        }
        else if (env('APP_ENV') == 'production'){
            Stripe::setApiKey(env('STRIPE_LIVE_KEY'));
        }
    }

    public function redirectToPayment(AppSession $session) {
        return redirect($this->getPaymentUrl($session));
    }

    // Generates a link for user to create/update account
    // Request should contain 'refresh_url' and 'return url'
    // Returns 'stripe_url'
    public function createAccountLink(Request $request) {
        $user = Auth::user();
        $payment_method = $user->paymentMethod;

        // Creates account only if user has no account
        if (!isset($payment_method->stripe_account_id) || trim($payment_method->stripe_account_id) === '') {
            $account = Account::create([
                'country' => 'US',
                'type' => 'express',
                'settings' => ['payouts' => ['schedule' => [
                    'delay_days' => 7,  // TODO: discuss payout schedule
                    'interval' => 'daily'
                ]]]
            ]);

            $account_links = AccountLink::create([
                'account' => $account->id,
                'refresh_url' => route('payment.stripe.check'),
                'return_url' => route('payment.stripe.check'),
                'type' => 'account_onboarding',
            ]);
            Session::put('stripe_account_id', $account->id);
        } else {
            $account_links = Account::createLoginLink(
                $payment_method->stripe_account_id, [
                    'redirect_url' => route('home.profile'),
                ]
            );
        }
        return response()->json([
            'stripe_url' => $account_links->url
        ]);
    }


    // Saving a card
    public function createSetupIntent(Request $request) {
        $customer_id = $this->getCustomerId();
        $setup_intent = SetupIntent::create([
            'customer' => $customer_id,
            'usage' => 'off_session'
        ]);
        return response()->json([
            'clientSecret' => $setup_intent->client_secret
        ]);
    }

    // input: a stripe card
    // Request $request
    public function checkIfCardAlreadyExists(Request $request){
        $requestToken = $request->input("token");


        $token = \Stripe\Token::retrieve(
            $requestToken["token"]["id"],
            []
          );

        $cards = \Stripe\PaymentMethod::all([
            'customer' => $this->getCustomerId(),
            'type' => 'card'
        ])->data;

        foreach($cards as $card) {
            if ($card->card->fingerprint == $token->card->fingerprint){
                return response()->json([
                    'error' => "card already exists"
                ],400);
            }
        }
        return response()->json([
            'success' => "card is unique"
        ]);

    }

    // Lists all cards of the current user
    public function listCards(Request $request) {
        $cards = \Stripe\PaymentMethod::all([
            'customer' => $this->getCustomerId(),
            'type' => 'card'
        ])->data;

        // cache values
        Cache::forget(self::getCustomerHasCardsCacheKey());
        $hasCard = false;
        if (count($cards) >= 1){
            $hasCard = true;
        }else{
            $hasCard = false;
        }
        // cache value
        Cache::remember(self::getCustomerHasCardsCacheKey(), 3600, function () use($hasCard) {
            return $hasCard;
        });

        // get default payment(invoice)
        $default_payment_id = $this->getCustomerDefaultPaymentId();

        $result = [];
        $payment_method_ids = [];
        // push each card to array
        foreach ($cards as $card) {
            $is_default = $card->id == $default_payment_id? "true" : "false";
            array_push($payment_method_ids,[
                'card_id' => $card->id,
            ]);

            array_push($result, [
                'card_holder' => $card->name,
                'brand' => $card->card->brand,
                'exp_month' => $card->card->exp_month,
                'exp_year' => $card->card->exp_year,
                'last4' => $card->card->last4,
                'is_default' => $is_default
            ]);
        }
        Session::put("payments",$payment_method_ids);
        return response()->json([
            'cards' => $result
        ]);
    }

    // true or false if there's card
    public static function getCustomerHasCardsCacheKey(){
        return self::CUSTOMER_HAS_CARDS_CACHE_KEY . "-" . Auth::user()->id;
    }
    public static function customerHasCards(){
        $hasCard = Cache::get(self::getCustomerHasCardsCacheKey());
        if ($hasCard){
            return $hasCard;
        }
        $cards = \Stripe\PaymentMethod::all([
            'customer' => Self::getCustomerId(),
            'type' => 'card'
        ])->data;

        if (count($cards) >= 1){
            $hasCard = true;
        }else{
            $hasCard = false;
        }

        // cache value
        Cache::remember(self::getCustomerHasCardsCacheKey(), 3600, function () use($hasCard) {
            return $hasCard;
        });

        return $hasCard;
    }

    private function getCustomerDefaultPaymentId(){
        $customer_id = $this->getCustomerId();
        $customer = \Stripe\Customer::retrieve($customer_id, []);
        $default_payment_id = $customer->invoice_settings->default_payment_method;
        return $default_payment_id;
    }

    private function convertFakePaymentIDToRealID($id){
        $current_payment = Session::get("payments");
        $payment_method_id =  $current_payment[$id]["card_id"];
        return $payment_method_id;
    }

    // Redirected by Stripe
    public function checkAccountDetail(Request $request) {
        $account_id = Session::get('stripe_account_id');
        $account = Account::retrieve($account_id, []);
        // Log::debug('StripeApiController: '.$account);
        if ($account->details_submitted) {
            $user = User::find(Auth::user()->id);
            $payment_method = $user->paymentMethod;
            $payment_method->stripe_account_id = $account->id;
            $payment_method->save();
            return redirect()->route('home.profile')->with(['successMsg' => 'Succeeded']);
        } else {
            return redirect()->route('home.profile')->with(['errorMsg' => 'Failed']);
        }
    }

    // Gets the customer_id of current user
    // Creates one if it doesn't exist
    private static function getCustomerId() {
        $user = Auth::user();
        $payment_method = $user->paymentMethod;
        if (!isset($payment_method->stripe_customer_id) || trim($payment_method->stripe_customer_id) === '') {
            $customer = Customer::create([
                'name' => $user->first_name.' '.$user->last_name,
                'email' => $user->email,
                // 'email' => 'nateohuang@gmail.com' // Testing
            ]);
            $customer_id = $customer->id;
            $payment_method->stripe_customer_id = $customer_id;
            $payment_method->save();
        } else {
            $customer_id = $payment_method->stripe_customer_id;
        }
        return $customer_id;
    }

    // Finalize an Invoice and confirm its PaymentIntent
    // Metadata differentiates transaction and penalty
    public function finalizeInvoice($invoice_id, $is_cancellation_penalty = false) {
        $invoice = \Stripe\Invoice::retrieve($invoice_id);
        $invoice->finalizeInvoice();

        // Confirm payment intent
        $payment_intent_id = $invoice->payment_intent;
        $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);

        try {
            $payment_intent->confirm();
        } catch (\Stripe\Exception\CardException $e) {
            Log::debug('Error when confirming payment intent: '.$e->getMessage());
            return;
        }
        if ($is_cancellation_penalty) {
            return;
        }

        $transaction = Transaction::where("invoice_id",$invoice_id)->get()[0];

        // $invoice->sendInvoice();

        // change invoice status
        $transaction->invoice_status = $invoice->status;
        $transaction->save();

        // Send email if extra bonus exists
        if ($transaction->extra_bonus_amount > 0) {
            Notification::route('mail', 'tutorspaceusc@gmail.com')
                ->notify(new ExtraSessionBonus($transaction->session, $transaction->extra_bonus_amount));
        }
    }

    // Save card as Default
    // Request should contain 'paymentMethodID'
    public function saveCardAsDefault(Request $request) {
        // fake id or not, convert to real if fake
        if ($request->input('isFake') == "false"){
            $payment_method_id = $request->input('paymentMethodID');
        }else{
            $id = $request->input('paymentMethodID');
            $payment_method_id =  $this->convertFakePaymentIDToRealID($id);
        }
        $customer_id = $this->getCustomerId();
        $customer = \Stripe\Customer::update($customer_id, [
            'invoice_settings' => ['default_payment_method' => $payment_method_id]
        ]);
    }

    // detach a payment from customer
    public function detachPayment(Request $request) {
        // convert to real payment id
        if ($request->input('isFake') == "false"){
            $payment_method_id = $request->input('paymentMethodID');
        }else{
            $id = $request->input('paymentMethodID');
            $payment_method_id =  $this->convertFakePaymentIDToRealID($id);
        }

        $customer_id = $this->getCustomerId();

        // get all cards
        $cards = \Stripe\PaymentMethod::all([
            'customer' => $this->getCustomerId(),
            'type' => 'card'
        ])->data;

        //get default
        $default_payment_id = $this->getCustomerDefaultPaymentId();

        // return errors
        if (count($cards) <= 1) {
            return response()->json([
                'errorMsg' => "need to have at least one payment"
            ], 400);
        }

        if ($payment_method_id == $default_payment_id) {
            return response()->json([
                'errorMsg' => "cannot delete default payment"
            ], 400);
        }

        // todo: make sure this works
        // can delete only when cards > 1 and not the default method
        if (count($cards) > 1 && $payment_method_id != $default_payment_id){

            if (env('APP_ENV') == 'local'){
                $stripe = new \Stripe\StripeClient(
                    env("STRIPE_TEST_KEY")
                  );
            }
            else if (env('APP_ENV') == 'production'){
                $stripe = new \Stripe\StripeClient(
                    env('STRIPE_LIVE_KEY')
                  );
            }
              $stripe->paymentMethods->detach(
                $payment_method_id,
                []
            );
        }

        // success
        return response()->json([
            'success' => "payment deleted successfully!"
        ], 200);

    }

    public function userRequestRefund(Request $request, AppSession $session) {
        // 1. the authenticated user must be the student in that session
        // 2. not refunded and already past
        // 3. transaction is paid
        $userId = Auth::user()->id;
        $acceptedUserIds = array($session->student_id);
        // session validation
        if (!$session || !in_array($userId, $acceptedUserIds) || $session->is_cancel == 1 || $session->is_upcoming == 1 ) {
            return response()->json([
                'errorMsg' => "Validation fails"
            ], 400);
        }

        $transaction = $session->transaction();
        // transaction validation
        if (!$transaction || $transaction->invoice_status != "paid"){
            return response()->json([
                'errorMsg' => "Validation fails"
            ], 400);
        }

        if($transaction->refund_status == null) {
            $transaction->refund_status = 'user_initiated';
            $transaction->refund_requested_time = Carbon::now();
            $transaction->save();
            $msg = "Successfully requested the refund. Please wait for several days for the request to be processed.";
        } else if($transaction->refund_status == 'user_initiated') {
            $msg = "You already made the request. Please wait it to be processed.";
        } else if($transaction->refund_status == 'pending') {
            $msg = "You already made the request. Please wait it to be processed.";
        } else if($transaction->refund_status == 'canceled') {
            $msg = "Your refund request is declined. Please contact tutorspaceusc@gmail.com for more details.";
        } else if($transaction->refund_status == 'succeeded') {
            $msg = "Your refund request is successful. You cannot make another refund request for the same session.";
        } else if($transaction->refund_status == 'failed') {
            $msg = "Your refund request failed. Please contact tutorspaceusc@gmail.com for more details.";
        }

        return response()->json([
            'successMsg' => $msg
        ]);
    }

    // Approve a refund request for a session
    // Request should contain 'session_id'
    public function approveRefund(Request $request, AppSession $session) {
        $transaction = $session->transaction();

        // Already refunded
        if (isset($transaction->refund_id) && trim($transaction->refund_id) != '') {
            Log::error('Trying to refund a refunded transaction');
            return redirect()->route('index')->with(['errorMsg' => 'Failed']);
        }

        // Refund invoice
        $invoice = \Stripe\Invoice::retrieve($transaction->invoice_id);
        // Handle depending on status of invoice
        switch ($invoice->status) {
            case 'paid':  // Already paid
                Log::info('Refund paid invoice');
                $payment_intent_id = $invoice->payment_intent;
                $refund = \Stripe\Refund::create([
                    'payment_intent' => $payment_intent_id,
                    'reverse_transfer' => true,
                    'refund_application_fee' => true,
                ]);
                $transaction->refund_id = $refund->id;
                $transaction->refund_status = 'pending';
                $transaction->save();
                break;

            default:  // Other cases
                Log::error('Invalid invoice status when deleting invoice with id: ' . $invoice->id);
                return redirect()->route('index')->with(['errorMsg' => 'Failed']);
        }

        return redirect()->route('payment.stripe.refund.index')->with(['successMsg' => 'Succeeded']);
    }

    // Refund a session bonus given 'session'
    private function refundSessionBonus(AppSession $session) {
        if ($session->sessionBonus) {
            $session_bonus = $session->sessionBonus;
            $transfer_reversal = \Stripe\Transfer::createReversal($session_bonus->transfer_id);
            $session_bonus->transfer_reversal_id = $transfer_reversal->id;
            $session_bonus->is_refunded = 1;
            $session_bonus->save();
        }
    }

    // Decline a refund request for a session
    public function declineRefundRequest(Request $request, AppSession $session) {
        $transaction = $session->transaction();
        if ($transaction->refund_status != 'user_initiated') {  // Invalid status
            Log::error('Refund status is not user_initiated. Unable to decline.');
            return redirect()->route('payment.stripe.refund.index')->with(['errorMsg' => 'Failed']);
        }
        $transaction->refund_status = 'canceled';
        $transaction->save();
        return redirect()->route('payment.stripe.refund.index')->with(['successMsg' => 'Succeeded']);
    }

    // Cancels an Invoice
    // return false for error
    // return true for success
    public function cancelInvoice($session_id) {
        $session = AppSession::find($session_id);
        // sesson doesn't exist
        if (!$session){
            Log::error('cannot find the session when canceling invoice');
            return false;
        }

        $transaction = $session->transaction();
        $invoice = \Stripe\Invoice::retrieve($transaction->invoice_id);

        // invoice doesn't exist
        if (!$invoice){
            Log::error('cannot find the invoice when canceling invoice!');
            return false;
        }

        // delete an invoice
        if ( $invoice->status != 'draft') {
            Log::error('Deleting an invoice that is not draft');
            return false;
        } else {
            $invoice->delete();
            $transaction->delete();
            Log::info('successfully deleted the invoice');
            return true;
        }
    }

    // Handle Stripe Account webhooks
    public function handleWebhook(Request $request) {
        $payload = $request->getContent();  // Get raw content

        // Check signature
        $endpoint_secret = env('STRIPE_ENDPOINT_SECRET_ACCOUNT');
        $sig_header = $request->header('stripe-signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            Log::error($e->getMessage());
            return response(null, 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error($e->getMessage());
            Log::error($e->getSigHeader());
            Log::error($e->getHttpBody());
            return response(null, 400);
        }

        Log::info('Webhook received: ' . $event->type);
        // Handle the event depending on its type
        switch ($event->type) {
            case 'invoice.paid':
                $this->handleInvoicePaidEvent($event);
                break;

            case 'invoice.payment_failed':
            // case 'invoice.payment_action_required':
                $this->handleInvoiceFailedEvent($event);
                break;

            case 'charge.succeeded':
                $this->handleChargeSucceededEvent($event);
                break;

            case 'charge.failed':
                $this->handleChargeFailedEvent($event);
                break;

            case 'charge.refunded':
                $this->handleChargeRefundedEvent($event);
                break;

            case 'charge.refund.updated':  // Unlikely to happen
                $this->handleChargeRefundUpdatedEvent($event);
                break;

            // Handle other event types
            default:
                Log::debug('Received unknown event type ' . $event->type);
        }

        return response(null, 200);
    }

    // Handle Stripe Connect webhooks
    public function handleConnectWebhook(Request $request) {
        $payload = $request->getContent();  // Get raw content

        // Check signature
        $endpoint_secret = env('STRIPE_ENDPOINT_SECRET_CONNECT');
        $sig_header = $request->header('stripe-signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            Log::error($e->getMessage());
            return response(null, 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error($e->getMessage());
            Log::error($e->getSigHeader());
            Log::error($e->getHttpBody());
            return response(null, 400);
        }

        Log::info('connect webhook received: ' . $event->type);
        // Handle the event depending on its type
        switch ($event->type) {
            case 'payout.paid':
                $this->handlePayoutPaid($event);
                break;

            case 'payout.failed':
                $this->handlePayoutFailed($event);
                break;

            // Handle other event types
            default:
                Log::debug('Received unknown event type ' . $event->type);
        }

        return response(null, 200);
    }

    /*
        Section starts: webhook helper functions
    */

    private function handleInvoicePaidEvent($event) {
        $invoice = $event->data->object;

        // Is a cancellation penalty
        if ($invoice->metadata->is_cancellation_penalty == 'true') {
            $cancellation_penalty = CancellationPenalty::firstWhere('stripe_object_id', $invoice->id);
            $cancellation_penalty->is_successful = 1;
            $cancellation_penalty->save();
            return;
        }

        // Change database transaction invoice_status => paid
        $transaction = Transaction::where("invoice_id", $invoice->id)->get()[0];
        $transaction->invoice_status = $invoice->status;
        $transaction->save();

        // TODO: send email to user
        $student = $transaction->session->student;
        $student->notify(new InvoicePaid($transaction->session));
    }

    private function handleInvoiceFailedEvent($event) {
        $invoice = $event->data->object;

        // Is a cancellation penalty
        if ($invoice->metadata->is_cancellation_penalty == 'true') {
            $cancellation_penalty = CancellationPenalty::firstWhere('stripe_object_id', $invoice->id);
            Notification::route('mail', 'tutorspaceusc@gmail.com')
                ->notify(new CancellationPenaltyFailed($cancellation_penalty->user_id, $invoice->id));
            return;
        }

        // Change database transaction invoice_status => failed
        $transaction = Transaction::where("invoice_id", $invoice->id)->get()[0];
        $transaction->invoice_status = $invoice->status;
        $transaction->save();

        // TODO: send email to user
        $student = $transaction->session->student;
        $student->notify(new InvoicePaymentFailed($transaction->session));
    }

    private function handleChargeSucceededEvent($event) {
        $charge = $event->data->object;

        // Is a cancellation penalty
        if ($charge->metadata->is_cancellation_penalty == 'true') {
            $cancellation_penalty = CancellationPenalty::firstWhere('stripe_object_id', $charge->id);
            $cancellation_penalty->is_successful = 1;
            $cancellation_penalty->save();
        }
    }

    private function handleChargeFailedEvent($event) {
        $charge = $event->data->object;

        // Is a cancellation penalty
        if ($charge->metadata->is_cancellation_penalty == 'true') {
            $cancellation_penalty = CancellationPenalty::firstWhere('stripe_object_id', $charge->id);
            Notification::route('mail', 'tutorspaceusc@gmail.com')
                ->notify(new CancellationPenaltyFailed($cancellation_penalty->user_id, $charge->id));
        }
    }

    private function handleChargeRefundedEvent($event) {
        $charge = $event->data->object;
        $refund = $charge->refunds->data[0];
        $transaction = Transaction::firstWhere("refund_id", $refund->id);
        $transaction->refund_status = 'succeeded';
        $transaction->save();

        Log::debug('Transaction refunded: ' . $transaction->id);

        // TODO: send email to user of 'transaction'. Refund succeeded
        $student = $transaction->session->student;
        $student->notify(new ChargeRefunded($transaction->session, true));
        $tutor = $transaction->session->tutor;
        $tutor->notify(new ChargeRefunded($transaction->session, false));
    }

    private function handleChargeRefundUpdatedEvent($event) {
        $refund = $event->data->object;

        $failure_reason = $refund->failure_reason;
        $transaction = Transaction::firstWhere("refund_id", $refund->id);
        $transaction->refund_status = 'failed';
        $transaction->save();

        Log::debug('Transaction refund failed: ' . $transaction->id);

        // TODO: send email to user of 'transaction' and us. Refund failed for 'failure_reason'
        $student = $transaction->session->student;
        $student->notify(new ChargeRefundUpdated($transaction->session, true, $failure_reason));

        Notification::route('mail', 'tutorspaceusc@gmail.com')
        ->notify(new ChargeRefundUpdated($transaction->session, false, $failure_reason));
    }

    private function handlePayoutPaid($event) {
        $stripe_account_id = $event->account;
        $payout = $event->data->object;

        $payment_method = PaymentMethod::firstWhere('stripe_account_id', $stripe_account_id);
        $user = $payment_method->user;

        // TODO: send email to 'user'. Payout is sent to bank account
        $user->notify(new PayoutPaid($payout->amount));
    }

    private function handlePayoutFailed($event) {
        $stripe_account_id = $event->account;
        $payout = $event->data->object;

        $payment_method = PaymentMethod::firstWhere('stripe_account_id', $stripe_account_id);
        $user = $payment_method->user;

        // TODO: send email to 'user' and us. Payout failed. They should update bank info
        $user->notify(new PayoutFailed(true, $payout->failure_code));

        Notification::route('mail', 'tutorspaceusc@gmail.com')
        ->notify(new PayoutFailed(false, $payout->failure_code, $stripe_account_id));
    }

    /*
        Section ends: webhook helper functions
    */

    // amount in dollar, done in tutor's side => CANNOT USE USERID!!!!!!!!!!!! USE STUDENT
    public function initializeInvoice($amount, $destination_account_id, $session) {
        $amount = $amount * 100;  // Convert to cent
        // Create Product and Price
        $product = \Stripe\Product::create([
            'name' => 'Tutor Session',
        ]);
        $price = \Stripe\Price::create([
            'product' => $product->id,
            'unit_amount' => $amount,
            'currency' => 'usd',
        ]);

        $student_id = $session->student_id;
        $customer_id = PaymentMethod::where("user_id",$student_id)->get()[0]->stripe_customer_id;

        // Calculate application fee and session bonus
        $tutor = $session->tutor;
        $bonus_rate = $tutor->getUserBonusRate();  // TODO: check bonus rate before session ends
        $bonus_amount = round($amount * $bonus_rate);
        $original_application_fee_amount = round($amount * self::$APPLICATION_FEE_PERCENT);
        if ($original_application_fee_amount >= $bonus_amount) {
            $application_fee_amount = $original_application_fee_amount - $bonus_amount;
            $extra_bonus_amount = 0;
        } else {
            $application_fee_amount = 0;
            $extra_bonus_amount = $bonus_amount - $original_application_fee_amount;
        }

        // Create InvoiceItem and Invoice
        $invoice_item = \Stripe\InvoiceItem::create([
            'customer' => $customer_id,
            'price' => $price->id,
        ]);
        $invoice = \Stripe\Invoice::create([
            'customer' => $customer_id,
            'collection_method' => 'send_invoice',
            'days_until_due' => 7,  // Needed for send_invoice only
            'transfer_data' => [
                'destination' => $destination_account_id,
            ],
            'application_fee_amount' => $application_fee_amount,
        ]);

        // Save transaction in database
        $transaction = new Transaction();
        $transaction->session()->associate($session->id);
        $transaction->user_id = $student_id;

        // change invoice status
        $transaction->invoice_status = "draft";
        $transaction->destination_account_id = $destination_account_id;
        // amount
        $transaction->amount = $amount;
        $transaction->invoice_id = $invoice->id;
        $transaction->bonus_amount = $bonus_amount;
        $transaction->extra_bonus_amount = $extra_bonus_amount;
        $transaction->save();
    }

    // open means unpaid, used for cronjob
    // FACADE
    public function sendOpenInvoiceToCustomer($hoursAfterLastUpdate){
        $transactionsToSend = Transaction::whereRaw("TIMESTAMPDIFF (HOUR, updated_at,'" . Carbon::now() . "') >= ?", $hoursAfterLastUpdate)
        ->where("invoice_status","open")
        ->get();
        // send to each
        forEach ($transactionsToSend as $transaction) {
            $invoiceId = $transaction->invoice_id;
            $invoiceToSend = \Stripe\Invoice::retrieve($invoiceId);
            // send invoice
            // $invoiceToSend->sendInvoice();
            // update last update time
            $transaction->touch();

            // TODO: add link
            // send unpaid invoice mail reminder to tutorspace and user
            $user = User::find($transaction->user_id);
            Notification::route('mail', $user->email)
            ->notify(new UnpaidInvoiceReminder($user));
            Notification::route('mail', "tutorspace@gmail.edu")
            ->notify(new UnpaidInvoiceReminder($user));

            echo "Succesfully send unpaid invoices to customer\n";
        }

    }

    // Get the payment URL of the invoice for 'session'
    // Return URL string
    public function getPaymentUrl(AppSession $session) {
        $transaction = $session->transaction();
        if ($transaction->invoice_status != 'open') {  // Invalid status
            Log::error('Unable to generate payment URL. Invoice status is not open.');
            return "";
        }
        $invoice = \Stripe\Invoice::retrieve($transaction->invoice_id);
        $payment_url = $invoice->hosted_invoice_url;
        return $payment_url;
    }

    // Charge 'user' an amount for cancellation
    public function chargeForCancellation($user) {
        $cancellation_penalty = new CancellationPenalty();
        if ($user->is_tutor) {  // For tutor, create charge
            $account_id = $user->paymentMethod->stripe_account_id;
            $charge = \Stripe\Charge::create([
                'amount' => self::$CANCEL_PENALTY_AMOUNT,
                'currency' => 'usd',
                'description' => 'Cancellation Penalty',
                'source' => $account_id,
                'metadata' => ['is_cancellation_penalty' => 'true']
            ]);

            $cancellation_penalty->stripe_object_id = $charge->id;
        } else {  // For student, create invoice
            $customer_id = $user->paymentMethod->stripe_customer_id;
            $product = \Stripe\Product::create([
                'name' => 'Cancellation Penalty',
            ]);
            $price = \Stripe\Price::create([
                'product' => $product->id,
                'unit_amount' => self::$CANCEL_PENALTY_AMOUNT,
                'currency' => 'usd',
            ]);
            $invoice_item = \Stripe\InvoiceItem::create([
                'customer' => $customer_id,
                'price' => $price->id,
            ]);
            $invoice = \Stripe\Invoice::create([
                'customer' => $customer_id,
                'collection_method' => 'send_invoice',
                'days_until_due' => 7,  // Needed for send_invoice only
                'metadata' => ['is_cancellation_penalty' => 'true']
            ]);
            $this->finalizeInvoice($invoice->id, true);

            $cancellation_penalty->stripe_object_id = $invoice->id;
        }
        $cancellation_penalty->user()->associate($user);
        $cancellation_penalty->save();
    }

    // Get the detailed amount of transaction for 'session'
    public function retrieveTransactionDetails(AppSession $session) {
        $tutor = $session->tutor;
        $transaction = $session->transaction;
        $stripe_payment_fee = round($transaction->amount * 0.029) + 30;  // https://stripe.com/pricing

        if ($transaction->extra_bonus_amount == 0) {
            $application_fee = round($transaction->amount * self::$APPLICATION_FEE_PERCENT) - $transaction->bonus_amount;
            $tutor_receive = $transaction->amount - $application_fee;
            $platform_receive = $application_fee - $stripe_payment_fee;
        } else {
            $application_fee = 0;
            $tutor_receive = $transaction->amount + $transaction->extra_bonus_amount;
            $platform_receive = - $transaction->extra_bonus_amount - $stripe_payment_fee;
        }

        return [
            'amount' => $transaction->amount,
            'application_fee' => $application_fee,
            'bonus' => $transaction->bonus_amount,
            'stripe_payment_fee' => $stripe_payment_fee,
            'tutor_receive' => $tutor_receive,
            'platform_receive' => $platform_receive,
        ];
    }

    public function refundIndex() {
        return view('payment.refund');
    }
}
