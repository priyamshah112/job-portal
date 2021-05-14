<?php


namespace App\Http\Controllers\Candidate;


use App\Http\Controllers\Controller;

class CResumeController extends Controller
{

    public function getCreateResumeForm()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Resume"],
            ['link' => "javascript:void(0)", 'name' => "Resume"],
            ['name' => "Create new Resume"]
        ];

        return view('/resume/create/index', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}