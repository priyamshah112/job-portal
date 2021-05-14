<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AppBaseController;

class UserController extends AppBaseController
{

    public function __construct()
    {
        //        
    }

    public function index()
    {
        $this->middleware(function () {            
            if(!auth()->user()->hasPermissionTo('read-user')){
                abort(403);
            }
        }); 
        return view('user.index');
    }

    // Account Settings
    public function showUserAccountSettings()
    {
        $breadcrumbs = [
            ['link' => "/admin/dashboard", 'name' => "Home"],
            ['name' => "Account Settings"]
        ];

        return view('settings/account-settings', ['breadcrumbs' => $breadcrumbs]);
    }
}
