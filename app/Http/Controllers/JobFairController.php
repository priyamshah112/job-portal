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
        else if($role === 'recruiter')
        {
            $job_fairs = Job_fair::rightJoin('recruiter_job_fairs','recruiter_job_fairs.job_fair_id','=','job_fairs.id')
            ->where('job_fairs.draft','0')
            ->whereDate('job_fairs.start_date','>',Carbon::now())
            ->orderBy('job_fairs.updated_at','DESC')
            ->select('recruiter_job_fairs.*','job_fairs.*')
            ->get();

            return view('job-fair.list', [
                'breadcrumbs' => $breadcrumbs
            ])->with('job_fairs', $job_fairs);
        }
        else
        {          
            $date = Carbon::now();
            $job_fairs = Job_fair::with('department')
            ->whereDate('start_date','<=', $date)
            ->WhereDate('end_date','>=', $date)
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
            ['link' => "javascript:void(0)", 'name' => "Future Event"],
            ['name' => "List"]
        ];
                    
        $job_fairs = Job_fair::leftJoin('recruiter_job_fairs','recruiter_job_fairs.job_fair_id','=','job_fairs.id')
        ->whereNull('recruiter_job_fairs.job_fair_id')
        ->where('job_fairs.draft','0')
        ->whereDate('job_fairs.start_date','>',Carbon::now())
        ->orderBy('job_fairs.updated_at','DESC')
        ->select('recruiter_job_fairs.*','job_fairs.*')
        ->get();

        return view('job-fair.future-events', [
            'breadcrumbs' => $breadcrumbs
        ])->with('job_fairs', $job_fairs);

    }

    public function participate($id)
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => route('future-events'), 'name' => "Future Event"],
            ['name' => "Participate"]
        ];
                    
        $job_fair = Job_fair::findOrFail($id);
        
        return view('job-fair.participate', [
            'breadcrumbs' => $breadcrumbs
        ])->with('job_fair', $job_fair);

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