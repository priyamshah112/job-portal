<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillApiController extends AppBaseController
{
    public function index()
    {
        $skills = Skill::all();
        return $this->sendResponse($skills, 'Skills Retreived Successfully');
    }
}
