<?php

namespace App\Imports;

use App\Models\State;
use Maatwebsite\Excel\Concerns\ToModel;

class StatesImport implements ToModel
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
        return new State([
            'name' => $row[1],
            'display_name' => $row[1], 
            'country_id' => 101,
        ]);
    }
}
