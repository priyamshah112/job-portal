<?php

namespace Database\Seeders;

use App\Models\Package;
use Carbon\Carbon;
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
        Package::updateOrCreate([
            "plan_name" => "Basic Plan"
        ],[
            "post_quota" => 12,
            "location_quota" => 1,
            "duration" => 12,
            "amount" => 5000
        ]);
        Package::updateOrCreate([
            "plan_name" => "Bronze Plan"
        ],[
            "post_quota" => 24,
            "location_quota" => 3,
            "duration" => 12,
            "amount" => 9000
        ]);

        Package::updateOrCreate([
            "plan_name" => "Silver Plan"
        ],[
            "post_quota" => 60,
            "location_quota" => 3,
            "duration" => 12,
            "amount" => 14000
        ]);

        Package::updateOrCreate([
            "plan_name" => "Golden Plan"
        ],[
            "post_quota" => "unlimited",
            "location_quota" => 3,
            "duration" => 12,
            "amount" => 18000
        ]);

        Package::updateOrCreate([
            "plan_name" => "Free Trial Plan"
        ],[
            "post_quota" => 4,
            "location_quota" => 1,
            "duration" => 1,
            "amount" => 0
        ]);
        
        Package::withTrashed()->updateOrCreate([
            "plan_name" => "Free Promotion Plan"
        ],[
            "post_quota" => 12,
            "location_quota" => 1,
            "duration" => 3,
            "amount" => 0,
            "deleted_at" => Carbon::now()
        ]);
    }
}
