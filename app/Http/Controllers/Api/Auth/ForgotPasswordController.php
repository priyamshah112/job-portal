<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\DocUser;
use App\Models\User;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\SendMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use ApiResponser,SendMail;

    protected function sendEmail(int $strOtp, $username,$user)
    {
        $data['subject'] = "Forgot password Otp!!";
        $data['email'] = $username;
        $data['first_name'] = $user->first_name;
        $data['last_name'] = $user->last_name;
        $data['otp'] = $strOtp;
        $mail = $this->SendForgot($data, $username);

        if (empty($mail)) {
            $arr = ["status" => 400, "message" => "something went wrong", "data" => []];

            return ResponseFacade::json($arr);
        }

    }
    protected function updateOtpForUser($request, $user)
    {
        $otp = mt_rand(100000, 999999);
        DocUser::where('email', $request->email)->update([
            'otp' => $otp,
            'otp_expiry' => Carbon::now()->addMinutes(5)->format('Y-m-d H:i:s'),
        ]);
        $data['token'] = $user->createToken('Api Token')->plainTextToken;

        $this->sendEmail($otp, $user->email,$user);
        $arr = ["status" => 200, "message" => "Otp Sended To Your Email !!", "data" => $data];
        return ResponseFacade::json($arr);
    }

    public function forgotPassword(Request $request)
    {

        $rules = [
            // 'otp' => 'required|integer|min:6',
            'email' => 'required',
        ];
        $input = $request->all();

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];
            return ResponseFacade::json($arr);
        }
        $user = DocUser::with('roles')->where('email', $request->email)->first();

        if (empty($user)) {

            $arr = ["status" => 404, "message" => "Given Email not Found", "data" => []];

            return ResponseFacade::json($arr);
        } else {

            return $this->updateOtpForUser($request, $user);
        }
    }
    public function forgot_password_otpVerify(Request $request)
    {
        $rules = [
            'otp' => 'required|integer|min:6',
            'email' => 'required',
        ];
        $input = $request->all();

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];

            return ResponseFacade::json($arr);
        }

        $user = DocUser::with('roles')->where('id', $request->user()->id)->first();
        if (empty($user)) {
            $arr = ["status" => 404, "message" => "Given Email not Found", "data" => []];
            return ResponseFacade::json($arr);
        }
        $otpExpired = Carbon::now()->format('Y-m-d H:i:s') > $user->otp_expiry;

        if (!$otpExpired) {
            if ($request->otp == $user->otp) {
                DocUser::where('id', $request->user()->id)->update([
                    'otp' => null,
                    'otp_expiry' => null,
                ]);
                $data['user'] = $user;

                return $this->successResponse(["status" => 200, "message" => "Otp verified Successfully for forgot password !!", "data" => []]);
            }
        } else {
            return ["status" => 402, "message" => "Invalid Otp", "data" => []];
        }
    }
    public function forgotPasswordChange(Request $request)
    {
        $input = $request->all();
        $rules = [
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];
            return ResponseFacade::json($arr);
        } else {
            try {

                $user = DocUser::with('roles')->where('id', $request->user()->id)->first();
                if (empty($user)) {
                    $arr = ["status" => 404, "message" => "Given Email not Found", "data" => []];
                    return ResponseFacade::json($arr);
                }
                if ((Hash::check(request('new_password'), $user->password)) == true) {
                    $arr = ["status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => []];
                } else {
                    DocUser::where('email', $request->email)->update(['password' => Hash::make($input['new_password'])]);
                    $data['token'] = $user->createToken('API Token')->plainTextToken;
                    $data['user'] = $user;
                    $arr = ["status" => 200, "message" => "Password updated successfully.", "data" => $data];
                }
            } catch (Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = ["status" => 400, "message" => $msg, "data" => []];
            }
        }
        return ResponseFacade::json($arr);
    }
}