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
            "id"=> 1,
            "plan_name" => "Basic Plan",
            "post_quota" => 12,
            "duration" => 12,
            "amount" => 1000
        ]);
        Package::create([
            "id"=> 2,
            "plan_name" => "Premium Plan",
            "post_quota" => 24,
            "duration" => 12,
            "amount" => 2000
        ]);
    }
}
