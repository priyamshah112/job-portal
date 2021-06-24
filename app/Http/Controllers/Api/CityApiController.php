<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Cities;

class CityApiController extends AppBaseController
{

    public function index()
    {
       $cities = Cities::all();
        return $this->sendResponse($cities, 'Cities Retreived Successfully');
    }

    public function stateBy($id)
    {
       $cities = Cities::where("state_id",$id)->get(["name", "id"]);
        return $this->sendResponse($cities, 'Cities Retreived Successfully');
    }
}
