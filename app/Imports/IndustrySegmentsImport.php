<?php

namespace App\Imports;

use App\Models\IndustrySegment;
use Maatwebsite\Excel\Concerns\ToModel;

class IndustrySegmentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row[1])) {
            return null;
        }
        return new IndustrySegment([
            'name' => $row[1]
        ]);
    }
}
