<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Login
    public function showLoginForm()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('/auth/login', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function showLoginFormAdmin()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('/auth/login-admin', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
            'usertype' => 'required'
        ]);
        $userTypes = collect(["4y0h9WnLw/TjWXpwK9EZ4D7WCZaB9s/2U/sPcnup1do=", "UmgoIhfJWomN4jLW5wPXoMkIY8l5PPY6Tq8bPjzx6mg="]);
        if (!$userTypes->contains($request->usertype)) {
            return response()->json([
                'error' => 'Invalid User login.'
            ], 401);
        }
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->hasRole('admin') && $request->usertype == "4y0h9WnLw/TjWXpwK9EZ4D7WCZaB9s/2U/sPcnup1do=") {
                return redirect()->intended('/admin/dashboard');
            } else if ($user->hasRole('recruiter') && $request->usertype == "UmgoIhfJWomN4jLW5wPXoMkIY8l5PPY6Tq8bPjzx6mg="){
                return redirect()->intended('recruiter/dashboard');
            } else if ($user->hasRole('candidate') && $request->usertype == "UmgoIhfJWomN4jLW5wPXoMkIY8l5PPY6Tq8bPjzx6mg="){
                return redirect()->intended('candidate/list-resume');
            } else {
                Auth::logout();
            }
            // return redirect()->intended('dashboard');
        }  else {
            $this->incrementLoginAttempts($request);
            redirect()->back()->with(['message' => 'Invalid Credentials']);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function logout(Request $request)
    {
        if(Auth::user()->user_type == "admin") {
            $this->guard()->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect('/admin/login');
        }
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }
}
