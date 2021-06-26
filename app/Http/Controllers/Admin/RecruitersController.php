<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Http\Request;

class RecruitersController extends AppBaseController
{
    public function index()
    {
        return view('recruiters.index');
    }

    public function show($id)
    {
        $breadcrumbs = [
            ['link' => "recruiters", 'name' => "Recruiter"],
            ['name' => "View Recruiter"],
        ];
        $user = User::with('recruiter')->where('id', $id)->first();
        return view('recruiters.view', compact('user', 'breadcrumbs'));
    }

    public function edit(Request $request)
    {
        $breadcrumbs = [
            ['link' => "recruiters", 'name' => "Recruiter"],
            ['name' => "Edit Recruiter"],
        ];
        $id = $request->id;
        $user = User::with('recruiter')->where('id', $id)->first();
        return view('recruiters.edit', compact('user', 'breadcrumbs'));
    }

}
