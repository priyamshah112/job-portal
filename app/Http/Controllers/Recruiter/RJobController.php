<?php


namespace App\Http\Controllers\Recruiter;
use App\Http\Controllers\AppBaseController;

class RJobController extends AppBaseController
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Job"],
            ['name' => "List"]
        ];

        return view('/job/list', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function getCreateJobForm()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Job"],
            ['name' => "Create new Job"]
        ];

        return view('/job/create/index', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
