<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\AppliedJob;
use App\Models\AppliedJobFair;
use App\Models\Job;
use App\Models\JobFair;
use App\Models\RecruiterJobFair;
use App\Traits\JobTrait;
use App\Traits\NotificationTraits;
use App\Traits\SaveTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobFairApiController extends AppBaseController
{

    use SaveTrait,JobTrait,NotificationTraits;

    public function index()
    {
        return "index";
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($input,[
            'name' => 'required',
            'description' => 'required',
            'img_name' => 'required',
            'organizer_name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'department_id' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendValidationError($validator->errors());
        }

        if ($request->has('img_name') && !empty($request->img_name)) {
            $image = $this->save_job_fair_banner($request->img_name);
            $input['img_name'] = $image['img_name'];
            $input['img_path'] = $request->getSchemeAndHttpHost().$image['img_path'];
        }

        $job_fair = JobFair::create($input);
        return $this->sendResponse($job_fair, "Successfully Job Fair Created");
    }

    public function jobFairDetailsUpdate($id, Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($input,[
            'name' => 'required',
            'description' => 'required',
            'organizer_name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'department_id' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendValidationError($validator->errors());
        }

        if ($request->has('img_name') && !empty($request->img_name)) {
            $image = $this->save_job_fair_banner($request->img_name);
            $input['img_name'] = $image['img_name'];
            $input['img_path'] = $request->getSchemeAndHttpHost().$image['img_path'];
        }

        $job_fair = JobFair::findOrFail($id);
        $job_fair->update($input);
        return $this->sendResponse($job_fair, "Successfully Updated Job Fair");
    }

    public function jobFairContactUpdate($id, Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($input,[
            'address' => 'required',
            'mobile_number' => 'required',
            'email' => 'required|email',
        ]);

        if($validator->fails())
        {
            return $this->sendValidationError($validator->errors());
        }

        $job_fair = JobFair::findOrFail($id);

        $job_fair->update($input);

        return $this->sendResponse($job_fair, "Successfully Updated Job Fair");
    }

    public function jobFairEventDateTimeUpdate($id, Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($input,[
            'dates' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'draft' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendValidationError($validator->errors());
        }
        
        $job_fair = JobFair::findOrFail($id);

        $date = explode("to", $request->dates);

        $input['start_date'] = $date[0];
        $input['end_date'] = $date[1];
        $input['number_of_days'] = Carbon::parse($date[0])->diffInDays(Carbon::parse($date[1]));
        
        if($input['draft'] === '1')
        {
            $this->notification([
                "title" => 'Your Job fair had been saved successfully',
                "description" => 'Your Job fair had been saved successfully',
                "receiver_id" => auth()->user()->id,
                "sender_id" => auth()->user()->id,
            ]);
        }
        else if($input['draft'] === '0')
        {
            $this->notification([
                "title" => 'Your Job fair had been published  successfully',
                "description" => 'Your Job fair had been published  successfully',
                "receiver_id" => auth()->user()->id,
                "sender_id" => auth()->user()->id,
            ]);
        }

        $job_fair->update($input);

        return $this->sendResponse($job_fair, "Successfully Updated Job Fair");
    }

    public function show($id)
    {
        $job_fair = JobFair::findOrFail($id);

        return $this->sendResponse($job_fair, "Job Fair Retreived Successfully");
    }

    public function update($id, Request $request)
    {
        $job_fair = JobFair::findOrFail($id);

        $input = $request->all();

        $validator  = Validator::make($input,[
            'name' => 'required',
            'description' => 'required',
            'organizer_name' => 'required',
            'address' => 'required',
            'mobile_number' => 'required',
            'email' => 'required',
            'type' => 'required',
            'price' => 'required',
            'number_of_days' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'department_id' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendValidationError($validator->errors());
        }

        if ($request->has('img_name') && !empty($request->img_name)) {
            $image = $this->save_job_fair_banner($request->img_name);
            $input['img_name'] = $image['img_name'];
            $input['img_path'] = $request->getSchemeAndHttpHost().$image['img_path'];
        }

        $job_fair->update($input);

        return $this->sendResponse($job_fair, 'Successfully Updated Job Fair');
    }

    public function destroy($id)
    {
        $job_fair = JobFair::findOrFail($id);
        Storage::disk('public')->delete('job_fair/' . $job_fair->img_name);
        $job_fair->delete();

        return $this->sendResponse($job_fair, "Successfully Job Fair Deleted");
    }

    public function apply($id)
    {
        if(auth()->user()->user_type !== 'candidate')
        {
            abort(404);
        }
        
        DB::beginTransaction();
        try {
            $job_fair = JobFair::findOrFail($id);

            $input = [
                'job_fair_id' => $id,
                'candidate_id' => auth()->user()->id,
            ];
    
            $check = AppliedJobFair::where($input)->first();
            if(!empty($check)){
                return $this->sendError("Already Applied For This Job Fair!!");
            }

            $recruiter_job_fairs = RecruiterJobFair::where([
                'job_fair_id' => $id
            ])->get();

            $job_ids = [];

            foreach($recruiter_job_fairs as $recruiter_job_fair)
            {
                $job_ids = array_unique(array_merge($job_ids, $recruiter_job_fair->job_ids));
            }

            foreach($job_ids as $job_id)
            {
                $job = Job::where('id', $job_id)->first();
                if(!empty($job)){
                    $job_input = [
                        'job_id' => $job_id,
                        'recruiter_id' => $job->recruiter_id,
                        'candidate_id' => auth()->user()->id,
                    ];

                    $check = AppliedJob::where($job_input)->first();
                    if(empty($check)){
                        AppliedJob::create($job_input);
                    }
                }
            }

            $applied_job_fair = AppliedJobFair::create($input);
            DB::commit();
            return $this->sendResponse($applied_job_fair, "Successfully Applied For Job Fair");
        } 
        catch(Exception $err)
        {
            DB::rollBack();
            return $this->sendError($err->getMessage());
        }
    }

    public function jobs($id)
    {
        
        $job_fair = JobFair::findOrFail($id);

        $user_id = auth()->user()->id;
        $job_ids = [];
        $recruiter_job_fairs = RecruiterJobFair::where([
            'job_fair_id' => $id
        ])->get();

        foreach($recruiter_job_fairs as $recruiter_job_fair)
        {
            $job_ids = array_unique(array_merge($job_ids, $recruiter_job_fair->job_ids));
        }

        $jobs = Job::with('position')->whereNull('deleted_at')
        ->where('recruiter_id', $user_id)
        ->whereIn('id', $job_ids)
        ->get();

        foreach($jobs as $job)
        {
            $job['action'] = '<a href="' . route('job-fair.applied', ['id' => $job->id]) . '" class="btn p-0 m-0"><i data-feather="eye" class="text-primary font-medium-5"></i></a>';
        }

        return $this->sendResponse($jobs, 'Jobs Retreived Successfully');
    }

    public function appliedCandidates($id)      
    {
        $job = Job::findOrFail($id);
        $user = auth()->user();

        $applied_jobs = AppliedJob::where([
        'applied_jobs.recruiter_id' => $user->id,
        'applied_jobs.job_id' => $id
        ])
        ->leftJoin('jobs','jobs.id','=','applied_jobs.job_id')
        ->leftJoin('positions','positions.id','=','jobs.position_id')
        ->leftJoin('candidates','candidates.user_id','=','applied_jobs.candidate_id')
        ->leftJoin('users','users.id','=','applied_jobs.candidate_id')
        ->select(
            'candidates.category',
            'users.first_name',
            'users.last_name',
            'users.img_path',
            'users.email',
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

            
        return $this->sendResponse($applied_jobs, "Applied Jobs Retreived Successfully");
    }
}