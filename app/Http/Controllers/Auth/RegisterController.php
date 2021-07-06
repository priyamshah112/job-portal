<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendNotification;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Cities;
use App\Models\Recruiter;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\NotificationTraits;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers, NotificationTraits;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(Request $request)
    {

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'user_type' => [],
            'company_name' => ['required', 'string', 'max:255'],
            'company_address' => ['required', 'string', 'max:255'],
            'company_landline_1' => [],
            'company_landline_2' => [],
            'company_mobile_1' => ['required', 'string', 'max:255'],
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
            'mobile_number' => $request['company_mobile_1'],
            'user_type' => 'recruiter',
        ]);
        $user->assignRole('recruiter');
        $recruiter = Recruiter::create([
            'user_id' => $user->id,
            'company_name' => $request['company_name'],
            'company_address' => $request['company_address'],
            'company_landline_1' => $request['company_landline_1'],
            'company_landline_2' => $request['company_landline_2'],
            'company_mobile_1' => $request['company_mobile_1'],
            'company_mobile_2' => $request['company_mobile_2'],
            'industry_segment' => $request['industry_segment'],
            'department_id' => $request['department_id'],
            'no_of_employees' => $request['no_of_employees'],
            'annual_turnover' => $request['annual_turnover'],
            'state' => $request['state'],
            'city' => $request['city'],
        ]);

        if (!$user || !$recruiter) {
            DB::rollback();
        } else {
            DB::commit();
        }
        $user->sendEmailVerificationNotification();
        return redirect()->intended('/pending-status');
    }

    // Register
    public function showRegistrationForm()
    {
        $pageConfigs = ['blankPage' => true];

        $cities = Cities::get(["name", "id"])->take(10);

        return view('recruiter.register', [
            'pageConfigs' => $pageConfigs,
            'cities' => $cities,
        ]);
    }

    public function candidateRegister()
    {
        $pageConfigs = ['blankPage' => true];

        $cities = Cities::get(["name", "id"])->take(10);

        return view('candidate.register', [
            'pageConfigs' => $pageConfigs,
            'cities' => $cities,
        ]);
    }

    public function candidateCreate(Request $request)
    {

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'about' => 'required',
            'qualification_id' => 'required',
            'dateOfBirth' => 'required',
            'gender' => 'required',
            'permanent_address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'company_mobile_1' => 'required',
            'email' => ['required', Rule::unique('users')],
            'password' => 'required|string|min:8|confirmed',
            'category' => 'required',
            'department_id' => 'required',
            'skills' => 'required|array',
            'job_state' => 'required',
            'job_city' => 'required',
        ]);
        if($request->category == 'experienced'){
            $arr['category_type'] = 'required';
        }

        DB::beginTransaction();
        $skills = json_encode($request->skills);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'mobile_number' => $request->company_mobile_1,
            'user_type' => 'candidate',
            'active' => '1',
        ]);

        $user->assignRole('candidate');

        $candidate = Candidate::create([
            'user_id' => $user->id,
            'about' => $request->about,
            'qualification_id' => $request->qualification_id,
            'skills' => $skills,
            'dateOfBirth' => $request->dateOfBirth,
            'gender' => $request->gender,
            'mobile_number' => $request->company_mobile_2,
            'alt_email' => $request->alt_email,
            'permanent_address' => $request->permanent_address,
            'category' => $request->category,
            'department_id' => $request->department_id,
            'category_work' => $request->company_type,
            'current_location_state' => $request->state,
            'current_location_city' => $request->city,
            'job_location_state' => $request->job_state,
            'job_location_city' => $request->job_city,
        ]);
        
        if (!$candidate) {
            DB::rollback();
        } else {
            DB::commit();
        }
        $user->sendEmailVerificationNotification();
        return redirect()->intended('/pending-status');
    }

}
