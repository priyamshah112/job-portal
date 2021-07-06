<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Qualification;
use Illuminate\Http\Request;

class QualificationApiController extends AppBaseController
{
    public function index()
    {
        $qualification = Qualification::all();
        return $this->sendResponse($qualification, 'Qualifications Retreived Successfully');
    }
}
