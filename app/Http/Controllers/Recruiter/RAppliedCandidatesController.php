<?php


namespace App\Http\Controllers\Recruiter;
use App\Http\Controllers\AppBaseController;

class RAppliedCandidatesController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
        $this->middleware(function () {            
            if(!auth()->user()->hasPermissionTo('read-recruiter-applied-candidates')){
                abort(403);
            }
        }); 
        return view('applied-candidates.index');
    }
}
