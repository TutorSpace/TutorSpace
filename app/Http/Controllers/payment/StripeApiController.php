<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\AccountLink;
use App\User;
use Illuminate\Support\Facades\Session;
use Stripe\Balance;
use Stripe\Customer;
use Stripe\Refund;
use Stripe\SetupIntent;
use Stripe\Topup;
use Stripe\Transfer;

class StripeApiController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_TEST_KEY'));
    }

    public function index() {
        return view('payment.stripe_connect');
    }

    public function payIndex() {
        return view('payment.stripe_test_form');
    }

    public function saveCardIndex() {
        return view('payment.stripe_save_card');
    }

    // Generates a link for user to create/update account
    // Request should contain 'refresh_url' and 'return url'
    // Returns 'stripe_url'
    public function createAccountLink(Request $request) {
        // FIXME: Delete this
        Auth::attempt(['email' => 'student@usc.edu', 'password' => 'password']);
        $user = User::find(Auth::user()->id);
        $payment_method = $user->paymentMethod;
        // Creates account only if user has no account
        if (!isset($payment_method->stripe_account_id) || trim($payment_method->stripe_account_id) === '') {
            $account = Account::create([
                'country' => 'US',
                'type' => 'express',
            ]);
            $account_links = AccountLink::create([
                'account' => $account->id,
                'refresh_url' => url('/payment/check'),
                'return_url' => url('/payment/check'),
                'type' => 'account_onboarding',
            ]);
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
            // TODO:
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

    // Saving a card
    public function createSetupIntent(Request $request) {
        $customer_id = $this->getCustomerId();
        $setup_intent = SetupIntent::create([
            'customer' => $customer_id
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
        $result = [];
        foreach ($cards as $card) {
            array_push($result, [
                'brand' => $card->card->brand,
                'exp_month' => $card->card->exp_month,
                'exp_year' => $card->card->exp_year,
                'last4' => $card->card->last4
            ]);
        }
        // TODO: change route
        return view('payment.stripe_reuse_card')->with('cards', $result);
    }

    // Redirected by Stripe
    public function checkAccountDetail(Request $request) {
        $account_id = Session::get('stripe_account_id');
        $account = Account::retrieve($account_id, []);
        if ($account->details_submitted) {
            $user = User::find(Auth::user()->id);
            $payment_method = $user->paymentMethod;
            $payment_method->email = $user->email;
            $payment_method->stripe_account_id = $account->id;
            $payment_method->save();
            // TODO: change route
            return redirect()->route('index')->with(['successMsg' => 'Succeeded']);
        } else {
            return redirect()->route('index')->with(['errorMsg' => 'Failed']);
        }
    }

    // Refunds a charge
    // Request should contain 'charge_id'
    // TODO:
    public function refundCharge(Request $request) {
        $charge_id = $request->get('charge_id');
        $refund = Refund::create(['charge' => $charge_id]);
        Session::put('status', $refund->status);
        // TODO: database
        if ($refund->status != 'succeeded') {
            Session::put('failure_reason', $refund->failure_reason);
        }
        return view('payment.stripe_connect');
    }

    // TODO: delete
    // Pays out to current user
    // Request should contain 'amount'
    public function processPayout(Request $request) {
        $amount = intval($request->get('amount'));
        $balance = Balance::retrieve();
        if ($balance->available[0]->amount < $amount) {
            // $topup = Topup::create([
            //     'amount' => $amount - $balance->available[0]->amount,
            //     'currency' => 'usd',
            //     'description' => 'Top-up on '.date("Y-m-d H:i:s"),
            //     'statement_descriptor' => 'One-time top-up',
            // ]);
            // if ($topup->status != 'success') {
            //     Session::put('status', 'failed');
            //     return view('payment.stripe_connect');
            // }
            Session::put('status', 'failed');
            return view('payment.stripe_connect');
        }
        $transfer = Transfer::create([
            'amount' => $amount,
            'currency' => 'usd',
            'destination' => Auth::user()->stripe_account_id,
        ]);
        // TODO: database?
        Session::put('status', 'success');
        return view('payment.stripe_connect');
    }

    // Gets the customer_id of current user
    // Creates one if it doesn't exist
    private function getCustomerId() {
        // FIXME: Delete this
        Auth::attempt(['email' => 'student@usc.edu', 'password' => 'password']);
        $user = User::find(Auth::user()->id);
        $payment_method = $user->paymentMethod;
        if (!isset($payment_method->stripe_customer_id) || trim($payment_method->stripe_customer_id) === '') {
            $customer = Customer::create([
                'email' => $user->email
            ]);
            $customer_id = $customer->id;
            $payment_method->email = $user->email;
            $payment_method->stripe_customer_id = $customer_id;
            $payment_method->save();
        } else {
            $customer_id = $payment_method->stripe_customer_id;
        }
        return $customer_id;
    }
}
