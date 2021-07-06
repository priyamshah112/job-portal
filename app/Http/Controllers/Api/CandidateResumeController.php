<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Cities;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CandidateResumeController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $candidate = Candidate::with('user')->where('user_id', $user_id)->first();
        $userType = 'candidate';
        return collect(['success' => $candidate, $userType])->toJson();
    }

    public function edit()
    {
        $breadcrumbs = [
            ['link' => "list-resume", 'name' => "Resume"],
            ['name' => "Edit Resume"],
        ];
        $user_id = Auth::user()->id;
        $candidate = Candidate::with('user')->where('user_id', $user_id)->first();

        $cities = Cities::get(["name", "id"])->take(10);
        return collect([
            'breadcrumbs' => $breadcrumbs,
            'cities' => $cities,
            'candidate' => $candidate
        ])->toJson();
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        $validatorArray = [
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
            "qualification_id" => 'required',
            "about" => 'required',
            "skills" => 'required',
        ];

        if($request->category == 'experienced'){
            $validatorArray['category_type'] = 'required';
        }

        $validator  = Validator::make($request->all(), $validatorArray);
//        $validator = Validator::make($request->all(), [
//            "first_name" => 'required',
//            "last_name" => 'required',
//            "dateOfBirth" => 'required',
//            "permanent_address" => 'required',
//            "current_location_city" => "required",
//            "current_location_state" => 'required',
//            "company_mobile_1" => "required",
//            "email" => 'required',
//            "category" => 'required',
//            "department_id" => 'required',
//            "skills" => 'required',
//            "qualification_id" => 'required',
//            "about" => 'required',
//        ]);
//        if ($request->category == 'experienced') {
//            $arr['category_type'] = 'required';
//        }

        if ($validator->fails()) {
            return collect(["status" => 0, "msg" => $validator->errors()])->toJson();
        }

        $userID = User::where('email', $request->email)->value('id');
        if (!isset($userID)) {
            return collect(["status" => 0, "msg" => "Candidate not found"])->toJson();
        }

        if ($request->file('img_name')) {
            $image = $request->file('img_name');
            $path = 'storage/profile_pic';
            $filename = uniqid() . time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);
            User::where('id', $userID)->update(["img_path" => $path, "image_name" => $filename]);
        }

        $updatedUser = User::where('id', $userID)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_number' => $request->company_mobile_1
        ]);
        $candidate_id = Candidate::where('user_id', $userID)->value('id');
        $skills = json_encode($request->skills);
        $updatedCandidate = Candidate::where('id', $candidate_id)->update([
            'about' => $request->about,
            'qualification_id' => $request->qualification_id,
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

        if(!isset($updatedUser) || !isset($updatedUser)){
            DB::rollBack();
            return collect(["status" => 1, "msg" => "Date not updated"])->toJson();
        }
        DB::commit();
        $user = User::where('id', $userID)->first();
        $imagePath = $user->img_path ? '/'.$user->img_path .'/'.$user->image_name : "/images/portrait/small/avatar-s-11.jpg";
        return collect(["status" => 1, "msg" => "Candidate Resume Updated Successfully", 'imagePath' => $imagePath])->toJson();
    }
}
