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
            CountriesTableSeeder::class,
            UsersTableSeeder::class,
            MenuTableSeeder::class,
            PackageSeeder::class,
            RecruiterSeeder::class,
            RecruiterPackageSeeder::class,
            StateTableSeeder::class,
            CitiesTableSeeder::class,
            CandidateTableSeeder::class
        ]);
    }
}
