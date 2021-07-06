<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentApiController extends AppBaseController
{
    public function index()
    {
        $department = Department::all();
        return $this->sendResponse($department, 'Departments Retreived Successfully');
    }
}
