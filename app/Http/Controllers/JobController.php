<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends AppBaseController
{

    public function index()
    {
        $role = Auth::user()->user_type; 
    
        if($role === 'admin' || $role === 'recruiter')
        {
            return view('job.list');
        }
        else if($role === 'candidate')
        {
            return view('candidate.jobs');
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


    public function edit(Request $request)
    {
        $breadcrumbs = [
            ['link' => "jobs", 'name' => "Job List"],
            ['name' => "Create Job"],
        ];
        $id = $request->id;
        $job = Job::where('id', $id)->first();
        $skills = json_decode($job->skills);
        $qualification = json_decode($job->qualification_id);

        return view('job.edit', compact('job', 'skills', 'qualification',
        'breadcrumbs'));
    }
}
