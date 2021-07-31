<?php

namespace Database\Seeders;

use App\Imports\SkillsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new SkillsImport, 'importSeeder/SkillwiseJobs.xlsx');
    }
}
