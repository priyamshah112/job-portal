<?php

namespace Database\Seeders;

use App\Imports\IndustrySegmentsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class IndustrySegmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new IndustrySegmentsImport, 'importSeeder/IndustrySegments.xlsx');
    }
}
