<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\User;
use App\Traits\NotificationTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends AppBaseController
{
    use NotificationTraits;

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6',
        ];

        $input = $request->all();

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError('These credentials do not match our records.');
        }
        
        $token = $user->createToken('API Token')->plainTextToken;

        $this->notification([
            "title" => 'Hey '.$user->first_name.' ' . $user->last_name.', Welcome to the platform',
            "description" => 'Welcome to the platform !!',
            "receiver_id" => $user->id,
            "sender_id" => $user->id,
        ]);

        return $this->sendResponse([
            'user' => $user,
            'token' => $token,
        ], 'User Login Successfully');
    }

    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->delete();

            return $this->SendSuccess('User logged Out');
        } catch (\Throwable $exception) {
            DB::rollback();
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


}
