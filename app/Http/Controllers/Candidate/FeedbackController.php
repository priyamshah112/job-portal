<?php


namespace App\Http\Controllers\Candidate;
use App\Http\Controllers\AppBaseController;

class FeedbackController extends AppBaseController
{

    public function __construct()
    {
        //        
    }

    public function index()
    {
        $this->middleware(function () {            
            if(!auth()->user()->hasPermissionTo('read-feedback')){
                abort(403);
            }
        }); 
        return view('feedback.index');
    }

}
