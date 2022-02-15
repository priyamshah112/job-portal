<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\AppliedJob;
use App\Models\Package;
use App\Models\Payment;
use App\Models\RecruiterPackage;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  
  public function index()
  {
    $pageConfigs = ['pageHeader' => false];

    $role = Auth::user()->user_type; 
    
    if($role === 'admin')
    {
      $recruiters_count = User::role('recruiter')->count();
      $candidates_count = User::role('candidate')->count();
      $jobs_count = Job::whereNull('deleted_at')->where(['draft' => '0'])->count();
      $total_hired_count = AppliedJob::where('job_status','hire')->count();
      return view('admin.dashboard', ['pageConfigs' => $pageConfigs])->with(compact(['recruiters_count','candidates_count','jobs_count','total_hired_count']));
    }
    else if($role === 'recruiter')
    {
      $candidates_count = AppliedJob::distinct('candidate_id')->count();
      $jobs_count = Job::whereNull('deleted_at')->where(['draft' => '0','recruiter_id'=>auth()->user()->id])->count();
      $total_hired_count = AppliedJob::where('job_status','hire')->count();
      $amount_spent = Payment::where([
        'status' => 'success',
        'created_by' => auth()->user()->id
        ])->sum('amount');

      $free_package = Package::where('plan_name', "Free Trial Plan")->first();

      $past_plan = RecruiterPackage::with('package')->where('recruiter_id', auth()->user()->id)->first();

      if(!empty($past_plan))
      {
        $packages = Package::when(!empty($free_package), function($q) use ($free_package) {
          $q->where('id', '!=', $free_package->id);
        })->get();
      }
      else
      {
        $packages = Package::when(!empty($free_package), function($q) use ($free_package) {
          $q->leftJoin('recruiter_packages', 'recruiter_packages.package_id', '=', 'packages.id')->where('recruiter_packages.package_id', '!=', $free_package->id)->orWhereNull('recruiter_packages.package_id')->select('packages.*', 'recruiter_packages.package_id');
        })->get();
      }

      $active_plan = RecruiterPackage::with('package')->where(['recruiter_id'=>auth()->user()->id,'status' => 'active'])->first();

      return view('recruiter.dashboard', ['pageConfigs' => $pageConfigs])->with(compact(['packages','active_plan', 'past_plan', 'candidates_count','jobs_count','total_hired_count','amount_spent']));
    }
  }
}
