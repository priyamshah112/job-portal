<?php

namespace App\Imports;

use App\Models\Qualification;
use Maatwebsite\Excel\Concerns\ToModel;

class QualificationsImport implements ToModel
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
        return new Qualification([
            'name' => $row[1]
        ]);
    }
}
