<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Http\Controllers\AppBaseController;


class CountryApiController extends AppBaseController
{

    public function index()
    {
        $countries = Country::all();

        return $this->sendResponse($countries, 'Countries retrieved successfully');
    }

    public function show($id)
    {
        $country = Country::find($id);

        if (empty($country)) {
            return $this->sendError('Country not found');
        }

        return $this->sendResponse($country, 'Country retrieved successfully');
    }

}