<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\State;

class StateApiController extends AppBaseController
{
    public function index()
    {
        $states = State::all();
        return $this->sendResponse($states, 'State Retreived Successfully');
    }

    public function countryBy($id)
    {
        $states= State::where("country_id",$id)->get(["name", "id"]);
        return $this->sendResponse($states, 'State Retreived Successfully');
    }
}
