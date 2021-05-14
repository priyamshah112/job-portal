<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AppBaseController;

class ARecruitersController extends AppBaseController
{

    public function __construct()
    {
        //        
    }

    public function index()
    {
        $this->middleware(function () {            
            if(!auth()->user()->hasPermissionTo('read-admin-recruiters')){
                abort(403);
            }
        }); 
        return view('admin-recruiters.index');
    }
}
