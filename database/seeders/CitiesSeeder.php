<?php

namespace Database\Seeders;

use App\Imports\CitiesImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new CitiesImport, 'importSeeder/Cities.xlsx');
    }
}
