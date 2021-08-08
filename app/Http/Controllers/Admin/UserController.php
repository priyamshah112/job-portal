<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;

class UserController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $this->middleware(function () {
            if (!auth()->user()->hasPermissionTo('read-user')) {
                abort(403);
            }
        });
        return view('user.index');
    }

    // Recruiter Account Settings
    public function showRecruiterAccountSettings()
    {
        $breadcrumbs = [
            ['link' => route('dashboard'), 'name' => "Home"],
            ['name' => "Account Settings"],
        ];
        $recruiterInfo = Recruiter::where('user_id', Auth::user()->id)->with('attachments')->first();
        return view('settings/recruiter-account-settings', ['breadcrumbs' => $breadcrumbs, 'recruiterInfo' => $recruiterInfo]);
    }

    public function changeRecruiterPassword(Request $request)
    {
        $input = $request->all();
        $userid = Auth::id();
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];
            return redirect()->back()->with(['error-message' => $arr['message']]);
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = ["status" => 400, "message" => "Check your old password.", "data" => []];
                    return redirect()->back()->with(['error-message' => $arr['message']]);
                } else {
                    if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                        $arr = [
                            "status" => 400,
                            "message" => "Please enter a password which is not similar then current password.",
                            "data" => [],
                        ];
                        return redirect()->back()->with(['error-message' => $arr['message']]);
                    } else {
                        User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                        $arr = ["status" => 200, "message" => "Password updated successfully.", "data" => []];
                        return redirect()->back()->with(['success-message' => $arr['message']]);
                    }
                }
            } catch (Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                return redirect()->back()->with(['success-message' => "successfully changed"]);
            }
        }
    }

    public function changeRecruiterInfo(Request $request)
    {
        $id = Auth::id();
        $input = $request->except(['email']);
        $rules = [
            'name' => 'required|max:256',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_name' => 'required',
            'company_landline_1' => '',
            'company_landline_2' => '',
            'company_mobile_1' => 'required',
            'company_mobile_2' => '',
            'no_of_employees' => 'required',
            'industry_segment' => 'required',
            'annual_turnover' => 'required',
            'city' => 'required',
            'state' => 'required'
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];
            return redirect()->back()->with(['error-message' => $arr['message']]);
        }
        $user = User::where('id', $id)->get();
        if (empty($user)) {
            return redirect()->back()->with(['error-message' => "User Not Found"]);
        }
        User::where('id', $id)->update(['first_name' => $request->name, 'mobile_number' => $request->company_mobile_1]);
        Recruiter::where('user_id', $id)->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_landline_1' => $request->company_landline_1,
            'company_landline_2' => $request->company_landline_2,
            'company_mobile_1' => $request->company_mobile_1,
            'company_mobile_2' => $request->company_mobile_2,
            'no_of_employees' => $request->no_of_employees,
            'industry_segment' => $request->industry_segment,
            'annual_turnover' => $request->annual_turnover,
            'city' => $request->city,
            'state' => $request->state]);
        try {
            if ($request->has('img_name')) {
                if (!empty($user->thumbnail)) {
                    Storage::disk('public')->delete('profile_pic/' . $id . '/' . $user->thumbnail);
                }

                $image = $request->file('profile_picture');
                $path = 'storage/profile_pic';
                $filename = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);

                $user = User::where('id', $id)->update(["img_path" => $path, "image_name" => $filename]);
            }
            return redirect()->back()->with(['success-message' => "General Info Updated Successfully !"]);

        } catch (Exception $exception) {
            return redirect()->back()->with(['error-message' => "Error occur while upload image. Choose other image"]);

        }
    }

    // Admin Account Setting
    public function showAdminAccountSettings()
    {
        $breadcrumbs = [
            ['link' => route('dashboard'), 'name' => "Home"],
            ['name' => "Account Settings"],
        ];
        $recruiterInfo = Recruiter::where('user_id', Auth::user()->id)->first();
        return view('settings/admin-account-settings', ['breadcrumbs' => $breadcrumbs, 'recruiterInfo' => $recruiterInfo]);
    }

    public function changeAdminPassword(Request $request)
    {
        $input = $request->all();
        $userid = Auth::id();
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];
            return redirect()->back()->with(['error-message' => $arr['message']]);
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = ["status" => 400, "message" => "Check your old password.", "data" => []];
                    return redirect()->back()->with(['error-message' => $arr['message']]);
                } else {
                    if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                        $arr = [
                            "status" => 400,
                            "message" => "Please enter a password which is not similar then current password.",
                            "data" => [],
                        ];
                        return redirect()->back()->with(['error-message' => $arr['message']]);
                    } else {
                        User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                        $arr = ["status" => 200, "message" => "Password updated successfully.", "data" => []];
                        return redirect()->back()->with(['success-message' => $arr['message']]);
                    }
                }
            } catch (Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                return redirect()->back()->with(['success-message' => "successfully changed"]);
            }
        }
    }

    public function changeAdminInfo(Request $request)
    {
        $id = Auth::id();
        $input = $request->except(['email']);
        $rules = [
            'name' => 'required|max:256',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'company_name' => 'required',
            // 'company_address' =>  'required',
            // 'company_phone' =>  'required',
            // 'no_of_employees'=>  'required',
            // 'industry_segment'=>  'required',
            // 'annual_turnover'=>  'required',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];
            return redirect()->back()->with(['error-message' => $arr['message']]);
        }
        $user = User::where('id', $id)->get();
        if (empty($user)) {
            return redirect()->back()->with(['error-message' => "User Not Found"]);
        }
        User::where('id', $id)->update(['first_name' => $request->name, 'mobile_number' => $request->company_phone]);
        Recruiter::where('user_id', $id)->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_phone' => $request->company_phone,
            'no_of_employees' => $request->no_of_employees,
            'industry_segment' => $request->industry_segment,
            'annual_turnover' => $request->annual_turnover]);
        try {
            if ($request->has('profile_picture')) {
                if (!empty($user->thumbnail)) {
                    Storage::disk('public')->delete('profile_pic/' . $id . '/' . $user->thumbnail);
                }
                $image = $request->file('profile_picture');
                $path = 'storage/profile_pic';
                $filename = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);

                $user = User::where('id', $id)->update(["img_path" => $path, "image_name" => $filename]);
            }
            return redirect()->back()->with(['success-message' => "General Info Updated Successfully !"]);

        } catch (Exception $exception) {
            return redirect()->back()->with(['error-message' => "Error occur while upload image. Choose other image"]);

        }
    }

    // Candidate Account Setting
    public function showCandidateAccountSettings()
    {
        $breadcrumbs = [
            ['link' => route('dashboard'), 'name' => "Home"],
            ['name' => "Account Settings"],
        ];
        $recruiterInfo = Recruiter::where('user_id', Auth::user()->id)->first();
        return view('settings/candidate-account-settings', ['breadcrumbs' => $breadcrumbs, 'recruiterInfo' => $recruiterInfo]);
    }

    public function changeCandidatePassword(Request $request)
    {
        $input = $request->all();
        $userId = Auth::id();
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];
            return redirect()->back()->with(['error-message' => $arr['message']]);
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = ["status" => 400, "message" => "Check your old password.", "data" => []];
                    return redirect()->back()->with(['error-message' => $arr['message']]);
                } else {
                    if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                        $arr = [
                            "status" => 400,
                            "message" => "Please enter a password which is not similar then current password.",
                            "data" => [],
                        ];
                        return redirect()->back()->with(['error-message' => $arr['message']]);
                    } else {
                        User::where('id', $userId)->update(['password' => Hash::make($input['new_password'])]);
                        $arr = ["status" => 200, "message" => "Password updated successfully.", "data" => []];
                        return redirect()->back()->with(['success-message' => $arr['message']]);
                    }
                }
            } catch (Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                return redirect()->back()->with(['success-message' => "successfully changed"]);
            }
        }
    }

    public function changeCandidateInfo(Request $request)
    {
        $id = Auth::id();
        $input = $request->except(['email']);
        $rules = [
            'name' => 'required|max:256',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_name' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required',
            'no_of_employees' => 'required',
            'industry_segment' => 'required',
            'annual_turnover' => 'required',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];
            return redirect()->back()->with(['error-message' => $arr['message']]);
        }
        $user = User::where('id', $id)->get();
        if (empty($user)) {
            return redirect()->back()->with(['error-message' => "User Not Found"]);
        }
        User::where('id', $id)->update(['first_name' => $request->name, 'mobile_number' => $request->company_phone]);
        Recruiter::where('user_id', $id)->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_phone' => $request->company_phone,
            'no_of_employees' => $request->no_of_employees,
            'industry_segment' => $request->industry_segment,
            'annual_turnover' => $request->annual_turnover]);
        try {
            if ($request->has('profile_picture')) {
                if (!empty($user->thumbnail)) {
                    Storage::disk('public')->delete('profile_pic/' . $id . '/' . $user->thumbnail);
                }

                $image = $request->file('profile_picture');
                $path = 'profile_pic';
                $filename = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);

                $user = User::where('id', $id)->update(["img_path" => $path, "image_name" => $filename]);
            }
            return redirect()->back()->with(['success-message' => "General Info Updated Successfully !"]);

        } catch (Exception $exception) {
            return redirect()->back()->with(['error-message' => "Error occur while upload image. Choose other image"]);

        }
    }

}
