<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DocUser;
use App\Models\User;
use App\Traits\ApiResponser;
use App\Traits\SendMail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    use ApiResponser, SendMail;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = $this->validateRegisterRequest($request);

            if ($validator->fails()) {
                $arr = [
                    "status" => Response::HTTP_BAD_REQUEST,
                    "message" => $validator->errors()->first(),
                    "data" => [],
                ];

                return ResponseFacade::json($arr);
            }

            $user = DocUser::create([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'password' => bcrypt($request->get('password')),
                'email' => $request->get('email'),
                'type' => $request->get('type'),
                'mobile_number' => $request->get('mobile_number'),
                'country' => $request->get('country'),
            ]);

            if (!empty($user)) {
                $user->assignRole($request->get('type'));
                //send user email verification
                $this->emailVerification($request);
                return $this->success([
                    'token' => $user->createToken('API Token')->plainTextToken,
                    'user' => $user,
                ], 'User Details Saved Successfully or Email Sended To OTP');
            }

        } catch (\Throwable $exception) {
            return response([
                'message' => 'Please contact backend developer',
                'data' => [
                    'error' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                ],
            ], 404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6',
        ];

        $input = $request->all();
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];

            return ResponseFacade::json($arr);
        }

        $user = DocUser::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.'],
            ], 404);
        }
        if ($user->active == 0) {
            return response([
                'message' => ['Your Account Is InActive Contact Admin.'],
            ], 404);
        }

        $token = $user->createToken('Api Token')->plainTextToken;

        return $this->success([
            'user' => $user,
            'token' => $token,
        ], 'User Login Successfully');
    }

    /**
     * @return string[]
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'User logged Out',
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
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

            return ResponseFacade::json($arr);

        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = ["status" => 400, "message" => "Check your old password.", "data" => []];
                } else {
                    if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                        $arr = [
                            "status" => 400,
                            "message" => "Please enter a password which is not similar then current password.",
                            "data" => [],
                        ];
                    } else {
                        DocUser::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                        $arr = ["status" => 200, "message" => "Password updated successfully.", "data" => []];
                    }
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

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function emailVerification($request)
    {
        $user = DocUser::where('email', $request->email)->first();
        if (empty($user)) {
            $arr = ["status" => 404, "message" => "Given Email not Found", "data" => []];

            return ResponseFacade::json($arr);
        }
        if (empty($user->email_verified_at)) {
            return $this->updateOtpForUser($request, $user);
        } else {
            return $arr = ["status" => 200, "message" => "Your Email Already Verified !!", "data" => $user];
        }
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function emailVerificationOtp(Request $request)
    {
        $rules = [
            'otp' => 'required|integer|min:6',
        ];
        $input = $request->all();
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ["status" => 400, "message" => $validator->errors()->first(), "data" => []];
        }
        $user = DocUser::where('id', $request->user()->id)->first();
        if (empty($user)) {
            $arr = ["status" => 404, "message" => "Given Email not Found", "data" => []];

            return ResponseFacade::json($arr);
        }
        $otpExpired = Carbon::now()->format('Y-m-d H:i:s') > $user->otp_expiry;
        if (empty($user->email_verified_at) && !$otpExpired) {
            if ($request->otp == $user->otp) {
                DocUser::where('id', $request->user()->id)->update([
                    'otp' => null,
                    'otp_expiry' => null,
                    'email_verified_at' => Carbon::now(),
                ]);
                $user = DocUser::where('id', $request->user()->id)->first();

                return $this->successResponse([
                    "status" => 200,
                    "message" => "Email verified Successfully !!",
                    "data" => $user,
                ]);
            } else {
                return ["status" => 402, "message" => "Invalid Otp", "data" => []];
            }
        } elseif ($user->email_verified_at) {
            return ["status" => RESPONSE::HTTP_FORBIDDEN, "message" => " Email Already verified", "data" => []];
        } else {
            return ["status" => 402, "message" => "Invalid Otp", "data" => []];
        }
    }

    /**
     * @param int $strOtp
     * @param     $username
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendEmail(int $strOtp, $username)
    {

        $data['subject'] = "Email Verification Otp!!";
        $data['email'] = $username;
        // $data['password'] = $tempPassword;

        $data['otp'] = $strOtp;
        $mail = $this->SendLoginOtp($data, $username);

        if (empty($mail)) {
            $arr = ["status" => 400, "message" => "something went wrong", "data" => []];

            return ResponseFacade::json($arr);
        }
    }

    /**
     * @param $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function updateOtpForUser($request, $user)
    {
        $otp = mt_rand(100000, 999999);
        DocUser::where('email', $request->email)->update([
            'otp' => $otp,
            'otp_expiry' => Carbon::now()->addMinutes(5)->format('Y-m-d H:i:s'),
        ]);
        $this->sendEmail($otp, $user->email);
        $arr = ["status" => 200, "message" => "Otp sent To Your Email !!", "data" => $user];

        return ResponseFacade::json($arr);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateRegisterRequest(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'email' => 'required|unique:doc_users,email',
            'password' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'type' => 'required|string',
        ];

        $input = $request->all();

        return Validator::make($input, $rules);
    }

}