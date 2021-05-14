<?php

namespace App\Traits;

use App\Mail\Credential;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotOtp;
use App\Mail\LoginOtp;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
 */

trait SendMail
{
    public function sendCredentialMail($data, $username)
    {

        Mail::to($username)->send(new Credential($data));
        if (Mail::failures()) {
            return false;
        }
        return true;
    }
    public function SendLoginOtp($data, $username)
    {
        Mail::to($username)->send(new LoginOtp($data));
        if (Mail::failures()) {
            return false;
        }
        return true;

    }
    public function SendForgot($data, $username)
    {
        Mail::to($username)->send(new ForgotOtp($data));
        if (Mail::failures()) {
            return false;
        }
        return true;

    }
}