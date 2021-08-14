<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Models\User;
use App\Traits\JobTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CandidateApiController extends AppBaseController
{
    use JobTrait;

    public function index()
    {
        $role = Auth::user()->user_type; 
    
        if($role === 'admin')
        {
            return DataTables::of(Candidate::whereNull('deleted_at')->with('user'))
                ->addColumn('action', function ($data) {
                    $menu = '';
                    if ($data->user->active == 1) {
                        $menu = '<buton title="Change Status" onclick="disable(' . $data->user->id . ', this)" class="btn p-0 m-0"><i data-feather="toggle-right" class="text-success font-large-1"></i></buton>';
                    } else {
                        $menu = '<buton title="Change Status" onclick="enable(' . $data->user->id . ', this)" class="btn p-0 m-0"><i data-feather="toggle-left" class="text-danger font-large-1"></i></buton>';
                    }
                    $menu .= '<a title="View" href="' . route('candidates-view', ['id' => $data->user->id]) . '" class="btn p-0 m-0"><i data-feather="eye" class="text-primary ml-1 font-medium-5"></i></a>';
                    $menu .= '<a title="Edit" href="' . route('candidates-edit', ['id' => $data->user->id]) . '" class="btn p-0 m-0"><i data-feather="edit" class="text-warning ml-1 font-medium-5"></i></a>';
                    $menu .= '<buton title="Delete" onclick="deleter(' . $data->user->id . ', this)" class="btn p-0 m-0"><i data-feather="trash-2" class="text-danger ml-1 font-medium-5"></i></buton>';
                    return $menu;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        if($role === 'recruiter')
        {
            $candidates = Candidate::whereNull('deleted_at')->with('user')->get();
            foreach ($candidates as $candidate) {
                $candidate["skillNames"] = $this->convertSkillIdsToSkillNames($candidate->skills);
                $candidate["stateNames"] = $this->convertStateIdsToStateNames($candidate->preferred_state);
                $candidate["cityNames"] = $this->convertCityIdsToCityNames($candidate->preferred_city);
            }
            return $this->sendResponse($candidates, "Candidates Retreived Successfully");
        }

    }

    public function view($id)
    {
        $breadcrumbs = [
            ['link' => "candidates", 'name' => "Candidate"],
            ['name' => "View Candidates"],
        ];
        $user = User::find($id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $candidate = Candidate::with('user')->where('user_id', $id)->first();
        $userType = 'admin';
        return response()->json([
            $candidate, $breadcrumbs
        ]);
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        $candidate = Candidate::where("user_id", $request->id)->first();
        if (!isset($candidate)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $user = User::find($request->id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $rec = Candidate::find($candidate->id);
        $recStatus = $rec->delete();
        $status = $user->delete();
        if (!isset($status) || !isset($recStatus)) {
            DB::rollBack();
            return collect(["status" => 0, "msg" => "Can't Delete Candidate"])->toJson();
        }
        DB::commit();
        return collect(["status" => 1, "msg" => "Deleted Successfully"])->toJson();
    }
    
    public function update(Request $request)
    {
        $validator  = Validator::make($request->all(),[
            "first_name" => 'required',
            "last_name" => 'required',
            "dateOfBirth" => 'required',
            "gender" => 'required',
            "permanent_address" => 'required',
            "current_location_city" => "required",
            "current_location_state" =>'required',
            "company_mobile_1" => "required",
            "email" => 'required',
            "category" => 'required',
            "department_id" => 'required',
            "skills" => 'required',
            "qualification_id" => 'required',
            "about" => 'required',
        ]);
        if($request->category == 'experienced'){
            $arr['category_type'] = 'required';
        }
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }
        $userID = User::where('email', $request->email)->value('id');
        if (!isset($userID)) {
            return collect(["status" => 0, "msg" => "User data not found"])->toJson();
        }
        $image_name = "";
        if ($request->file('img_name')) {
            $filenameWithExt = $request->file('img_name')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img_name')->getClientOriginalExtension();
            $image_name = $filename . '_' . time() . '.' . $extension;
            $request->file('img_name')->storeAs('public/profile_pic', $image_name);
            User::where('id', $userID)->update(['img_path' => "storage/profile_pic", 'image_name' => $image_name]);
        }
        User::where('id', $userID)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_number' => $request->company_mobile_1
        ]);
        $candidate_id = Candidate::where('user_id', $userID)->value('id');
        $skills = json_encode($request->skills);
        $candidate = Candidate::where('id', $candidate_id)->update([
            'about'=> $request->about,
            'qualification_id' =>$request->qualification_id,
            'current_location_state' => $request->current_location_state,
            'current_location_city' => $request->current_location_city,
            'skills' => $skills,
            'dateOfBirth' => $request->dateOfBirth,
            'gender' => $request->gender,
            'mobile_number' => $request->company_mobile_2,
            'alt_email' => $request->alt_email,
            'permanent_address' => $request->permanent_address,
            'category' => $request->category,
            'department_id' => $request->department_id,
            'category_work' => $request->category_type,
            'job_location_state' => $request->job_location_state,
            'job_location_city' => $request->job_location_city,

        ]);
        return collect(["status" => 1, "msg" => "Candidate Updated Successfully"])->toJson();
    }

    public function enable(Request $request)
    {
        $candidate = Candidate::where("user_id", $request->id)->first();
        if (!isset($candidate)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $user = User::find($request->id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $user->active = '1';
        $status = $user->save();
        if (!isset($status)) {
            return collect(["status" => 0, "msg" => "Can't Change Status"])->toJson();
        }
        return collect(["status" => 1, "msg" => "Candidate enabled successfully"])->toJson();
    }

    public function disable(Request $request)
    {
        $candidate = Candidate::where("user_id", $request->id)->first();
        if (!isset($candidate)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $user = User::find($request->id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $user->active = '2';
        $status = $user->save();
        if (!isset($status)) {
            return collect(["status" => 0, "msg" => "Can't Change Status"])->toJson();
        }
        return collect(["status" => 1, "msg" => "Candidate disabled successfully"])->toJson();
    }

}
