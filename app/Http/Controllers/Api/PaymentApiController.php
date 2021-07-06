<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;
use Exception;

class PaymentApiController extends AppBaseController
{
    private $key_id;
    private $secret;

    public function __construct()
    {
        $this->key_id = config('pay')['razorpay_key_id'];
        $this->secret = config('pay')['razorpay_key_secret'];
    }

    public function index()
    {
        $payments = Payment::all();

        return $this->sendResponse($payments, 'Payments retrieved successfully');
    }

    public function order($id)
    {
        $api = new Api($this->key_id, $this->secret);
        
        $order = $api->order->create([
            'amount'  => 1000,
            'currency' => 'INR',
        ]);

        $input['razorpay_order_id'] = $order['id'];
        $input['amount'] = $order['amount'];
        $input['created_by'] = auth()->user()->id;
        $input['updated_by'] = auth()->user()->id;

        Payment::create($input);

        return $this->sendResponse($order->toArray(), 'Order created successfully');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['updated_by'] = auth()->user()->id;
        
        $validator  = Validator::make($input,[
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required'
        ]);

        if($validator->fails())
        {
           return $this->sendError($validator->errors()) ;
        }

        $payment = Payment::where('razorpay_order_id',$input['razorpay_order_id'])->first();
        if(empty($payment))
        {
            return $this->sendError('No Order Found');
        }

        $api = new Api($this->key_id, $this->secret);

        $attributes  = [
            'razorpay_signature'  => $input['razorpay_signature'],  
            'razorpay_payment_id'  => $input['razorpay_payment_id'] ,  
            'razorpay_order_id' => $input['razorpay_order_id'],
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);
        } catch (Exception $e) {
            $input['status'] = 'failed';
            $payment->update($input);
            return $this->sendError("Inavlid razorpay_signature or razorpay_payment_id");
        }

        $input['status'] = 'success';
        $payment->update($input);
        return $this->sendResponse($payment, 'Payment created successfully');
    }

}
