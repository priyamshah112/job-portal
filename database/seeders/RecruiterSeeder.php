<?php

namespace Database\Seeders;

use App\Models\Recruiter;
use Illuminate\Database\Seeder;

class RecruiterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Recruiter::create([
            "id"=> 1,
            "user_id"=>2,
            "industry_segment_id" => 2,
            "company_name"=>"Frudev",
            "company_address"=>"12121"
        ]);
    }
}
