<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\IndustrySegment;

class IndustrySegmentApiController extends AppBaseController
{
    public function index()
    {
        $industry_segments = IndustrySegment::all();
        return $this->sendResponse($industry_segments, 'Industry Segments Retreived Successfully');
    }
}
