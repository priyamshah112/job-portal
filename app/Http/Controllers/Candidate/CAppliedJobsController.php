<?php


namespace App\Http\Controllers\Candidate;
use App\Http\Controllers\AppBaseController;

class CAppliedJobsController extends AppBaseController
{

    public function __construct()
    {
        //        
    }

    public function index()
    {
        $this->middleware(function () {            
            if(!auth()->user()->hasPermissionTo('read-candidate-applied-jobs')){
                abort(403);
            }
        }); 
        return view('job.appliedjobs');
    }
}
