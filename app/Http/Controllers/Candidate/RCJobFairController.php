<?php


namespace App\Http\Controllers\Candidate;
use App\Http\Controllers\AppBaseController;

class RCJobFairController extends AppBaseController
{

    public function __construct()
    {
        //        
    }

    public function index()
    {
        $this->middleware(function () {            
            if(!auth()->user()->hasPermissionTo('read-job-fair')){
                abort(403);
            }
        }); 
        return view('job-fair.view');
    }

}
