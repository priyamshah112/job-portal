<?php


namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

class JobFairController extends Controller
{

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Job Fair"],
            ['name' => "List"]
        ];

        return view('/job-fair/list', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function createForm()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Job Fair"],
            ['name' => "Create new Job Fair"]
        ];

        return view('/job-fair/create/index', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}