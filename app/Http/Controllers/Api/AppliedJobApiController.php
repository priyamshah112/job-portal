<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\AppliedJob;
use App\Traits\JobTrait;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppliedJobApiController extends AppBaseController
{

    use JobTrait;

    public function index(){

        $user = auth()->user();
        $role = $user->user_type;
        $applied_jobs = null;

        if($role === 'recruiter'){
            $applied_jobs = AppliedJob::where('applied_jobs.recruiter_id', $user->id)
            ->leftJoin('jobs','jobs.id','=','applied_jobs.job_id')
            ->leftJoin('positions','positions.id','=','jobs.position_id')
            ->leftJoin('candidates','candidates.user_id','=','applied_jobs.candidate_id')
            ->leftJoin('users','users.id','=','applied_jobs.candidate_id')
            ->select(
                'candidates.category',
                'users.first_name',
                'users.id as user_id',
                'users.email',
                'users.last_name',
                'users.img_path',
                'positions.id',
                'positions.name as position_name',
                'jobs.*',
                'applied_jobs.*',
                'candidates.gender',
            )
            ->orderBy('applied_jobs.updated_at','Desc')
            ->get();

            foreach($applied_jobs as $job)
            {   
                $job['full_name'] = $user->first_name . ' ' . $user->last_name;
                $job['score'] = $this->score($job, $job->candidate_id);
            }

        }
        else if($role === 'candidate'){
            $applied_jobs = AppliedJob::where('applied_jobs.candidate_id', $user->id)
            ->leftJoin('jobs','jobs.id','=','applied_jobs.job_id')
            ->leftJoin('recruiters','recruiters.user_id','=','jobs.recruiter_id')
            ->select('jobs.*','applied_jobs.*','recruiters.user_id','recruiters.company_name')
            ->orderBy('applied_jobs.updated_at','Desc')
            ->get();
        }

        return $this->sendResponse($applied_jobs, "Applied Jobs Retreived Successfully");
    }

    public function store($id){
        if(auth()->user()->user_type !== 'candidate')
        {
            abort(404);
        }

        $job = Job::findOrFail($id);

        $input = [
            'job_id' => $id,
            'recruiter_id' => $job->recruiter_id,
            'candidate_id' => auth()->user()->id,
        ];

        $check = AppliedJob::where($input)->first();
        if(!empty($check)){
            return $this->sendError("Already Applied For This Job !!");
        }

        $applied_job = AppliedJob::create($input);
        return $this->sendResponse($applied_job, "Successfully Applied For Job");
    }

    public function status($id, Request $request)
    {
        $validator  = Validator::make($request->all(),[
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $applied_job = AppliedJob::findOrFail($id);

        $applied_job->update([
            'job_status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);

        return $this->sendResponse($applied_job, 'Successfully Updated Successfully');
    }
}
