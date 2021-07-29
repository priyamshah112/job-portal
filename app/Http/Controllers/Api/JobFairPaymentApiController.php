<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\JobFair;
use App\Models\JobFairPayment;
use App\Models\RecruiterJobFair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;
use Exception;
use Illuminate\Support\Facades\DB;

class JobFairPaymentApiController extends AppBaseController
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
        $payments = JobFairPayment::leftJoin('recruiters','recruiters.user_id','=','job_fair_payments.created_by')
        ->leftJoin('recruiter_job_fair','recruiter_job_fair.recruiter_id','=','recruiters.user_id')
        ->leftJoin('job_fairs','job_fairs.id','=','recruiter_job_fair.package_id')
        ->select('job_fairs.name as job_fair_name','recruiter_job_fair.*','recruiters.*','job_fair_payments.*')
        ->whereIn('job_fair_payments.status',['success','failed'])
        ->orderBy('job_fair_payments.updated_at', 'DESC')
        ->get();

        return $this->sendResponse($payments, 'Payments retrieved successfully');
    }

    public function show($id)
    {        
        $payments = JobFairPayment::leftJoin('job_fairs','job_fairs.id', '=','job_fair_payments.job_fair_id')
        ->leftJoin('recruiters','recruiters.user_id','=','job_fair_payments.created_by')
        ->where([
            'job_fair_payments.job_fair_id' => $id,
            'job_fair_payments.status' => 'success',
        ])
        ->select('recruiters.company_name','recruiters.user_id','job_fairs.name as job_fair_name','job_fairs.id','job_fair_payments.*')
        ->orderBy('job_fair_payments.updated_at', 'DESC')
        ->get();

        return $this->sendResponse($payments, 'Job Fair Payment Retreived Successfully');
    }

    public function order($id, Request $request)
    {

        $user_id = auth()->user()->id;
        
        $jobFair = JobFair::where('id', $id)->first();

        if(empty($jobFair))
        {
            return $this->sendError('Job Fair Not Found');
        }

        $recruiterJobFair = RecruiterJobFair::where([
            'job_fair_id' => $id,
            'recruiter_id' => $user_id,
        ])->first();

        if(!empty($recruiterJobFair))
        {
            return $this->sendError('You already have participated !!');
        }

        if($jobFair->price === 'free')
        {
            $validator  = Validator::make($request->all(),[
                'job_ids' => 'required|array',
            ]);
    
            if($validator->fails())
            {
               return $this->sendError($validator->errors()) ;
            }

            RecruiterJobFair::create([
                'recruiter_id' => $user_id,
                'job_ids' => $request->job_ids,
                'job_fair_id' => $jobFair->id,
            ]);

            return $this->sendResponse(array(
                'jobFair' => 'Successfully Participated in '.$jobFair->name.' Job Fair !!'
            ),'Successfully Participated In Job Fair');
        }

        $api = new Api($this->key_id, $this->secret);
        
        $order = $api->order->create([
            'amount'  => $jobFair->amount*1.18*100,
            'currency' => 'INR',
        ]);
        
        $input['job_fair_id'] = $jobFair->id;
        $input['razorpay_order_id'] = $order['id'];
        $input['amount'] = $order['amount']/100;
        $input['created_by'] = $user_id;
        $input['updated_by'] = $user_id;

        JobFairPayment::create($input);

        return $this->sendResponse($order->toArray(), 'Job Fair Order created successfully');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $user_id = auth()->user()->id;
        $input['updated_by'] = $user_id;
        
        $validator  = Validator::make($input,[
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required',
            'job_ids' => 'required|array',
        ]);

        if($validator->fails())
        {
           return $this->sendError($validator->errors()) ;
        }

        $payment = JobFairPayment::where('razorpay_order_id',$input['razorpay_order_id'])->first();
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
            
            $jobFair = JobFairPayment::findOrFail($payment->job_fair_id);

            RecruiterJobFair::create([
                'recruiter_id' => $user_id,
                'job_fair_id' => $jobFair->id,
                'job_ids' => $request->job_ids,
            ]);
            
            DB::commit();
            
            return $this->sendResponse(array(
                'jobFair' => 'Successfully Participated in '.$jobFair->name.' Job Fair !!'
            ),'Successfully Participated In Job Fair');
        }
        catch(Exception $e){
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

}
