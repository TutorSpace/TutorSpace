<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session as Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Illuminate\Support\Facades\Log;
use Stripe\Account;
use Stripe\AccountLink;
use App\User;

class StripeApiController extends Controller
{

    private $account_id_ = "acct_1HDuIHHfd3Aoz8fx";

    public function __construct()
    {
        Stripe::setApiKey('sk_test_51H6RWlBtUwiw0w2oea2KC7E1uIQ11zes7Oi5kNhYTbsnVvMNCAQ9mIhOtet3prL0ZMai7Ru4inulT0D8oydWPAOt00XVTc8P83');
    }

    public function index() {
        return view('payment.stripe_test_form');
    }

    // Generates a link for user to create/update account
    // Request should contain 'refresh_url' and 'return url'
    // Returns 'stripe_url'
    public function createAccountLink(Request $request) {
        $user = User::find(Auth::user()->id);
        // Creates account only if user has no account
        if (is_null($user->stripe_account_id)) {
            $account = Account::create([
                'country' => 'US',
                'type' => 'express',
            ]);
            $account_links = AccountLink::create([
                'account' => $account->id,
                'refresh_url' => $request->refresh_url,
                'return_url' => $request->return_url,
                'type' => 'account_onboarding',
            ]);
            $user->stripe_account_id = $account->id;
            $user->save();
        } else {
            $account_links  = AccountLink::create([
                'account' => $user->stripe_account_id,
                'refresh_url' => $request->refresh_url,
                'return_url' => $request->return_url,
                'type' => 'account_update',
            ]);
        }
        return response()->json([
            'stripe_url' => $account_links->url
        ]);
    }

    // FIXME: Delete function
    public function processPayment(Request $request) {
        $amount = intval($request->json('amount'));
        Log::debug("From request: ".$amount);
        $customer = Customer::create();
        $paymentIntent = PaymentIntent::create([
            'amount' => 1400,
            'currency' => 'usd',
            'customer' => $customer->id,
            'setup_future_usage' => 'off_session',
          ]);

          $output = [
            'status' => 'success',
            'clientSecret' => $paymentIntent->client_secret,
          ];

        return response()->json($output);
        // Session::put('clientSecret', $paymentIntent->client_secret);
        // return Redirect::to('/payment/stripe_index');
    }

    public function chargeUser(Request $request) {
        $account_id = Auth::user()->stripe_account_id;
        $amount = intval($request->json('amount'));
        $charge = \Stripe\Charge::create([
            'amount'   => $amount,
            'currency' => 'usd',
            'source' => $account_id
        ]);
        // TODO: Add charge id to database and Refund
    }

    // TODO: Refund function

    public function processPayout(Request $request) {
        $balance = \Stripe\Balance::retrieve();
        Session::put('balance', $balance->available[0]->amount);
        $login_url = \Stripe\Account::createLoginLink($this->account_id_)->url;
        Session::put('login_url', $login_url);
        $transfer = \Stripe\Transfer::create([
            "amount" => 1200,
            "currency" => "usd",
            "destination" => $this->account_id_,
          ]);
        return Redirect::to('/payment/stripe_index');
    }
}
