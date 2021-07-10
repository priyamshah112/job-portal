<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Package;
use App\Models\Payment;
use App\Models\RecruiterPackage;
use App\Traits\PackageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;
use Exception;
use Illuminate\Support\Facades\DB;

class PaymentApiController extends AppBaseController
{
    use PackageTrait;

    private $key_id;
    private $secret;

    public function __construct()
    {
        $this->key_id = config('pay')['razorpay_key_id'];
        $this->secret = config('pay')['razorpay_key_secret'];
    }

    public function index()
    {
        $payments = Payment::leftJoin('recruiters','recruiters.user_id','=','payments.created_by')
        ->leftJoin('recruiter_packages','recruiter_packages.recruiter_id','=','recruiters.user_id')
        ->leftJoin('packages','packages.id','=','recruiter_packages.package_id')
        ->select('packages.plan_name as package_name','recruiter_packages.*','recruiters.*','payments.*')
        ->whereIn('payments.status',['success','failed'])
        ->orderBy('payments.updated_at', 'DESC')
        ->get();

        return $this->sendResponse($payments, 'Payments retrieved successfully');
    }

    public function order($id)
    {
        $user_id = auth()->user()->id;
        
        if($this->is_any_plan_active($user_id))
        {
            return $this->sendErrorWithCode("Your Current Plan is Active !!",410);
        }

        $package = Package::where('id', $id)->first();
        if(empty($package))
        {
            return $this->sendError('Package Not Found');
        }

        if($package->amount === 0)
        {
            RecruiterPackage::create([
                'recruiter_id' => $user_id,
                'from_date' => Carbon::now(),
                'to_date' => Carbon::now()->addMonth($package->duration),
                'package_id' => $package->id,
                'status' => 'active'
            ]);

            return $this->sendResponse(array(
                'plan_name' => 'Your '.$package->plan_name.' is active now !!'
            ),'Plan Purchased successfully');
        }
        $api = new Api($this->key_id, $this->secret);
        
        $order = $api->order->create([
            'amount'  => $package->amount*1.18*100,
            'currency' => 'INR',
        ]);

        $input['package_id'] = $package->id;
        $input['razorpay_order_id'] = $order['id'];
        $input['amount'] = $order['amount']/100;
        $input['created_by'] = $user_id;
        $input['updated_by'] = $user_id;

        Payment::create($input);

        return $this->sendResponse($order->toArray(), 'Order created successfully');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $user_id = auth()->user()->id;
        $input['updated_by'] = $user_id;
        
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

        DB::beginTransaction();
        try{
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
            
            $package = Package::findOrFail($payment->package_id);

            RecruiterPackage::create([
                'recruiter_id' => $user_id,
                'from_date' => Carbon::now(),
                'to_date' => Carbon::now()->addMonth($package->duration),
                'package_id' => $payment->package_id,
                'status' => 'active'
            ]);
            
            DB::commit();
            
            return $this->sendResponse(array(
                'plan_name' => 'Your '.$package->plan_name.' is active now !!'
            ),'Plan Purchased successfully');
        }
        catch(Exception $e){
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

}
