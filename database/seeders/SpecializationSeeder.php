<?php

namespace Database\Seeders;

use App\Imports\SpecializationsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new SpecializationsImport, 'importSeeder/Specializations.xlsx');
    }
}
