<?php

namespace App\Http\Controllers\payment;
use App\Http\Controllers\Controller;
use App\Session as AppSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\AccountLink;
use App\User;
use App\Transaction;
use App\PaymentMethod;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Stripe\Customer;
use Stripe\SetupIntent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvoicePaid;
use App\Notifications\ChargeRefunded;
use App\Notifications\ChargeRefundUpdated;

class StripeApiController extends Controller
{
    // TODO:: facade, other places: instantiate change
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_TEST_KEY'));
    }

    // FIXME: Testing functions
    public function index() {
        return view('payment.stripe_connect');
    }

    public function saveCardIndex() {
        return view('payment.stripe_save_card');
    }

    public function invoiceIndex() {
        return view('payment.stripe_invoice_test');
    }

    public function refundIndex() {
        return view('payment.stripe_refund');
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
    // TODO: facade
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

    // Lists all cards of the current user
    // TODO: facade
    public function listCards(Request $request) {
        $cards = \Stripe\PaymentMethod::all([
            'customer' => $this->getCustomerId(),
            'type' => 'card'
        ])->data;

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
    // facade
    public function customerHasCards(){
        $cards = \Stripe\PaymentMethod::all([
            'customer' => $this->getCustomerId(),
            'type' => 'card'
        ])->data;

        if (count($cards) >= 1){
            return true;
        }
        return false;
    }

    // FACADE!!!
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
    private function getCustomerId() {
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
    public function finalizeInvoice($invoice_id) {
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

        $transaction = Transaction::where("invoice_id",$invoice_id)->get()[0];
        
        // Handle failed payments
        if ($invoice->status != 'paid') {
            // send invoice
            $invoice->sendInvoice();
        }
        // change invoice status
        $transaction->invoice_status = $invoice->status;
        $transaction->save();
    }

    // Save card as Default
    // Request should contain 'paymentMethodID'
    // TODO: facade
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

    // TODO: facade
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

        // TODO: change
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_TEST_KEY')
          );

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

        // can delete only when cards > 1 and not the default method
        if (count($cards) > 1 && $payment_method_id != $default_payment_id){
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

    // Refunds a transaction
    // Request should contain 'transaction_id'
    public function createRefund(Request $request) {
        $transaction_id = $request->input('transaction_id');
        $transaction = Transaction::find($transaction_id);
        // Already refunded
        if (isset($transaction->refund_id) && trim($transaction->refund_id) != '') {
            Log::error('Trying to refund a refunded transaction');
            return redirect()->route('index')->with(['errorMsg' => 'Failed']);
        }

        $invoice = \Stripe\Invoice::retrieve($transaction->invoice_id);
        // Handle depending on status of invoice
        switch ($invoice->status) {
            case 'open':  // Waiting to be paid
                Log::info('Refund open invoice');
                $invoice->voidInvoice();
                $transaction->invoice_status = 'void';
                $transaction->save();
                break;
            
            case 'paid':  // Already paid
                Log::info('Refund paid invoice');
                $payment_intent_id = $invoice->payment_intent;
                $refund = \Stripe\Refund::create([
                    'payment_intent' => $payment_intent_id,
                    'reverse_transfer' => true,
                    'refund_application_fee' => true,
                ]);
                $transaction->refund_id = $refund->id;
                $transaction->save();
                break;
            
            default:  // Other cases
                Log::error('Invalid invoice status when deleting invoice with id: ' . $invoice->id);
                return redirect()->route('index')->with(['errorMsg' => 'Failed']);
        }

        return redirect()->route('index')->with(['successMsg' => 'Succeeded']);
    }

    // Cancels an Invoice
    // return 400 response code for error
    // return 200 response code for success
    public function cancelInvoice($session_id) {
        $session = AppSession::find($session_id);
        $transaction = $session->transaction;
        $invoice = \Stripe\Invoice::retrieve($transaction->invoice_id);

        // invoice doesn't exist
        if (!$invoice){
            Log::error('cannot find the invoice!');
            return response()->json([
                'errorMsg' => "cannot find the invoice!"
            ], 400); 
        }

        // delete an invoice
        if ( $invoice->status != 'draft') {
            Log::error('Deleting an invoice that is not draft');
            return response()->json([
                'errorMsg' => "Deleting an invoice that is not draft"
            ], 400); 
        } else {
            $invoice->delete();
            $transaction->delete();
            return response()->json([
                'success' => "successfully deleted the invoice"
            ], 200); 
        }
    }

    // Handle all Stripe webhooks
    public function handleWebhook(Request $request) {
        $payload = $request->getContent();  // Get raw content
        
        // Check signature
        $endpoint_secret = env('STRIPE_ENDPOINT_SECRET');
        $sig_header = $request->header('stripe-signature');

        Log::debug('Signature: '.$sig_header);
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
                $invoice = $event->data->object;
                Log::debug('invoice.paid received' . $invoice->id);

                // Change database transaction invoice_status => paid
                $transaction = Transaction::where("invoice_id", $invoice->id)->get()[0];
                $transaction->invoice_status = 'paid';
                $transaction->save();

                // todo: send email
                Notification::route('mail', 'tutorspaceusc@gmail.com')
                ->notify(new InvoicePaid());

                break;

            case 'charge.refunded':
                $charge = $event->data->object;
                $refund = $charge->refunds[0];
                $transaction = Transaction::where("refund_id", $refund->id)->get()[0];

                // TODO: send email
                Notification::route('mail', 'tutorspaceusc@gmail.com')
                ->notify(new ChargeRefunded());

                break;

            case 'charge.refund.updated':
                $refund = $event->data->object;
                Log::debug('charge.refund.updated received' . $refund->id);
                
                $failure_reason = $refund->failure_reason;

                // TODO: check refund using email
                Notification::route('mail', 'tutorspaceusc@gmail.com')
                ->notify(new ChargeRefundUpdated());
                break;
                
            // Handle other event types
            default:
                Log::debug('Received unknown event type ' . $event->type);
        }
        
        return response(null, 200);
    }

    // amount in dollar, done in tutor's side => CANNOT USE USERID!!!!!!!!!!!! USE STUDENT
    public function initializeInvoice($amount, $destination_account_id, $session) {
        // Create Product and Price
        $product = \Stripe\Product::create([
            'name' => 'Tutor Session',
        ]);
        $price = \Stripe\Price::create([
            'product' => $product->id,
            'unit_amount' => $amount * 100, // this is cent!
            'currency' => 'usd',
        ]);

        $student_id = $session->student_id;
        $customer_id = PaymentMethod::where("user_id",$student_id)->get()[0]->stripe_customer_id;

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
            'application_fee_amount' => 10,  // TODO: apply application fee (cent)
        ]);

        // Save transaction in database
        $transaction = new Transaction();
        $transaction->session()->associate($session->id);
        $transaction->user_id = $student_id;

        // change invoice status
        $transaction->invoice_status = "draft";
        $transaction->destination_account_id = $destination_account_id;
        // amount 
        $transaction->amount = $amount * 100;
        $transaction->invoice_id = $invoice->id;
        $transaction->save();
    }

    // open means unpaid, used for cronjob
    // FACADE
    public function sendOpenInvoiceToCustomer($hoursAfterLastUpdate){
        $transactionsToSend = Transaction::selectRaw("invoice_id")
        ->whereRaw("TIMESTAMPDIFF (HOUR, updated_at,CURRENT_TIMESTAMP()) >= ?", $hoursAfterLastUpdate) 
        ->where("invoice_status","open")
        ->get();
        // send to each
        forEach ($transactionsToSend as $transaction) {
            $invoiceId = $transaction->invoice_id;            
            $invoiceToSend = \Stripe\Invoice::retrieve($invoiceId);
            // echo $invoiceId;
            // send invoice
            $invoiceToSend->sendInvoice();
            // update last update time
            $model = Transaction::find($transaction->id);
            $model->touch();
        }
    }
}
