<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect as Redirect;
use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Facades\URL;
use PayPal\Api\Amount;
use PayPal\Api\Currency;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payout;
use PayPal\Api\PayoutItem;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

/*
    Payment Controller for paypal.
*/
class PaypalApiController extends Controller
{
    private $_api_context;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        /** PayPal api context **/
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }

    public function index()
    {
        return view('payment.paypal_test_form');
    }

    // Processes payment from user to TutorSpace
    // Request should contain 'amount'
    public function payWithPaypal(Request $request)
    {

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName('Payment to TutorSpace')  // Item name
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount'));

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');  // Description

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('/payment/status'))  // Return URL
            ->setCancelUrl(URL::to('/payment/status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        // Creates payment
        try {

            $payment->create($this->_api_context);

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {

            if (Config::get('app.debug')) {
                Session::put('error', 'Connection timeout');
                return Redirect::to('/payment/paypal_index');

            } else {

                Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/payment/paypal_index');

            }

        }

        foreach ($payment->getLinks() as $link) {

            if ($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();
                break;

            }

        }

        // Adds payment ID to session
        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {

            /** redirect to paypal **/
            return Redirect::away($redirect_url);

        }

        Session::put('error', 'Unknown error occurred');
        return Redirect::to('/payment/paypal_index');

    }

    // Finishes execution
    public function getPaymentStatus()
    {
        // Gets the payment ID from session
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');

        if (empty($_GET['PayerID']) || empty($_GET['token'])) {
            // Error
            Session::put('error', 'Payment failed');
            return Redirect::to('/payment/paypal_index');

        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);

        // Executes the payment
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            // Success
            Session::put('success', 'Payment success');
            return Redirect::to('/payment/paypal_index');

        }

        // Error
        Session::put('error', 'Payment failed');
        return Redirect::to('/payment/paypal_index');

    }

    public function retrieve_index() {
        return view('payment.paypal_retrieve_form');
    }

    // Processes payment from TutorSpace to user
    public function retrieveWithPaypal(Request $request) {
        $payouts = new Payout();
        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid().microtime(true))
            ->setEmailSubject("You have a payment");

        $amount = new Currency();
        $amount->setCurrency('USD');
        $amount->setValue($request->get('amount'));
        $senderItem = new PayoutItem();

        // Detailed info
        $senderItem->setRecipientType('Email')
            ->setNote('Thanks you.')
            ->setReceiver($request->get('email'))
            ->setSenderItemId("item_1" . uniqid().microtime('true'))
            ->setAmount($amount);

        $payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem);

        try {
            $output = $payouts->create(null, $this->_api_context);
        } catch (Exception $ex) {
            // Error
            if (Config::get('app.debug')) {
                Session::put('error', 'Connection timeout');
                return Redirect::to('/payment/paypal_retrieve_index');

            } else {

                Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/payment/paypal_retrieve_index');

            }
        }
        // Success
        return Redirect::to('/payment/paypal_retrieve_index');
    }

}
