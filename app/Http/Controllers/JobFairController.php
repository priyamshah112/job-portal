<?php


namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Job_fair;
use Illuminate\Support\Facades\Auth;

class JobFairController extends Controller
{

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Job Fair"],
            ['name' => "List"]
        ];
        $role = Auth::user()->user_type; 
    
        if($role === 'admin')
        {            
            $job_fairs = Job_fair::with('department')->get();
            return view('job-fair.list', [
                'breadcrumbs' => $breadcrumbs
            ])->with('job_fairs', $job_fairs);
        }
        else
        {            
            $job_fairs = Job_fair::with('department')->get();
            return view('job-fair.list', [
                'breadcrumbs' => $breadcrumbs
            ])->with('job_fairs', $job_fairs);
        }
    }

    public function createForm()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Job Fair"],
            ['name' => "Create new Job Fair"]
        ];

        return view('job-fair.create', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}