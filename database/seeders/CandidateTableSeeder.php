<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Seeder;

class CandidateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Candidate::create([
            "id" =>'1',
            'user_id' =>'1',
            'dateOfBirth' => now(),
            "mobile_number"=>'1234567890',
            "alt_email" =>'test@test.com' ,
            "permanent_address"=>'Mettupalayam',
            "category"=>'fresher',
            "industry_type" => 'IT',
            "skills"=>json_encode(["Java", "PHP"]),
            "category_work"=>'IT',

        ]);
    }
}
