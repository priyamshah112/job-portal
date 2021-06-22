<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ARecruitersController extends AppBaseController
{

    public function __construct()
    {
        //
    }

    public function view($id)
    {
        $breadcrumbs = [
            ['link' => "admin/recruiters", 'name' => "Recruiter"],
            ['name' => "View Recruiter"],
        ];
        $user = User::with('recruiter')->where('id', $id)->first();
        return view('admin-recruiters.view', compact('user', 'breadcrumbs'));
    }

    public function index()
    {
        return view('admin-recruiters.index');
    }

    public function edit(Request $request)
    {
        $breadcrumbs = [
            ['link' => "admin/recruiters", 'name' => "Recruiter"],
            ['name' => "Edit Recruiter"],
        ];
        $id = $request->id;
        $user = User::with('recruiter')->where('id', $id)->first();
        return view('admin-recruiters.edit', compact('user', 'breadcrumbs'));
    }

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile_number' => 'required',
            'status' => 'required',
            'company_name' => 'required',
            'company_address' => 'required',
            'company_mobile_1' => 'required',
            'company_mobile_2' => '',
            'company_landline_1' => '',
            'company_landline_2' => '',
            'industry_type' => 'required',
            'no_of_employees' => 'required',
            'annual_turnover' => 'required',
            'doc_name' => '',
            'state' => 'required',
            'city' => 'required',
        ]);
        if (!$validator) {
            $message = $validator->errors()->first();
            return redirect()->back()->with('error', $message);
        }

        User::find($id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile_number' => $request->company_mobile_1,
            'status' => $request->status,
        ]);
        Recruiter::where('user_id', $id)->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_mobile_1' => $request->company_mobile_1,
            'company_mobile_2' => $request->company_mobile_2,
            'company_landline_1' => $request->company_landline_1,
            'company_landline_2' => $request->company_landline_2,
            'industry_type' => $request->industry_type,
            'no_of_employees' => $request->no_of_employees,
            'annual_turnover' => $request->annual_turnover,
            'doc_name' => $request->doc_name,
            'city' => $request->city,
            'state' => $request->state
        ]);

        $message = 'Recruiter Data Updated Successfully';

        return redirect()->back()->with('success', $message);

    }

}
