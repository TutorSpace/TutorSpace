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

class StripeApiController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_TEST_KEY'));
    }

    public function index() {
        return view('payment.stripe_connect');
    }

    public function saveCardIndex() {
        return view('payment.stripe_save_card');
    }

    // Generates a link for user to create/update account
    // Request should contain 'refresh_url' and 'return url'
    // Returns 'stripe_url'
    public function createAccountLink(Request $request) {
        $user = Auth::user();
        $payment_method = $user->paymentMethod;

        // Creates account only if user has no account
        if (!isset($payment_method->stripe_account_id) || trim($payment_method->stripe_account_id) === '') {

            // todo: fix this
            // return response()->json([

            // ]);

            $account = Account::create([
                'country' => 'US',
                'type' => 'express',
                'settings' => ['payouts' => ['schedule' => [
                    'delay_days' => 2,  // TODO: discuss payout schedule
                    'interval' => 'daily'
                ]]]
            ]);

            $account_links = AccountLink::create([
                'account' => $account->id,
                'refresh_url' => url('/payment/check'),
                'return_url' => url('/payment/check'),
                'type' => 'account_onboarding',
            ]);
            // todo: examine what this stripe_account_id is for
            Session::put('stripe_account_id', $account->id);
        } else {
            $account_links = Account::createLoginLink(
                $payment_method->stripe_account_id, []
            );
        }
      
        return response()->json([
            'stripe_url' => $account_links->url
        ]);


       
    }

    /*
        Section starts: previous implementation
    */

    // Creates a payment intent with new cards
    public function createPaymentIntent(Request $request) {
        $customer_id = $this->getCustomerId();
        $amount = intval($request->json('amount'));
        // TODO: target connected account
        $payment_intent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'customer' => $customer_id,
            'receipt_email' => Auth::user()->email,
            // TODO: add metadata
            // 'application_fee_amount' => 123,
            // 'transfer_data' => [
            //     'destination' => '{{CONNECTED_STRIPE_ACCOUNT_ID}}',
            // ],
        ]);
        return response()->json([
            'clientSecret' => $payment_intent->client_secret
        ]);
    }

    // Creates a payment intent with preset cards
    public function createPaymentIntentWithCard(Request $request) {
        $customer_id = $this->getCustomerId();
        $card_num = intval($request->json('card_num'));
        $payment_methods = \Stripe\PaymentMethod::all([
            'customer' => $customer_id,
            'type' => 'card'
        ]);
        $payment_intent = \Stripe\PaymentIntent::create([
            'amount' => intval($request->json('amount')),
            'currency' => 'usd',
            'payment_method' => $payment_methods->data[$card_num]->id,
            'customer' => $customer_id,
        ]);
        return response()->json([
            'clientSecret' => $payment_intent->client_secret,
            'paymentMethodId' => $payment_methods->data[$card_num]->id
        ]);
    }

    // Confirms a card payment with preset cards
    public function confirmPaymentIntent(Request $request) {
        $payment_intent_id = $request->json('payment_intent_id');
        $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        $payment_intent->confirm();
        return response()->json([
            'success' => true
        ]);
    }

    /*
        Section ends: previous implementation
    */

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

    // Lists all cards of the current user
    public function listCards(Request $request) {
        $cards = \Stripe\PaymentMethod::all([
            'customer' => $this->getCustomerId(),
            'type' => 'card'
        ])->data;


        // get default payment(invoice)
        $default_payment_id = $this->getCustomerDefaultPaymentId();

        $result = [];
        $payment_method_ids = [];
        foreach ($cards as $card) {
            $is_default = $card->id == $default_payment_id? "true" : "false";
            array_push($payment_method_ids,[
                'card_id' => $card->id,
            ]);

            array_push($result, [
                // 'card_id' => $card->id,
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

    // Redirected by Stripe
    public function checkAccountDetail(Request $request) {
        $account_id = Session::get('stripe_account_id');
        $account = Account::retrieve($account_id, []);
        Log::debug('StripeApiController: '.$account);
        if ($account->details_submitted) {
            $user = User::find(Auth::user()->id);
            $payment_method = $user->paymentMethod;
            $payment_method->stripe_account_id = $account->id;
            $payment_method->save();
            // TODO: change route
            return redirect()->route('index')->with(['successMsg' => 'Succeeded']);
        } else {
            return redirect()->route('index')->with(['errorMsg' => 'Failed']);
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
                // 'email' => $user->email,  // TODO: change back to user email
                'email' => 'nateohuang@gmail.com'
            ]);
            $customer_id = $customer->id;
            $payment_method->stripe_customer_id = $customer_id;
            $payment_method->save();
        } else {
            $customer_id = $payment_method->stripe_customer_id;
        }
        return $customer_id;
    }

    /*
        Section starts: implementation using Invoice
    */

    public function invoiceIndex() {
        return view('payment.stripe_invoice_test');
    }

    // Request should contain 'amount' and 'destination_account_id', TODO: delete this method
    public function createInvoice(Request $request) {
        $amount = intval($request->get('amount'));
        $destination_account_id = $request->get('destination_account_id');

        // Create Product and Price
        $product = \Stripe\Product::create([
            'name' => 'Tutor Session',
        ]);
        $price = \Stripe\Price::create([
            'product' => $product->id,
            'unit_amount' => $amount,
            'currency' => 'usd',
        ]);

        $customer_id = $this->getCustomerId();

        // Create InvoiceItem and Invoice
        $invoice_item = \Stripe\InvoiceItem::create([
            'customer' => $customer_id,
            'price' => $price->id,
        ]);
        $invoice = \Stripe\Invoice::create([
            'customer' => $customer_id,
            // 'collection_method' => 'charge_automatically',
            'collection_method' => 'send_invoice',
            'days_until_due' => 1,  // Needed for send_invoice only, TODO: needs check
            'transfer_data' => [
                'destination' => $destination_account_id,
            ],
            'application_fee_amount' => 10,  // TODO: apply application fee
        ]);

        // $this->finalizeInvoice($invoice->id);
        // TODO: Save invoice in database






        return redirect()->route('invoice_index')->with([
            'invoice_id' => $invoice->id,
        ]);
    }

    // TODO: change to invoice status
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
        }

        Log::debug('PaymentIntent status: '.$payment_intent->status);
        $transaction = Transaction::where("invoice_id",$invoice_id)->get()[0];
        // Handle failed payments
        if ($invoice->status != 'paid') {
            // send invoice
           
            $invoice->sendInvoice();
        }
        
        // TODO: unnecessary
        $transaction->payment_intent_id = $payment_intent_id;
        $transaction->invoice_status = $invoice->status;
        $transaction->save();
    
        Log::debug('invoice status: '.$invoice->status);


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

    // Refunds a PaymentIntent
    // Request should contain 'payment_intent_id'
    public function refundPaymentIntent(Request $request) {
        $payment_intent_id = $request->input('payment_intent_id');

        $refund = \Stripe\Refund::create([
            'payment_intent' => $payment_intent_id,
            'reverse_transfer' => true,
            'refund_application_fee' => true,
        ]);

        // TODO: save refund id
    }

    
    // Cancels an Invoice
    // return 400 response code for error
    // return 200 response code for success
    public function cancelInvoice($session_id) {
        $session = AppSession::find($session_id);
        $transaction = $session->transaction;
        $invoice = \Stripe\Invoice::retrieve($transaction->invoice_id);
        Log::debug('invoice status before'.$invoice->status);

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

    /*
        Section ends: implementation using Invoice
    */

    // Handle all Stripe webhooks
    public function handleWebhook(Request $request) {
        $payload = $request->all();
        
        // // 1 - Using signature
        // $endpoint_secret = env('STRIPE_ENDPOINT_SECRET');
        // $sig_header = $request->header('stripe-signature');

        // Log::debug('Signature: '.$sig_header);
        // try {
        //     $event = \Stripe\Webhook::constructEvent(
        //         json_encode($payload), $sig_header, $endpoint_secret
        //     );
        // } catch(\UnexpectedValueException $e) {
        //     // Invalid payload
        //     Log::error($e->getMessage());
        //     return response(null, 400);
        // } catch(\Stripe\Exception\SignatureVerificationException $e) {
        //     // Invalid signature
        //     Log::error($e->getMessage());
        //     return response(null, 400);
        // }

        // 2 - Using API
        try {
            $event = \Stripe\Event::constructFrom(
                $payload
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            Log::error($e->getMessage());
            return response(null, 400);
        }

        Log::debug('Webhook received: '.$event->type);
        // Handle the event depending on its type
        switch ($event->type) {
            case 'invoice.paid':
                $invoice = $event->data->object;
                Log::debug('invoice.paid received'.$invoice->id);
                break;
            case 'charge.refund.updated':
                $refund = $event->data->object;
                Log::debug('charge.refund.updated received'.$refund->id);
                break;
            // Handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }
        
        return response(null, 200);
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

    public function testSaveCard() {
        return view('payment.stripe_save_card');
    }

    // TODO: true or false if there's card, format of response??
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

    // !!!!!!!!!!!!!!
    // !!!!!!!!!!!!!!
    // !!!!!!!!!!!!!!
    // !!!!!!!!!!!!!!
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


        //TODO: change to student id
        $student_id = $session->student_id;
        $customer_id = PaymentMethod::where("user_id",$student_id)->get()[0]->stripe_customer_id;
        //TODO: error checking : has id has payment method




        // Create InvoiceItem and Invoice
        $invoice_item = \Stripe\InvoiceItem::create([
            'customer' => $customer_id,
            'price' => $price->id,
        ]);
        $invoice = \Stripe\Invoice::create([
            'customer' => $customer_id,
            // 'collection_method' => 'charge_automatically',
            'collection_method' => 'send_invoice',
            'days_until_due' => 1,  // Needed for send_invoice only, TODO: needs check
            'transfer_data' => [
                'destination' => $destination_account_id,
            ],
            'application_fee_amount' => 10,  // TODO: apply application fee
        ]);

        // Save transaction in database
        $transaction = new Transaction();
        $transaction->session()->associate($session->id);
        $transaction->user_id = $student_id;

        // TODO: payment intent appear only when finalized
        // $transaction->payment_intent_id = $invoice->payment_intent;

        $transaction->invoice_status = "draft";
        $transaction->destination_account_id = $destination_account_id;
        $transaction->amount = $amount * 100;
        // TODO: delete
        $transaction->is_cancelled = 0;



        $transaction->invoice_id = $invoice->id;
        $transaction->save();


    }
}
