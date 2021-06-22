<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Models\Recruiter;
use Yajra\DataTables\DataTables;

class ADashboardController extends Controller
{
  // Dashboard - Analytics
  public function adashboardAnalytics()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs]);
  }

  // Dashboard - Ecommerce
  public function dashboardEcommerce()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
  }

  public function adminDashboard()
  {
      if (request()->ajax()) {
          return DataTables::of(Payment::with('user'))
              ->make(true);
      }
      $pageConfigs = ['pageHeader' => false];

      return view('admin.index', ['pageConfigs' => $pageConfigs]);
  }
}
