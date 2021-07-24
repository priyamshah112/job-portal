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
            'name' => 'dashboard'
        ]);
        Permission::create([
            'name' => 'recruiter'
        ]);
        Permission::create([
            'name' => 'candidate'
        ]);
        Permission::create([
            'name' => 'applied-candidate'
        ]);
        Permission::create([
            'name' => 'applied-job'
        ]);
        Permission::create([
            'name' => 'job'
        ]);
        Permission::create([
            'name' => 'future-event'
        ]);
        Permission::create([
            'name' => 'jobfair'
        ]);
        Permission::create([
            'name' => 'feedback'
        ]);
       Permission::create([
            'name' => 'resume'
        ]);
        Permission::create([
            'name' => 'video-resume'
        ]);
    }
}
