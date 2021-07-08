<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Models\Job;
use App\Traits\JobTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $jobs = Job::leftJoin('applied_jobs','applied_jobs.job_id','=','jobs.id')
            ->whereNull('jobs.deleted_at')
            ->where(['jobs.draft' => '0'])
            ->whereNull('applied_jobs.job_id')
            ->orderBy('jobs.updated_at')
            ->select('applied_jobs.job_id','jobs.*')
            ->get(); 
            $candidate = Candidate::where('user_id', $user->id)->first();
            foreach($jobs as $job)
            {
               $job['score'] = $this->score($job, $candidate->id);
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
            ['link' => "jobs", 'name' => "Job List"],
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
        return view('job.create', ['breadcrumbs' => $breadcrumbs]);
    }


    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "jobs", 'name' => "Job List"],
            ['name' => "Create Job"],
        ];

        $job = Job::findOrFail($id);

        return view('job.edit', compact('job','breadcrumbs'));
    }
}
