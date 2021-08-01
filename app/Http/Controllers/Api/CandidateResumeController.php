<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Models\Cities;
use App\Models\User;
use App\Traits\NotificationTraits;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CandidateResumeController extends AppBaseController
{
    use NotificationTraits;

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

    public function personalInfoUpdate(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            "first_name" => 'required',
            "last_name" => 'required',
            "dateOfBirth" => 'required',
            "gender" => 'required',
            "about" => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        DB::beginTransaction();
        try{
            $user_id = auth()->user()->id;

            if ($request->file('img_name')) {
                $image = $request->file('img_name');
                $path = 'storage/profile_pic';
                $filename = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);
                User::where('id', $user_id)->update(["img_path" => $path, "image_name" => $filename]);
            }

            $updatedUser = User::where('id', $user_id)->first();

            $updatedUser->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ]);

            $updatedCandidate = Candidate::where('user_id', $user_id)->update([
                'dateOfBirth' => $request->dateOfBirth,
                'gender' => $request->gender,
                'about' => $request->about,
            ]);

            $this->notification([
                "title" => 'Your Personal Info has been updated successfully',
                "description" => 'Your Personal Info has been updated successfully',
                "receiver_id" => $user_id,
                "sender_id" => $user_id,
            ]);

            DB::commit();

            return $this->sendResponse($updatedUser, 'Candidate Personal Information Updated Successfully');
        }
        catch(Exception $err)
        {
            DB::rollBack();
            return $this->sendError($err->getMessage());
        }

    }

    public function addressUpdate(Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($input, [
            "permanent_address" => 'required',
            "state" => 'required',
            "city" => 'required',
            "preferred_state_1" => 'required',
            "preferred_city_1" => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $input['preferred_state'] = [$input['preferred_state_1']];
        $input['preferred_city'] = [$input['preferred_city_1']];

        if(isset($request->preferred_state_2))
        {
            $input['preferred_state'][] = $input['preferred_state_2'];    
        }

        if(isset($request->preferred_city_2))
        {
            $input['preferred_city'][] = $input['preferred_city_2'];    
        }

        if(isset($request->preferred_state_3))
        {
            $input['preferred_state'][] = $input['preferred_state_3'];    
        }

        if(isset($request->preferred_city_3))
        {
            $input['preferred_city'][] = $input['preferred_city_3'];    
        }

        $user_id = auth()->user()->id;

        $candidate = Candidate::where('user_id', $user_id)->first();
        
        $candidate->update($input);

        $this->notification([
            "title" => 'Your Address has been updated successfully',
            "description" => 'Your Address has been updated successfully',
            "receiver_id" => $user_id,
            "sender_id" => $user_id,
        ]);

        return $this->sendResponse($candidate, 'Candidate Address Updated Successfully'); 
    }

    public function contactUpdate(Request $request)
    {
        $user_id = auth()->user()->id;

        $candidate = Candidate::where('user_id', $user_id)->first();
        
        $candidate->update([
            'alt_email' => isset($request->alt_email) ? $request->alt_email : null,
            'alt_mobile_number' => isset($request->alt_mobile_number) ? $request->alt_mobile_number : null,
        ]);

        $this->notification([
            "title" => 'Your Contact has been updated successfully',
            "description" => 'Your Contact has been updated successfully',
            "receiver_id" => $user_id,
            "sender_id" => $user_id,
        ]);

        return $this->sendResponse($candidate, 'Candidate Contactrmation Updated Successfully');
    }

    public function qualificationUpdate(Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($input, [
            "category" => 'required',
            "department_id" => 'required',
            "skills" => 'required|array',
            "qualification_id" => 'required',
            "previous_company" => 'required_if:category,==,experience',
            "previous_position" => 'required_if:category,==,experience',
            "experience" => 'required_if:category,==,experience',
            "previous_ctc" => 'required_if:category,==,experience',
            "expected_salary" => 'required_if:category,==,experience'
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $user_id = auth()->user()->id;

        $candidate = Candidate::where('user_id', $user_id)->first();
        
        $candidate->update($input);

        $this->notification([
            "title" => 'Your Qualification has been updated successfully',
            "description" => 'Your Qualification has been updated successfully',
            "receiver_id" => $user_id,
            "sender_id" => $user_id,
        ]);

        return $this->sendResponse($candidate, 'Candidate Qualification Updated Successfully');
    }
}
