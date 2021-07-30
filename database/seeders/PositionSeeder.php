<?php

namespace Database\Seeders;

use App\Imports\PositionsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new PositionsImport, 'importSeeder/Positions.xlsx');
    }
}
