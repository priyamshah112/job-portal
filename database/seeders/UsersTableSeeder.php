<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $candidate = User::create([
            'first_name' => 'Candidate',
            'last_name'=> 'Last',
            'email' => 'candidate@jobportal.com',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'country_id'=> 1,
            'mobile_number' => '9874561237',
            //'image_path'=> $this->faker->image('public/storage/avatars',640,480,null,true),
            'password' => bcrypt('password'),
            'user_type' => 'candidate',
            'active' => "1",
        ]);
        $candidate->assignRole('candidate');
        $recruiter = User::create([
            'first_name' => 'Recruiter',
            'last_name'=> 'Last',
            'email' => 'recruiter@jobportal.com',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'country_id'=> 1,
            'mobile_number' => '9874561237',
            //'image_path'=> $this->faker->image('public/storage/avatars',640,480,null,true),
            'password' => bcrypt('password'),
            'user_type' => 'recruiter',
            'active' => "1",
        ]);
        $recruiter->assignRole('recruiter');
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name'=> 'Last',
            'email' => 'admin@jobportal.com',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'country_id'=> 1,
            'mobile_number' => '9874561237',
            //'image_path'=> $this->faker->image('public/storage/avatars',640,480,null,true),
            'password' => bcrypt('password'),
            'user_type' => 'admin',
            'active' => "1",
        ]);
        $admin->assignRole('admin');

    }
}
