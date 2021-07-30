<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
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
            $isCompleted = $this->checkCandidateProfileCompleted($user->id);
            if(!$isCompleted)
            {
                flash()->overlay('Complete Your Profile','profile');
                return redirect(route('candidate-resume-edit'));
            }
            $jobs = Job::leftJoin('applied_jobs','applied_jobs.job_id','=','jobs.id')
            ->whereNull('jobs.deleted_at')
            ->where(['jobs.draft' => '0','jobs.status' => '1'])
            ->whereDate('jobs.deadline','>=',Carbon::now())
            ->whereNull('applied_jobs.job_id')
            ->orderBy('jobs.updated_at')
            ->select('applied_jobs.job_id','jobs.*')
            ->get(); 
            foreach($jobs as $job)
            {
               $job['score'] = $this->score($job, $user->id);
            }
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
        $skills = json_decode($job->skills);
        $qualification = json_decode($job->qualification_id);
        $breadcrumbs = [
            ['link' => URL::previous(), 'name' => app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName() === 'jobs' ? "Job List" : 'Future Event'],
            ['name' => "Create Job"],
        ];

        return view('job.view', compact('job', 'skills', 'qualification', 'breadcrumbs'));
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
