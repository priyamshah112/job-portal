<?php


namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Job_fair;
use Carbon\Carbon;
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
            $job_fairs = Job_fair::with('department')
            ->where('draft','0')
            ->orderBy('updated_at','DESC')
            ->get();

            return view('job-fair.list', [
                'breadcrumbs' => $breadcrumbs
            ])->with('job_fairs', $job_fairs);
        }
        else
        {            
            $job_fairs = Job_fair::with('department')
            ->where('draft','0')
            ->orderBy('updated_at','DESC')
            ->get();
            
            return view('job-fair.list', [
                'breadcrumbs' => $breadcrumbs
            ])->with('job_fairs', $job_fairs);
        }
    }

    public function futureEvents()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Job Fair"],
            ['name' => "List"]
        ];
                    
        $job_fairs = Job_fair::with('department')
        ->where('draft','0')
        ->whereDate('start_date','>',Carbon::now())
        ->orderBy('updated_at','DESC')
        ->get();
        
        return view('job-fair.future-events', [
            'breadcrumbs' => $breadcrumbs
        ])->with('job_fairs', $job_fairs);

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

    public function editForm($id)
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => route('job-fairs'), 'name' => "Job Fair"],
            ['name' => "Edit"]
        ];

        $job_fair = Job_fair::findOrFail($id);

        return view('job-fair.edit', [
            'breadcrumbs' => $breadcrumbs
        ])->with(compact('job_fair'));
    }
}