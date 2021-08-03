<?php


namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobFair;
use App\Models\RecruiterJobFair;
use App\Traits\JobTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class JobFairController extends Controller
{
    use JobTrait;

    public function index()
    {
        $breadcrumbs = [
            ['link' => route('dashboard'), 'name' => "Home"],
            ['link' => route('job-fairs'), 'name' => "Job Fair"],
            ['name' => "List"]
        ];
        $user = Auth::user(); 
        $role = $user->user_type;
    
        if($role === 'admin')
        {            
            $job_fairs = JobFair::with('department')
            ->orderBy('updated_at','DESC')
            ->get();

            return view('job-fair.list', [
                'breadcrumbs' => $breadcrumbs
            ])->with('job_fairs', $job_fairs);
        }
        else if($role === 'recruiter')
        {
            $job_fairs = JobFair::rightJoin('recruiter_job_fairs',function($join) use($user){
                $join->on('recruiter_job_fairs.job_fair_id','=','job_fairs.id')
                ->where('recruiter_job_fairs.recruiter_id',$user->id);
            })
            ->where('job_fairs.draft','0')
            ->orderBy('job_fairs.updated_at','DESC')
            ->select('recruiter_job_fairs.*','job_fairs.*')
            ->get();

            return view('job-fair.list', [
                'breadcrumbs' => $breadcrumbs
            ])->with('job_fairs', $job_fairs);
        }
        else
        {    
            $user = auth()->user();
            $isProfileCompleted = $this->checkCandidateProfileCompleted($user->id);
            if(!$isProfileCompleted)
            {
                flash()->overlay('Complete Your Profile','ok');
                return redirect(route('candidate-resume-edit'));
            }

            $isVideoResumeCompleted = $this->checkVideoResumeCompleted($user->id);
            if(!$isVideoResumeCompleted)
            {
                flash()->overlay('Complete Video Resume','ok');
                return redirect(route('video-resume'));
            }      
            $date = Carbon::now();
            $job_fairs = JobFair::leftJoin('applied_job_fairs','applied_job_fairs.job_fair_id','=','job_fairs.id')
            ->whereNull('job_fair_id')
            ->whereDate('job_fairs.start_date','<=', $date)
            ->WhereDate('job_fairs.end_date','>=', $date)
            ->where('job_fairs.draft','0')
            ->orderBy('job_fairs.updated_at','DESC')
            ->select('applied_job_fairs.*','job_fairs.*')
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

        $user = auth()->user();
                    
        $job_fairs = JobFair::leftJoin('recruiter_job_fairs',function($join) use ($user){
            $join->on('recruiter_job_fairs.job_fair_id','=','job_fairs.id')
            ->where('recruiter_job_fairs.recruiter_id',$user->id);
        })
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
                    
        $job_fair = JobFair::findOrFail($id);
        
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

        $job_fair = JobFair::findOrFail($id);

        return view('job-fair.edit', [
            'breadcrumbs' => $breadcrumbs
        ])->with(compact('job_fair'));
    }

    public function jobs($id)
    {
        $breadcrumbs = [
            ['link' => route('dashboard'), 'name' => "Home"],
            ['link' => route('job-fairs'), 'name' => "Job Fair"],
            ['name' => "Added Jobs"]
        ];
        
        $job_fair = JobFair::findOrFail($id);

        return view('job-fair.jobs', [
            'breadcrumbs' => $breadcrumbs
        ])->with(compact('job_fair'));
    }

    public function appliedCandidates($job_fair_id,$id)
    {
        $job = Job::findOrFail($id);
        $job_fair = JobFair::findOrFail($job_fair_id); 
        
        $breadcrumbs = [
            ['link' => route('dashboard'), 'name' => "Home"],
            ['link' => route('job-fairs'), 'name' => "Job Fair"],
            ['link' =>  route('job-fair.jobs', $job_fair_id), 'name' => $job_fair->name],
            ['name' => "Candidates"]
        ];

        return view('job-fair.applied-candidates', [
            'breadcrumbs' => $breadcrumbs
        ])->with(compact('job'));
    }


    public function payments($id)
    {
        $job_fair = JobFair::findOrFail($id);
        return view('job-fair.payments')
        ->with(compact(['job_fair']));
    }
}