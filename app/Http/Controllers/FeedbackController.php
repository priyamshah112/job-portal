<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FeedbackController extends AppBaseController
{

    public function index()
    {
        $role = Auth::user()->user_type; 

        if($role === 'admin')
        {
            if (request()->ajax()) {
                return DataTables::of(Feedback::whereNull('deleted_at')->with('user'))
                    ->addColumn('action', function ($data) {
                        $menu = '<button title="Delete" onclick="deleter(' . $data->id . ', this)" class="btn p-0 m-0"><i data-feather="trash-2" class="text-danger ml-1 font-medium-5"></i></buton>';
                        return $menu;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            $pageConfigs = ['pageHeader' => false];
            return view('admin.feedback.index', ['pageConfigs' => $pageConfigs]);
        }
        else if($role === 'recruiter')
        {            
            $userType = 'recruiter';
            return view('feedback.index',compact('userType'));
        }
        else if($role === 'candidate')
        {
            $userType = 'candidate';
            return view('feedback.index',compact('userType'));
        }
    }
}
