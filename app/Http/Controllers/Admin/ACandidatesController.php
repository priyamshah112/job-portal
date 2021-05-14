<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AppBaseController;

class ACandidatesController extends AppBaseController
{

    public function __construct()
    {
        //        
    }

    public function index()
    {
        $this->middleware(function () {            
            if(!auth()->user()->hasPermissionTo('read-admin-candidates')){
                abort(403);
            }
        }); 
        return view('admin-candidates.index');
    }
}
