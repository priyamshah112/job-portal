<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\AppBaseController;
use App\Models\Cities;
use App\Models\City;
use App\Models\Job;
use App\Models\Recruiter;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use ParagonIE\Sodium\Core\Poly1305\State;
use Yajra\DataTables\DataTables;

class RJobController extends AppBaseController
{
    public function view($id)
    {
        $job = Job::where('id', $id)->first();
        $skills = json_decode($job->skills);
        $qualification = json_decode($job->qualification);
        $breadcrumbs = [
            ['link' => "recruiter/jobs", 'name' => "Job List"],
            ['name' => "Create Job"],
        ];

        return view('job/view', compact('job', 'skills', 'qualification', 'breadcrumbs'));
    }
    public function index()
    {
        $userId = Auth::user()->id;
        $recruiterId = Recruiter::where('user_id', $userId)->value('id');
        if (request()->ajax()) {
            return DataTables::of(Job::whereNull('deleted_at')->where('recruiter_id', $recruiterId))
                ->addColumn('action', function ($data) {
                    $menu = '<a href="' . route('recruiter-jobs-view', ['id' => $data->id]) . '" class="btn p-0 m-0"><i data-feather="eye" class="text-primary font-medium-5"></i></a>';
                    if ($data->draft == 1) {
                        $menu .= '<a href="' . route('recruiter-jobs-edit', ['id' => $data->id]) . '" class="btn p-0 m-0"><i data-feather="edit" class="text-warning ml-1 font-medium-5"></i></a>';
                    }
                    return $menu;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('job.alljobs');
    }

    public function getCreateJobForm()
    {
        $breadcrumbs = [
            ['link' => "recruiter/jobs", 'name' => "Job List"],
            ['name' => "Create Job"],
        ];
        return view('/job/create/createjobs', ['breadcrumbs' => $breadcrumbs]);
    }

    public function createJob(Request $request)
    {

        if($request->draft == 0)
        {
            $request->validate([
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
                'qualification' => 'required|array',
                'skills'=> 'required|array',
            ]);
        }else{
            $request->validate([
                'position' => 'required',
                'description' => 'required',
            ]);
        }

        $user_id = auth()->user()->id;
        $recruiter = Recruiter::where('user_id', $user_id)->select('id')->first();
        $recruiter_id = $recruiter->id;
        $qualification = json_encode($request->qualification);

        $skills = json_encode($request->skills);


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
            $message = 'Job Created Successfully';
        } else {
            $message = 'Job Saved as Drafted Successfully';
        }

        return redirect()->back()->with(['message' => $message]);
    }
    public function enable(Request $request)
    {
        $job = Job::find($request->id);
        if (!isset($job)) {
            return collect(["status" => 0, "msg" => "Invalid Job"])->toJson();
        }
        $job->draft = "0";
        $status = $job->save();
        if (!isset($status)) {
            return collect(["status" => 0, "msg" => "Can't Change Status"])->toJson();
        }
        return collect(["status" => 1, "msg" => "Status Changed Successfully"])->toJson();
    }

    public function disable(Request $request)
    {
        $job = Job::find($request->id);
        if (!isset($job)) {
            return collect(["status" => 0, "msg" => "Invalid Job"])->toJson();
        }
        $job->draft = "1";
        $status = $job->save();
        if (!isset($status)) {
            return collect(["status" => 0, "msg" => "Can't Change Status"])->toJson();
        }
        return collect(["status" => 1, "msg" => "Status Changed Successfully"])->toJson();
    }
    public function delete(Request $request)
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

    public function editJob(Request $request)
    {
        $breadcrumbs = [
            ['link' => "recruiter/jobs", 'name' => "Job List"],
            ['name' => "Create Job"],
        ];
        $id = $request->id;
        $job = Job::where('id', $id)->first();
        $skills = json_decode($job->skills);
        $qualification = json_decode($job->qualification);

        return view('job/edit', compact('job', 'skills', 'qualification',
        'breadcrumbs'));
    }

    public function updateJob(Request $request, $id)
    {
        $request->validate([
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
            'maxexperience' => 'required',
            'qualification' => 'required',
            'skills' => 'required',
            'deadline' => 'required',
        ]);
        $qualification = json_encode($request->qualification);
        $skills = json_encode($request->skills);
        if ($request->draft == 1) {
            Job::find($id)->update([
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
        } else {
            Job::find($id)->update([
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
        if ($request->draft == 0) {
            return redirect()->intended('/recruiter/jobs');
        }
        return back()->with(['message' => $message]);

    }

    public function fetchCities(Request $request)
    {
        $data['states']= Cities::where("state_id",$request->state_id)->get(["name", "id"]);
         return response()->json($data);
    }
}
