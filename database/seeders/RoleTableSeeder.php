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
            'admin-dashboard',
           'admin-recruiter',
           'admin-candidates',
           'admin-jobfair',
           'admin-feedback'
        ]);

        Role::create([
            'name' => 'recruiter'
        ])->givePermissionTo([
            'recruiter-dashboard',
            'recruiter-jobs',
            'recruiter-candidates',
            'recruiter-jobfair',
            'recruiter-feedback'
        ]);

        Role::create([
            'name' => 'candidate'
        ])->givePermissionTo([
            'candidate-dashboard',
            'candidate-jobs',
            'candidate-resume',
            'candidate-video-resume',
            'candidate-jobfair',
            'candidate-feedback'
        ]);
    }
}
