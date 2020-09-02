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
use Stripe\Refund;
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

    // Generates a link for user to create/update account
    // Request should contain 'refresh_url' and 'return url'
    // Returns 'stripe_url'
    public function createAccountLink(Request $request) {
        // FIXME: Delete this
        Auth::attempt(['email' => 'student@usc.edu', 'password' => 'password']);
        $user = User::find(Auth::user()->id);
        // Creates account only if user has no account
        if (!isset($user->stripe_account_id) || trim($user->stripe_account_id) === '') {
            $account = Account::create([
                'country' => 'US',
                'type' => 'express',
            ]);
            $user->stripe_account_id = $account->id;
            $user->save();
            $account_links  = AccountLink::create([
                'account' => $user->stripe_account_id,
                'refresh_url' => $request->get('refresh_url'),
                'return_url' => $request->get('return_url'),
                'type' => 'account_onboarding',
            ]);
        } else {
            $account_links = Account::createLoginLink(
                $user->stripe_account_id, []
            );
        }
        return response()->json([
            'stripe_url' => $account_links->url
        ]);
    }

    // Charges current user
    // Request should contain 'amount'
    public function processCharge(Request $request) {
        $account_id = Auth::user()->stripe_account_id;
        // $amount = intval($request->json('amount'));
        $charge = \Stripe\Charge::create([
            'amount'   => $request->get('amount'),
            'currency' => 'usd',
            'source' => $account_id
        ]);
        // TODO: Add charge id to database and Refund
        Session::put('status', $charge->status);
        return view('payment.stripe_connect');
    }

    // Refunds a charge
    // Request should contain 'charge_id'
    public function refundCharge(Request $request) {
        $charge_id = $request->get('charge_id');
        $refund = Refund::create(['charge' => $charge_id]);
        Session::put('status', $refund->status);
        if ($refund->status != 'succeeded') {
            Session::put('failure_reason', $refund->failure_reason);
        }
        return view('payment.stripe_connect');
    }

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
        Session::put('status', 'success');
        return view('payment.stripe_connect');
    }

}
