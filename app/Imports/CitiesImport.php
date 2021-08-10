<?php

namespace App\Imports;

use App\Models\State;
use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;

class CitiesImport implements ToModel
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
        $state = State::where('name', $row[1])->first();
        return new City([
            'state_id' => $state->id ?? NULL, 
            'name' => $row[2],
            'display_name' => $row[2],
        ]);
    }
}
