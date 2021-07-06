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
            'qualification_id' => 1,
            'dateOfBirth' => now(),
            'gender' => 'male',
            "mobile_number"=>'1234567890',
            "alt_email" =>'test@test.com' ,
            "permanent_address"=>'Mettupalayam',
            "category"=>'fresher',
            "department_id" => '38',
            "skills"=>json_encode(["Java", "PHP"]),
            "category_work"=>'IT',

        ]);
    }
}
