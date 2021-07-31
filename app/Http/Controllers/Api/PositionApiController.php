<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Position;

class PositionApiController extends AppBaseController
{
    public function index()
    {
        $positions = Position::all();
        return $this->sendResponse($positions, 'Positions Retreived Successfully');
    }
}
