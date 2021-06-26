<?php


namespace App\Http\Controllers\Candidate;
use App\Http\Controllers\AppBaseController;

class VideoResumeController extends AppBaseController
{

    public function __construct()
    {
        //        
    }

    public function index()
    {
        $this->middleware(function () {            
            if(!auth()->user()->hasPermissionTo('read-candidate-video-resume')){
                abort(403);
            }
        }); 
        return view('video-resume.index');
    }
}
