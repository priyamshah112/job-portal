<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Attachments;
use App\Models\Candidate;
use Exception;
use App\Models\Recruiter;
use App\Models\User;
use App\Traits\NotificationTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserAccountController extends AppBaseController
{

    use NotificationTraits;

    public function registerafterotpcandidate(Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($input,[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required',
            'email' => ['required', Rule::unique('users')],
            'password' => 'required|string|min:8|confirmed',
        ]);

        if($validator->fails())
        {
            return $this->sendValidationError($validator->errors());
        }

        DB::beginTransaction();

        $user = User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'password' => Hash::make($input['password']),
            'email' => $input['email'],
            'mobile_number' => $input['mobile_number'],
            'user_type' => 'candidate',
            'active' => '1',
        ]);

        $user->assignRole('candidate');

        $candidate = Candidate::create([
            'user_id' => $user->id,
        ]);

        // Notifications To Candidate;
        $this->notification([
            "title" => 'Welcome to our Job Portal',
            "description" => 'We welcome you to our family',
            "receiver_id" => $user->id,
            "sender_id" => $user->id,
        ]);

        // Notifications To Admin
        $admin_id = User::role('admin')->first()->id;

        $this->notification([
            "title" => 'New Candidate ' . $user->first_name . ' ' . $user->last_name . ' has registered on the platform.',
            "description" => 'We welcome him/her to our family',
            "receiver_id" => $admin_id,
            "sender_id" => $user->id,
        ]);

        if (!$candidate) {
            DB::rollback();
        } else {
            DB::commit();
        }
        $user->sendEmailVerificationNotification();
        return collect(["status" => 1, "msg" => "Registered Successfully."])->toJson();
    }

    public function registerafterotp(Request $request) {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'user_type' => [],
            'company_name' => ['required', 'string', 'max:255'],
            'company_address' => ['required', 'string', 'max:255'],
            'company_landline_1' => [],
            'company_landline_2' => [],
            'mobile_number' => ['required', 'string', 'max:255'],
            'company_mobile_2' => [],
            'industry_segment' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'string', 'max:255'],
            'no_of_employees' => ['required', 'string', 'max:255'],
            'annual_turnover' => ['required', 'string', 'max:255'],
            'email' => ['required', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
        ]);

        DB::beginTransaction();
        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'password' => Hash::make($request['password']),
            'email' => $request['email'],
            'mobile_number' => $request['mobile_number'],
            'user_type' => 'recruiter',
        ]);
        $user->assignRole('recruiter');
        $recruiter = Recruiter::create([
            'user_id' => $user->id,
            'company_name' => $request['company_name'],
            'company_address' => $request['company_address'],
            'company_landline_1' => $request['company_landline_1'],
            'company_landline_2' => $request['company_landline_2'],
            'company_mobile_1' => $request['mobile_number'],
            'company_mobile_2' => $request['company_mobile_2'],
            'industry_segment' => $request['industry_segment'],
            'department_id' => $request['department_id'],
            'no_of_employees' => $request['no_of_employees'],
            'annual_turnover' => $request['annual_turnover'],
            'state' => $request['state'],
            'city' => $request['city'],
        ]);

        // Notifications To Recruiter

        $this->notification([
            "title" => 'Welcome to our Job Portal',
            "description" => 'We welcome you to our family',
            "receiver_id" => $user->id,
            "sender_id" => $user->id,
        ]);

        // Notifications To Admin
        $admin_id = User::role('admin')->first()->id;

        $this->notification([
            "title" => 'New Recruiter ' . $user->first_name . ' ' . $user->last_name . ' has registered on the platform.',
            "description" => 'We welcome him/her to our family',
            "receiver_id" => $admin_id,
            "sender_id" => $user->id,
        ]);
        
        if (!$user || !$recruiter) {
            DB::rollback();
        } else {
            DB::commit();
        }
        $user->sendEmailVerificationNotification();
        return collect(["status" => 1, "msg" => "Registered Successfully."])->toJson();
    }

    public function verifyemailphone(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'mobile_number' => 'required|min:10'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return collect(["status" => 0, "msg" => "Email already exist."])->toJson();
        }
        $userphone = User::where('mobile_number', $request->company_mobile_1)->first();
        if ($userphone) {
            return collect(["status" => 0, "msg" => "Mobile number already exist."])->toJson();
        }
        return collect(["status" => 1, "msg" => "Validation Success."])->toJson();
    }

    public function showAdminAccountSettings()
    {
        $breadcrumbs = [
            ['link' => "/dashboard", 'name' => "Home"],
            ['name' => "Account Settings"],
        ];
        $admin = User::where('id', 3)->first();
        return collect(["status" => 1, $admin])->toJson();
    }
    public function changeAdminInfo(Request $request)
    {
        $id = Auth::user()->id;
        $input = $request->except(['email']);
        $rules = [
            'name' => 'required|max:256',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];
            return collect(["status" => 0, "msg" => $arr['message']])->toJson();

        }
        $user = User::where('id', $id)->get();
        if (empty($user)) {
            return collect(["status" => 0, "msg" => "User Not Found"])->toJson();
        }
        User::where('id', $id)->update(['first_name' => $request->name]);
        try {
            if ($request->has('profile_picture')) {
                if (!empty($user->thumbnail)) {
                    Storage::disk('public')->delete('profile_pic/' . $id . '/' . $user->thumbnail);
                }
                $image = $request->file('profile_picture');
                $path = 'storage/profile_pic';
                $filename = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);

                User::where('id', $id)->update(["img_path" => $path, "image_name" => $filename]);
            }
            $user = User::where('id', $id)->first();
            $imagePath = $user->img_path ? '/'.$user->img_path .'/'.$user->image_name : "/images/portrait/small/avatar-s-11.jpg";
            return collect(["status" => 1, "msg" => "General Info Updated Successfully", 'imagePath' => $imagePath])->toJson();
        } catch (Exception $exception) {
            return collect(["status" => 0, "msg" => "Error occur while upload image. Choose other image"])->toJson();
        }
    }

    public function changeAdminPassword(Request $request)
    {
        $input = $request->all();
        $userid = Auth::user()->id;
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
        $validator = Validator::make($input, $rules);
        $oldPassword  = User::where('id', $userid)->value('password');
        if ($validator->fails()) {
            return collect(["status" => 0, "msg" => $validator->errors()->first()])->toJson();
        } else {
            try {
                if ((Hash::check(request('old_password'), $oldPassword)) == false) {
                    return collect(["status" => 0, "msg" => "Check your old password"])->toJson();
                } else {
                    if ((Hash::check(request('new_password'), $oldPassword)) == true) {
                        return collect(["status" => 0, "msg" => "Please enter a password which is not similar then current password."])->toJson();
                    } else {
                        User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                        return collect(["status" => 1, "msg" => "Password updated successfully"])->toJson();
                    }
                }
            } catch (Exception $ex) {
                $msg = "";
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                return collect(["status" => 0, "msg" => $msg])->toJson();
            }
        }
    }

    // Recruiter Account Settings
    public function showRecruiterAccountSettings()
    {
        $breadcrumbs = [
            ['link' => "/dashboard", 'name' => "Home"],
            ['name' => "Account Settings"],
        ];
        $recruiterInfo = Recruiter::where('user_id', 2)->first();
        return collect(["status" => 1, $recruiterInfo])->toJson();

    }
    public function attachmentDeleteById(Request $request) {
        $request->validate([
            'id'=>'required',
            'recruiter_id'=>'required'
        ]);
        try {
            $recruiterInfo = Recruiter::where('id', $request->recruiter_id)->first();
            if (!$recruiterInfo) {
                return response()->json(['message'=> 'Invalid Recruiter'], 404);
            }
            $file = Attachments::where('recruiter_id', $recruiterInfo->id)->where('id', $request->id)->first();
            if ($file) {
                $fp = str_replace('storage/', '', $file->file_path);
                Storage::disk('public')->delete($fp);
                $file->delete();
                return response()->json(['message'=> 'Deleted Successfully'], 200);
            } else {
                return response()->json(['message'=> 'File not found'], 404);
            }
        }catch (Exception $e) {
            return response()->json(['message'=> 'Something wrong. Please try again', 'data'=>$e], 402);
        }
    }
    public function attachmentDelete(Request $request) {
        $request->validate([
            'id'=>'required'
        ]);
        try {
            $user = Auth::user();
            $recruiterInfo = Recruiter::where('user_id', $user->id)->first();
            $file = Attachments::where('recruiter_id', $recruiterInfo->id)->where('id', $request->id)->first();
            if ($file) {
                $fp = str_replace('storage/', '', $file->file_path);
                Storage::disk('public')->delete($fp);
                $file->delete();
                return response()->json(['message'=> 'Deleted Successfully'], 200);
            } else {
                return response()->json(['message'=> 'File not found'], 404);
            }
        }catch (Exception $e) {
            return response()->json(['message'=> 'Something wrong. Please try again', 'data'=>$e], 402);
        }
    }
    public function attachmentList() {
        try {
            $user = Auth::user();
            $recruiterInfo = Recruiter::where('user_id', $user->id)->first();
            $files = Attachments::where('recruiter_id', $recruiterInfo->id)->get();
            return response()->json(['data'=>$files], 200);
        }catch (Exception $e) {
            return response()->json(['msg'=> 'Something wrong. Please try again'], 200);
        }
    }
    public function attachmentListById(Request $request) {
        $request->validate([
            'recruiter_id'=>'required'
        ]);
        try {
            $recruiterInfo = Recruiter::where('id', $request->recruiter_id)->first();
            if (!$recruiterInfo) {
                return response()->json(['message'=> 'Invalid Recruiter'], 404);
            }
            $files = Attachments::where('recruiter_id', $recruiterInfo->id)->get();
            return response()->json(['data'=>$files], 200);
        }catch (Exception $e) {
            return response()->json(['message'=> 'Something wrong. Please try again'], 200);
        }
    }
    public function uploadAttById(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg,pdf|max:20000',
            'recruiter_id' => "required"
        ]);
        $recruiterInfo = Recruiter::where('id', $request->recruiter_id)->first();
        if (!$recruiterInfo) {
            return response()->json(['message'=>'Invalid Recruiter'], 422);
        }
        if ($request->has('file')) {
            $file = $request->file('file');
            $ofn = $file->getClientOriginalName();
            $path = 'storage/attachments';
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . time() . '.' . $ext;
            $file->move($path, $filename);
            $d = Attachments::create([
               "recruiter_id" => $recruiterInfo->id,
                "file_path"=> $path.'/'.$filename,
                "file_name"=> $ofn,
                "extension"=> $ext
            ]);
            return collect(['status'=>1, 'msg'=> 'Uploaded Successfully', 'data' => $d])->toJson();
        } else {
            return response()->json(['message'=>'Error on uploading. Please try again'], 422);
        }
    }
    public function uploadAtt(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg,pdf|max:20000'
        ]);
        $user = Auth::user();
        $recruiterInfo = Recruiter::where('user_id', $user->id)->first();
        if ($request->has('file')) {
            $file = $request->file('file');
            $ofn = $file->getClientOriginalName();
            $path = 'storage/attachments';
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . time() . '.' . $ext;
            $file->move($path, $filename);
            $d = Attachments::create([
                "recruiter_id" => $recruiterInfo->id,
                "file_path"=> $path.'/'.$filename,
                "file_name"=> $ofn,
                "extension"=> $ext
            ]);
            return collect(['status'=>1, 'msg'=> 'Uploaded Successfully', 'data' => $d])->toJson();
        } else {
            return response()->json(['message'=>'Error on uploading. Please try again'], 422);
        }
    }

    public function changeRecruiterInfo(Request $request)
    {
        $id = Auth::id();
        $input = $request->except(['email']);
        $rules = [
            'first_name' => 'required|max:256',
            'last_name' => 'required|max:256',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_name' => 'required',
            'company_landline_1' => '',
            'company_landline_2' => '',
            'company_mobile_1' => 'required',
            'company_mobile_2' => '',
            'department_id' => 'required',
            'no_of_employees' => 'required',
            'industry_segment' => 'required',
            'annual_turnover' => 'required',
            'city' => 'required',
            'state' => 'required'
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ["status" => 0, "message" => $validator->errors()->first()];
            return collect(["status" => 0, "msg" => $arr['message']])->toJson();
        }
        $user = User::where('id', $id)->get();
        if (empty($user)) {
            return collect(["status" => 0, "msg" => "User Not Found"])->toJson();
        }
        User::where('id', $id)->update(['first_name' => $request->first_name,
         'last_name' => $request->last_name,
          'mobile_number' => $request->company_mobile_1]);
        Recruiter::where('user_id', $id)->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_landline_1' => $request->company_landline_1,
            'company_landline_2' => $request->company_landline_2,
            'company_mobile_1' => $request->company_mobile_1,
            'company_mobile_2' => $request->company_mobile_2,
            'department_id' => $request->department_id,
            'no_of_employees' => $request->no_of_employees,
            'industry_segment' => $request->industry_segment,
            'annual_turnover' => $request->annual_turnover,
            'city' => $request->city,
            'state' => $request->state]);
            try {
                if ($request->has('profile_picture')) {
                    if (!empty($user->thumbnail)) {
                        Storage::disk('public')->delete('profile_pic/' . $id . '/' . $user->thumbnail);
                    }
                    $image = $request->file('profile_picture');
                    $path = 'storage/profile_pic';
                    $filename = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                    $image->move($path, $filename);

                    User::where('id', $id)->update(["img_path" => $path, "image_name" => $filename]);
                }
                $user = User::where('id', $id)->first();
                $imagePath = $user->img_path ? '/'.$user->img_path .'/'.$user->image_name : "/images/portrait/small/avatar-s-11.jpg";
                return collect(["status" => 1, "msg" => "General Info Updated Successfully", 'imagePath' => $imagePath])->toJson();
            } catch (Exception $exception) {
                return collect(["status" => 0, "msg" => $exception])->toJson();
            }
    }
    public function changeRecruiterPassword(Request $request)
    {
        $input = $request->all();
        $loggedUserId = Auth::user()->id;
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
        $validator = Validator::make($input, $rules);
        $oldPassword  = User::where('id', $loggedUserId)->value('password');
        if ($validator->fails()) {
            return collect(["status" => 0, "msg" => $validator->errors()->first()])->toJson();
        } else {
            try {
                if ((Hash::check(request('old_password'), $oldPassword)) == false) {
                    return collect(["status" => 0, "msg" => "Check your old password"])->toJson();
                } else {
                    if ((Hash::check(request('new_password'), $oldPassword)) == true) {
                        return collect(["status" => 0, "msg" => "Please enter a password which is not similar then current password."])->toJson();
                    } else {
                        User::where('id', $loggedUserId)->update(['password' => Hash::make($input['new_password'])]);
                        return collect(["status" => 1, "msg" => "Password updated successfully"])->toJson();
                    }
                }
            } catch (Exception $ex) {
                $msg = "";
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                return collect(["status" => 0, "msg" => $msg])->toJson();
            }
        }
    }

    //candidate
    public function showCandidateAccountSettings()
    {
        $breadcrumbs = [
            ['link' => "/dashboard", 'name' => "Home"],
            ['name' => "Account Settings"],
        ];
        $candidate = Candidate::where('user_id', 1)->first();
        return collect(['success' => $candidate])->toJson();

    }
    public function changeCandidatePassword(Request $request)
    {
        $input = $request->all();
        $loggedUserId = Auth::user()->id;
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
        $validator = Validator::make($input, $rules);
        $oldPassword  = User::where('id', $loggedUserId)->value('password');
        if ($validator->fails()) {
            return collect(["status" => 0, "msg" => $validator->errors()->first()])->toJson();
        } else {
            try {
                if ((Hash::check(request('old_password'), $oldPassword)) == false) {
                    return collect(["status" => 0, "msg" => "Check your old password"])->toJson();
                } else {
                    if ((Hash::check(request('new_password'), $oldPassword)) == true) {
                        return collect(["status" => 0, "msg" => "Please enter a password which is not similar then current password."])->toJson();
                    } else {
                        User::where('id', $loggedUserId)->update(['password' => Hash::make($input['new_password'])]);
                        return collect(["status" => 1, "msg" => "Password updated successfully"])->toJson();
                    }
                }
            } catch (Exception $ex) {
                $msg = "";
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                return collect(["status" => 0, "msg" => $msg])->toJson();
            }
        }
    }

    public function changeCandidateInfo(Request $request)
    {
        $loggedUserId = Auth::user()->id;
        $input = $request->except(['email']);
        $rules = [
            'name' => 'required|max:256',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];
            return collect(["status" => 0, "msg" => $arr['message']])->toJson();

        }
        $user = User::where('id', $loggedUserId)->get();
        if (empty($user)) {
            return collect(["status" => 0, "msg" => "User Not Found"])->toJson();
        }
        User::where('id', $loggedUserId)->update(['first_name' => $request->name]);
        try {
            if ($request->has('profile_picture')) {
                if (!empty($user->thumbnail)) {
                    Storage::disk('public')->delete('profile_pic/' . $loggedUserId . '/' . $user->thumbnail);
                }
                $image = $request->file('profile_picture');
                $path = 'storage/profile_pic';
                $filename = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);

                User::where('id', $loggedUserId)->update(["img_path" => $path, "image_name" => $filename]);
            }
            $user = User::where('id', $loggedUserId)->first();
            $imagePath = $user->img_path ? '/'.$user->img_path .'/'.$user->image_name : "/images/portrait/small/avatar-s-11.jpg";
            return collect(["status" => 1, "msg" => "General Info Updated Successfully", 'imagePath' => $imagePath])->toJson();
        } catch (Exception $exception) {
            return collect(["status" => 0, "msg" => $exception])->toJson();
        }
    }
}
