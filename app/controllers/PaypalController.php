<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class PaypalController extends \BaseController
{

    /**
     * @var ApiContext
     */
    private $_api_context;

    /**
     * PaypalController constructor.
     */
    public function __construct()
    {
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    /**
     * @return mixed
     */
    public function postPayment()
    {

        $sesid = Input::get('id');
        Session::put('carid', $sesid);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName(Input::get('product_id'))
            ->setCurrency('EUR')
            ->setQuantity(Input::get('quantity'))
            ->setPrice(Input::get('price'));

        $items[] = $item;
        $itemlist = new ItemList();
        $itemlist->setItems($items);
        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal(Input::get('total'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($itemlist)->setDescription('THis is Demo Transaction');
        $redirect_url = new RedirectUrls();
        $redirect_url->setReturnUrl(URL::route('payment.status'))
            ->setCancelurl(URL::route('payment.status'));
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_url)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EQL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else {
                die('SOme Error Occur, Sorry');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            return Redirect::away($redirect_url);
        }
        return Redirect::route('original.route')->with('error', 'Unknown Error occured');

    }

    /**
     * @return mixed
     */
    public function getPaymentStatus()
    {
        $payment_id = Session::get('paypal_payment_id');

        // clear the session payment ID
        Session::forget('paypal_payment_id');

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            return Redirect::route('payment.success')
                ->with('error', 'Payment failed');
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') { // payment made
            return Redirect::route('home')
                ->with('message', 'Payment success');
        }
        return Redirect::route('home')
            ->with('error', 'Payment failed');
    }
}
