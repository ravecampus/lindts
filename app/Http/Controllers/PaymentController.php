<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Payment;
use App\Models\PaymentReserve;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class PaymentController extends Controller
{
    private $gateway;
   
    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true); //set it to 'false' when go live
    }
   
    /**
     * Call a view.
     */
    public function index()
    {
        // return view('payment');
    }
   
    /**
     * Initiate a payment on PayPal.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function charge(Request $request)
    {
      
        try {
            $response = $this->gateway->purchase(array(
                'amount' => $request->grand_total,
                'name' => 'Lindts Food',
                'description' => 'Portal Request',
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('payment/success/?order='.$request->order_number),
                'cancelUrl' => url('payment'),
            ))->send();
        
            if ($response->isRedirect()) {
                // this will automatically forward the customer
                return response()->json($response->getRedirectUrl(), 200);
            } else {
                // not successful
                return response()->json($response->getMessage(), 200);
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
        
    }
    public function chargeReserve(Request $request)
    {
      
        try {
            $response = $this->gateway->purchase(array(
                'amount' => $request->total,
                'name' => 'Lindts Food',
                'description' => 'Portal Request',
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('payreserve-success?reserve='.$request->reservation_number),
                'cancelUrl' => url('payreserve'),
            ))->send();
        
            if ($response->isRedirect()) {
                // this will automatically forward the customer
                return response()->json($response->getRedirectUrl(), 200);
            } else {
                // not successful
                return response()->json($response->getMessage(), 200);
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
        
    }
   
    /**
     * Charge a payment and store the transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function success(Request $request)
    {
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();
           
            if ($response->isSuccessful())
            {
                // The customer has successfully paid.
                $arr_body = $response->getData();
           
                $ord = Order::where('order_number', $request->order)->first();
                // Insert transaction data into the database
                $pay = Payment::where('order_id', $ord->id)->first();
                if(!isset($pay)){
                    $payment = new Payment;
                    $payment->order_id = $ord->id;
                    $payment->user_id = Auth::id();
                    $payment->payment_id = $arr_body['id'];
                    $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                    $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                    $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                    $payment->currency = env('PAYPAL_CURRENCY');
                    $payment->payment_status = $arr_body['state'];
                    $payment->save();

                    $ord->status = 1;
                    $ord->save();

            
                    return response()->json(
                        ["message"=>"Payment is successful. Your transaction id is: ".$arr_body['id'], 
                        "order"=>$ord,
                        "payment"=>$payment]
                        , 200);
                }
               
            } else {
                return $response->getMessage();
            }
        } else {
            return 'Transaction is declined';
        }
    }

    public function successReserve(Request $request)
    {
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();
           
            if ($response->isSuccessful())
            {
                // The customer has successfully paid.
                $arr_body = $response->getData();
           
                $resv = Reservation::where('reservation_number', $request->reserve)->first();
                // Insert transaction data into the database
                $pay = PaymentReserve::where('reservation_id', $resv->id)->first();
                if(!isset($pay)){
                    $payment = new PaymentReserve;
                    $payment->reservation_id = $resv->id;
                    $payment->user_id = Auth::id();
                    $payment->payment_id = $arr_body['id'];
                    $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                    $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                    $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                    $payment->currency = env('PAYPAL_CURRENCY');
                    $payment->payment_status = $arr_body['state'];
                    $payment->save();

                    $resv->status = 1;
                    $resv->save();

            
                    return response()->json(
                        ["message"=>"Payment is successful. Your transaction id is: ".$arr_body['id'], 
                        "reserve"=>$resv,
                        "payment"=>$payment]
                        , 200);
                }
               
            } else {
                return $response->getMessage();
            }
        } else {
            return 'Transaction is declined';
        }
    }
   
    /**
     * Error Handling.
     */
    public function error()
    {
        return 'User cancelled the payment.';
    }
}
