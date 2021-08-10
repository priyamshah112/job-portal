<?php

namespace Database\Seeders;

use App\Imports\StatesImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        Excel::import(new StatesImport, 'importSeeder/States.xlsx');
    }
}