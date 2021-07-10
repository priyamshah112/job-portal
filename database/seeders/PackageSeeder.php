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
            "post_quota" => 12,
            "location_quota" => 1,
            "duration" => 12,
            "amount" => 4000
        ]);
        Package::create([
            "plan_name" => "Bronze Plan",
            "post_quota" => 24,
            "location_quota" => 3,
            "duration" => 12,
            "amount" => 7000
        ]);

        Package::create([
            "plan_name" => "Silver Plan",
            "post_quota" => 60,
            "location_quota" => 3,
            "duration" => 12,
            "amount" => 12000
        ]);

        Package::create([
            "plan_name" => "Golden Plan",
            "post_quota" => "unlimited",
            "location_quota" => 3,
            "duration" => 12,
            "amount" => 12000
        ]);

        Package::create([
            "plan_name" => "Free Trial Plan",
            "post_quota" => 4,
            "location_quota" => 1,
            "duration" => 1,
            "amount" => 0
        ]);
        
        Package::create([
            "plan_name" => "Free Promotion Plan",
            "post_quota" => 12,
            "location_quota" => 1,
            "duration" => 3,
            "amount" => 0
        ]);
    }
}
