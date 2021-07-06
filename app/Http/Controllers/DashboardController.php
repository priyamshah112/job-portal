<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  
  public function index()
  {
    $pageConfigs = ['pageHeader' => false];

    $role = Auth::user()->user_type; 
    
    if($role === 'admin')
    {
      return view('admin.index', ['pageConfigs' => $pageConfigs]);
    }
    else if($role === 'recruiter')
    {
      $packages = Package::all();
      return view('recruiter.dashboard', ['pageConfigs' => $pageConfigs])->with('packages', $packages);
    }
  }
}
