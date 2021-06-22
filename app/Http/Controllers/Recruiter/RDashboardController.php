<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;

class RDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    // Dashboard - Analytics
    public function rdashboardAnalytics()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/admin-recruiters/dashboard', ['pageConfigs' => $pageConfigs]);
    }

    // Dashboard - Ecommerce
    public function dashboardEcommerce()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
    }
}
