<?php

namespace Database\Seeders;

use App\Imports\QualificationsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        Excel::import(new QualificationsImport, 'importSeeder/Qualifications.xlsx');
    }
}
