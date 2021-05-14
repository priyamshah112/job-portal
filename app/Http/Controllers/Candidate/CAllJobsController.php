<?php


namespace App\Http\Controllers\Candidate;
use App\Http\Controllers\AppBaseController;

class CAllJobsController extends AppBaseController
{

    public function __construct()
    {
        //        
    }

    public function index()
    {
        $this->middleware(function () {            
            if(!auth()->user()->hasPermissionTo('read-candidate-all-jobs')){
                abort(403);
            }
        }); 
        return view('job.alljobs');
    }
}
