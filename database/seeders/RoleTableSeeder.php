<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create uper Super Admin, Student, Instructor role as defaults.
       Role::create([
            'name' => 'admin'
        ])->givePermissionTo([
            'dashboard',
            'recruiter',
            'candidate',
            'jobfair',
            'feedback'
        ]);

        Role::create([
            'name' => 'recruiter'
        ])->givePermissionTo([
            'dashboard',
            'job',
            'applied-candidate',
            'future-event',
            'jobfair',
            'feedback'
        ]);

        Role::create([
            'name' => 'candidate'
        ])->givePermissionTo([
            'job',
            'applied-job',
            'jobfair',
            'resume',
            'video-resume',
            'feedback'
        ]);
    }
}
