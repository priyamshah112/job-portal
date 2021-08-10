<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Models\Job;
use App\Models\RecruiterPackage;
use App\Traits\JobTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class JobController extends AppBaseController
{
    use JobTrait;

    public function index()
    {
        $user = Auth::user();
        $role = $user->user_type; 
    
        if($role === 'admin' || $role === 'recruiter')
        {
            return view('job.list');
        }
        else if($role === 'candidate')
        {
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

            $jobs = Job::leftJoin('applied_jobs',function ($join) use ($user) {
                $join->on('applied_jobs.job_id', '=', 'jobs.id')
                ->where('applied_jobs.candidate_id','=', $user->id);
            })
            ->with('recruiter_details')
            ->whereNull('applied_jobs.candidate_id')
            ->whereNull('jobs.deleted_at')
            ->where(['jobs.draft' => '0','jobs.status' => '1'])
            ->whereDate('jobs.deadline','>=',Carbon::now())
            ->orderBy('jobs.updated_at','desc')
            ->select('applied_jobs.*','jobs.*')
            ->get(); 
            
            foreach($jobs as $job)
            {
               $job['score'] = $this->score($job, $user->id);
               $job['skillNames'] = $this->convertSkillIdsToSkillNames($job->skills);
               $job['qualificationNames'] = $this->convertQualificationIdsToQualificationNames(($job->qualification_id));
               $job['stateNames'] = $this->convertStateIdsToStateNames($job->state);
            }

            $jobs = collect($jobs)->sortBy('score', SORT_REGULAR, true);
            
            return view('candidate.jobs')->with('jobs', $jobs);
        }
    }

    public function appliedJobs()
    {
        return view('candidate.applied');
    }

    public function appliedCandidates()
    {
        return view('recruiter.candidates');
    }

    public function show($id)
    {
        $job = Job::where('id', $id)->first();
        $breadcrumbs = [
            ['link' => URL::previous(), 'name' => app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName() === 'jobs' ? "Job List" : 'Future Event'],
            ['name' => "Create Job"],
        ];

        
        $job['skillNames'] = $this->convertSkillIdsToSkillNames($job->skills);
        $job['qualificationNames'] = $this->convertQualificationIdsToQualificationNames(($job->qualification_id));
        $job['stateNames'] = $this->convertStateIdsToStateNames($job->state);
        $job['cityNames'] = $this->convertCityIdsToCityNames($job->city);


        return view('job.view', compact('job','breadcrumbs'));
    }

    public function createForm()
    {
        $breadcrumbs = [
            ['link' => "jobs", 'name' => "Job List"],
            ['name' => "Create Job"],
        ];        

        $recruiter_package = RecruiterPackage::with('package')->where([
            'recruiter_id' => auth()->user()->id,
            'status' => 'active'
        ])->first();

        return view('job.create', ['breadcrumbs' => $breadcrumbs])->with(compact('recruiter_package'));
    }


    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "jobs", 'name' => "Job List"],
            ['name' => "Create Job"],
        ];

        $job = Job::findOrFail($id);

        $recruiter_package = RecruiterPackage::with('package')->where([
            'recruiter_id' => auth()->user()->id,
            'status' => 'active'
        ])->first();

        return view('job.edit', compact('job','breadcrumbs','recruiter_package'));
    }
}
