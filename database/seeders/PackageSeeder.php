<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::create([
            "plan_name" => "Basic Plan",
            "post_quota" => 10,
            "duration" => 30,
            "amount" => 1000
        ]);
        Package::create([
            "plan_name" => "Premium Plan",
            "post_quota" => 30,
            "duration" => 90,
            "amount" => 2000
        ]);
        Package::create([
            "plan_name" => "Free Plan",
            "post_quota" => 5,
            "duration" => 10,
            "amount" => 0
        ]);
    }
}
