<?php


namespace App\Http\Controllers\Candidate;


use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Cities;
use App\Models\States;
use App\Models\User;
use Illuminate\Http\Request;

class CResumeController extends Controller
{

    public function edit()
    {
        $breadcrumbs = [
            ['link' => "candidate/list-resume", 'name' => "Resume"],
            ['name' => "Edit Resume"],
        ];
        $user_id = auth()->user()->id;
        $candidate = Candidate::with('user')->where('user_id', $user_id)->first();


        $cities = Cities::get(["name", "id"])->take(10);
        return view('/resume/my-resume/edit', [
            'breadcrumbs' => $breadcrumbs,
            'cities' => $cities,
            'candidate' => $candidate
        ]);
    }

    public function index()
    {
        $user_id = auth()->user()->id;

        $candidate = Candidate::with('user')->where('user_id', $user_id)->first();
        $userType = 'candidate';
        $candidateData = Candidate::where('user_id', $user_id)->first();

        if ($candidateData) {
            $capturedVideo = $candidateData->video_resume_name ? true : false;
        } else {
            $capturedVideo = false;
        }
        return view('/resume/my-resume/index',compact('candidate', 'capturedVideo', 'userType'));
    }

    public function update(Request $request)
    {

        $id = auth()->user()->id;
        $arr = [
            "first_name" => 'required',
            "last_name" => 'required',
            "dateOfBirth" => 'required',
            "permanent_address" => 'required',
            "city" => "required",
            "state" =>'required',
            "company_mobile_1" => "required",
            "email" => 'required',
            "alt_email" => 'required',
            "category" => 'required',
            "industry_type" => 'required',
            "job_location" => 'required',
            "img_name" => 'image|max:2048',
            "skills" => 'required|array',
            "education" => 'required',
            "about" => 'required',
        ];

        if($request->category == 'experienced'){
             $arr['category_type'] = 'required';

        }
      //  dd($arr); die();

        $request->validate($arr);
       // die($request);
        $image_name = "";
        if ($request->file('img_name')) {
            $filenameWithExt = $request->file('img_name')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img_name')->getClientOriginalExtension();
            $image_name = $filename . '_' . time() . '.' . $extension;
            $request->file('img_name')->storeAs('public/profile_pic', $image_name);
            User::where('id', $id)->update(['img_path' => "storage/profile_pic", 'image_name' => $image_name]);
        }


        User::where('id', $id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile_number' => $request->company_mobile_1,

        ]);
        $candidate_id = Candidate::where('user_id', $id)->first('id');
        $skills = json_encode($request->skills);

        $candidate = Candidate::where('id', $candidate_id->id)->update([
            'about'=> $request->about,
            'education' =>$request->education,
            'current_location_state' => $request->state,
            'current_location_city' => $request->city,
            'skills' => $skills,
            'dateOfBirth' => $request->dateOfBirth,
            'mobile_number' => $request->company_mobile_2,
            'alt_email' => $request->alt_email,
            'permanent_address' => $request->permanent_address,
            'category' => $request->category,
            'industry_type' => $request->industry_type,
            'category_work' => $request->category_type,

        ]);
        $message = 'Resume Updated Successfully';
        return redirect()->back()->with(['message' => $message]);
    }
}
