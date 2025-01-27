<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            CountriesSeeder::class,
            UsersTableSeeder::class,
            MenuTableSeeder::class,
            PackageSeeder::class,
            RecruiterSeeder::class,
            RecruiterPackageSeeder::class,
            StatesSeeder::class,
            CitiesSeeder::class,
            CandidateTableSeeder::class
        ]);
    }
}
