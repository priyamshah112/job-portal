<?php

namespace App\Imports;

use App\Models\Qualification;
use App\Models\Specialization;
use Maatwebsite\Excel\Concerns\ToModel;

class SpecializationsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row[1]) || !isset($row[2])) {
            return null;
        }
        $qualification = Qualification::where('name', $row[1])->first();
        return new Specialization([
            'qualification_id' => $qualification->id ?? NULL, 
            'name' => $row[2]
        ]);
    }
}
