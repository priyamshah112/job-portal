<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
      return view('recruiters.dashboard', ['pageConfigs' => $pageConfigs]);
    }
  }
}
