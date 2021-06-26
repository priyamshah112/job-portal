<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Cities;
use App\Models\Job;
use App\Models\Recruiter;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class JobApiController extends AppBaseController
{
    public function index()
    {
        $userId = Auth::user()->id;
        $recruiterId = Recruiter::where('user_id', $userId)->value('id');
        return DataTables::of(Job::whereNull('deleted_at')->where('recruiter_id', $recruiterId))
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

    public function store(Request $request)
    {

        if ($request->draft == 0) {
            $validator = Validator::make($request->all(), [
                'position' => 'required',
                'description' => 'required',
                'noOfPosts' => 'required',
                'state' => 'required',
                'city' => 'required|not_in:0',
                'minAge' => 'required|not_in:0',
                'maxAge' => 'required|not_in:0|gt:minAge',
                'minSalary' => 'required|not_in:0',
                'maxSalary' => 'required|not_in:0|gt:minSalary',
                'experience' => 'required|not_in:0',
                'maxexperience' => 'required|not_in:0|gt:experience',
                'deadline' => 'required',
                'skills' => 'required',
                'qualification' => 'required',
            ]);

            if ($validator->fails()) {
                $response['response'] = $validator->messages();
                return collect(["status" => 0, $response]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'position' => 'required',
                'noOfPosts' => 'required',
            ]);
            if ($validator->fails()) {
                $response['response'] = $validator->messages();
                return collect(["status" => 0, $response]);
            }
        }
        $user_id = auth()->user()->id;
        $recruiter = Recruiter::where('user_id', $user_id)->select('id')->first();
        $recruiter_id = $recruiter->id;
        $qualification = json_encode($request->qualification);
        $skills = json_encode($request->skills);
        // dd($request); die();
        $createJob = Job::create([
            'recruiter_id' => $recruiter_id,
            'position' => $request->position,
            'description' => $request->description,
            'num_position' => $request->noOfPosts,
            'state' => $request->state,
            'city' => $request->city,
            'age_min' => $request->minAge,
            'age_max' => $request->maxAge,
            'qualification' => $qualification,
            'experience' => $request->experience,
            'maxexperience' => $request->maxexperience,
            'salary_min' => $request->minSalary,
            'salary_max' => $request->maxSalary,
            'skills' => $skills,
            'status' => '1',
            'deadline' => $request->deadline,
            'draft' => $request->draft,
        ]);
        if ($request->draft == "0") {
            $message = 'Created Successfully';
        } else {
            $message = 'Saved as Draft';
        }

        return collect(["status" => 1, 'msg' => $message])->toJson();
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
        // $qualification = json_decode($job->qualification);
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
        $qualification = json_decode($job->qualification);

        $states = States::get(["name", "id"]);
        $cities = Cities::where('state_id', $job->state)->get(["name", "id"]);
        return response()->json([
            $job , $skills , $qualification
        ]);
    }

    public function update(Request $request)
    {
        $job = Job::find($request->id);
        if(!isset($job))
        {
            return collect(["status" => 0, "msg" => "Invalid Job "])->toJson();
        }
        $validator  = Validator::make($request->all(),[
            'position' => 'required',
            'description' => 'required',
            'noOfPosts' => 'required',
            'state' => 'required',
            'city' => 'required',
            'minAge' => 'required',
            'maxAge' => 'required',
            'minSalary' => 'required',
            'maxSalary' => 'required',
            'experience' => 'required',
            'qualification' => 'required',
            'skills' => 'required',
            'deadline' => 'required',

            ]);
        if($validator->fails()){
            $response['response'] = $validator->messages();
            return  collect(["status" => 0, $response]);
        }

        $qualification = json_encode($request->qualification);
        $skills = json_encode($request->skills);
        if ($request->draft == 1) {
            Job::find($request->id)->update([
                'position' => $request->position,
                'description' => $request->description,
                'num_position' => $request->noOfPosts,
                'state' => $request->state,
                'city' => $request->city,
                'age_min' => $request->minAge,
                'age_max' => $request->maxAge,
                'qualification' => $qualification,
                'experience' => $request->experience,
                'maxexperience' => $request->maxexperience,
                'salary_min' => $request->minSalary,
                'salary_max' => $request->maxSalary,
                'skills' => $skills,
                'status' => '1',
                'deadline' => $request->deadline,
                'draft' => '1',
            ]);
        } else {
            Job::find($request->id)->update([
                'position' => $request->position,
                'description' => $request->description,
                'num_position' => $request->noOfPosts,
                'state' => $request->state,
                'city' => $request->city,
                'age_min' => $request->minAge,
                'age_max' => $request->maxAge,
                'qualification' => $qualification,
                'experience' => $request->experience,
                'maxexperience' => $request->maxexperience,
                'salary_min' => $request->minSalary,
                'salary_max' => $request->maxSalary,
                'skills' => $skills,
                'status' => '1',
                'deadline' => $request->deadline,
                'draft' => '0',
            ]);
        }
        $message = 'Job Updated Successfully';
        return collect(["status" => 1, "msg" =>  $message])->toJson();

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
