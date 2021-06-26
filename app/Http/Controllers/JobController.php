<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends AppBaseController
{

    public function index()
    {
        return view('job.list');
    }

    public function appliedJobs()
    {
        return view('job.applied');
    }

    public function appliedCandidates()
    {
        return view('job.candidates');
    }

    public function show($id)
    {
        $job = Job::where('id', $id)->first();
        $skills = json_decode($job->skills);
        $qualification = json_decode($job->qualification);
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
        $qualification = json_decode($job->qualification);

        return view('job.edit', compact('job', 'skills', 'qualification',
        'breadcrumbs'));
    }
}
