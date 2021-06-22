<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin Permisions
        Permission::create([
            'name' => 'admin-dashboard'
        ]);
        Permission::create([
            'name' => 'admin-recruiter'
        ]);
        Permission::create([
            'name' => 'admin-candidates'
        ]);
        Permission::create([
            'name' => 'admin-jobfair'
        ]);
        Permission::create([
            'name' => 'admin-feedback'
        ]);

        // Recruiter Permisions
        Permission::create([
            'name' => 'recruiter-dashboard'
        ]);
        Permission::create([
            'name' => 'recruiter-jobs'
        ]);
        Permission::create([
            'name' => 'recruiter-candidates'
        ]);
        Permission::create([
            'name' => 'recruiter-jobfair'
        ]);
        Permission::create([
            'name' => 'recruiter-feedback'
        ]);

        // Candidates Permisions
        Permission::create([
            'name' => 'candidate-dashboard'
        ]);
        Permission::create([
            'name' => 'candidate-jobs'
        ]);
        Permission::create([
            'name' => 'candidate-resume'
        ]);
        Permission::create([
            'name' => 'candidate-video-resume'
        ]);
        Permission::create([
            'name' => 'candidate-jobfair'
        ]);
        Permission::create([
            'name' => 'candidate-feedback'
        ]);
    }
}
