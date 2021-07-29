<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Models\Cities;
use App\Models\Job;
use App\Models\JobFair;
use App\Models\Recruiter;
use App\Models\State;
use App\Models\States;
use App\Traits\JobTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class JobApiController extends AppBaseController
{
    use JobTrait;

    public function index()
    {
        $user = Auth::user();
        if($user->user_type === 'recruiter')
        {
            return DataTables::of(Job::whereNull('deleted_at')->where('recruiter_id', $user->id))
            ->addColumn('action', function ($data) {
                $menu = '<a href="' . route('jobs-view', ['id' => $data->id]) . '" class="btn p-0 m-0"><i data-feather="eye" class="text-primary font-medium-5"></i></a>';
                if ($data->draft == 1) {
                    $menu .= '<a href="' . route('jobs-edit', ['id' => $data->id]) . '" class="btn p-0 m-0"><i data-feather="edit" class="text-warning ml-1 font-medium-5"></i></a>';
                }
                return $menu;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        else if($user->user_type === 'candidate')
        {
            $jobs = Job::whereNull('deleted_at')->where(['draft' => '0'])->orderBy('updated_at')->get(); 
            $candidate = Candidate::where('user_id', $user->id)->first();
            foreach($jobs as $job)
            {
               $job['score'] = $this->score($job, $candidate->id);
            }
            return $this->sendResponse($jobs, "Job List Retreived Successfully");
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'position' => 'required',
            'description' => 'required',
            'num_position' => 'required',
            'salary_min' => 'required|not_in:0',
            'salary_max' => 'required|not_in:0|gt:salary_min',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }
        
        $input['recruiter_id'] = auth()->user()->id;

        $createJob = Job::create($input);

        return $this->sendResponse($createJob, 'Job Created Successfully');
    }

    public function jobDetailUpdate($id, Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'position' => 'required',
            'description' => 'required',
            'num_position' => 'required',
            'salary_min' => 'required|not_in:0',
            'salary_max' => 'required|not_in:0|gt:salary_min',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $job = Job::findOrFail($id);
        if($job->draft === '0')
        {
            return $this->sendError('Cannot edit published data');
        }
        $job->update($input);

        return $this->sendResponse($job, 'Job Created Successfully');
    }
    
    public function jobCriteriaUpdate($id, Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'age_min' => 'required|not_in:0',
            'age_max' => 'required|not_in:0|gt:age_min',
            'gender' => 'required',
            'experience' => 'required|not_in:0',
            'maxexperience' => 'required|not_in:0|gt:experience',
            'deadline' => 'required',
            'skills' => 'required|array',
            'qualification_id' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $job = Job::findOrFail($id);
        $job->update($input);

        return $this->sendResponse($job, 'Job Created Successfully');
    }

    public function jobLocationUpdate($id, Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'state' => 'required|array',
            'city' => 'required|array',
            'draft' => 'required',
        ]);

        $removedNullValueState = [];
        $removedNullValueCity = [];

        foreach ($input['state'] as $s) {
            if($s !== null)
            {
                $removedNullValueState[] = $s;
            }
        }

        foreach ($input['city'] as $c) {
            if($c !== null)
            {
                $removedNullValueCity[] = $c;
            }
        }
        
        $input['state'] = $removedNullValueState;
        $input['city'] = $removedNullValueCity;

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $job = Job::findOrFail($id);
        $job->update($input);

        return $this->sendResponse([
            $job,
            'redirectURL' => URL::previous()
        ], 'Job Created Successfully');
    }

    public function status($id, Request $request)
    {
        $job = Job::find($id);
        if (!isset($job)) {
            return collect(["status" => 0, "msg" => "Invalid Job"])->toJson();
        }
        $job->draft = $request->status;
        $status = $job->save();
        if (!isset($status)) {
            return collect(["status" => 0, "msg" => "Can't Change Status"])->toJson();
        }
        return collect(["status" => 1, "msg" => "Status Changed Successfully"])->toJson();
    }

    public function view($id)
    {
          $job = Job::find($id);
          if(!isset($job))
          {
              return collect(["status" => 0, "msg" => "Invalid Job "])->toJson();
          }

        $job = Job::where('id', $id)->first();
        // $skills = json_decode($job->skills);
        // $qualification_id = json_decode($job->qualification_id);
        return response()->json([
            $job
        ]);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $job = Job::find($id);
        if(!isset($job))
        {
            return collect(["status" => 0, "msg" => "Invalid Job "])->toJson();
        }
        $breadcrumbs = [
            ['link' => "jobs", 'name' => "Job List"],
            ['name' => "Create Job"],
        ];

        $job = Job::where('id', $id)->first();

        $skills = json_decode($job->skills);
        $qualification_id = json_decode($job->qualification_id);

        $states = State::get(["name", "id"]);
        $cities = Cities::where('state_id', $job->state)->get(["name", "id"]);
        return response()->json([
            $job , $skills , $qualification_id
        ]);
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $validator  = Validator::make($request->all(),[
            'position' => 'required',
            'description' => 'required',
            'num_position' => 'required',
            'state' => 'required',
            'city' => 'required',
            'age_min' => 'required',
            'age_max' => 'required',
            'salary_min' => 'required',
            'salary_max' => 'required',
            'experience' => 'required',
            'qualification_id' => 'required',
            'skills' => 'required',
            'deadline' => 'required',

            ]);
        if($validator->fails()){
            return  $this->sendError($validator->errors());
        }
        
        $job = Job::find($request->id);
        if(!isset($job))
        {
            return $this->sendError('Job Not Found');
        }

        $job = Job::find($request->id)->update($input);
        return $this->sendResponse($job, 'Job Updated Successfully');

    }
    
    public function participate($job_fair_id)
    {
        $job_fair = JobFair::findOrFail($job_fair_id);
        return DataTables::of(Job::whereNull('deleted_at')
        ->where('recruiter_id', auth()->user()->id)
        ->where('draft','0')
        ->whereBetween('deadline',[Carbon::parse($job_fair->start_date)->format('Y-m-d'),Carbon::parse($job_fair->end_date)->format('Y-m-d')])
        ->orderBy('updated_at','DESC'))
        ->addColumn('action', function ($data) {
            $menu = '<a href="' . route('jobs-view', ['id' => $data->id]) . '" class="btn p-0 m-0"><i data-feather="eye" class="text-primary font-medium-5"></i></a>';
            return $menu;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        $job = Job::where("id", $request->id)->first();
        if (!isset($job)) {
            return collect(["status" => 0, "msg" => "Invalid Recruiter"])->toJson();
        }
        $rec = Job::find($job->id);
        $recStatus = $rec->delete();
        if (!isset($recStatus)) {
            DB::rollBack();
            return collect(["status" => 0, "msg" => "Can't Delete Job"])->toJson();
        }
        DB::commit();
        return collect(["status" => 1, "msg" => "Deleted Successfully"])->toJson();

    }
}
