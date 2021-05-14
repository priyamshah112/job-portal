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
            'read-admin-recruiters',
            'create-admin-recruiters',
            'write-admin-recruiters',
            'delete-admin-recruiters',
            'read-admin-candidates',
            'create-admin-candidates',
            'write-admin-candidates',
            'delete-admin-candidates',
            'read-admin-dashboard',
            'create-admin-dashboard',
            'write-admin-dashboard',
            'delete-admin-dashboard',  
            'read-admin-job-fair',
            'create-admin-job-fair',
            'write-admin-job-fair',
            'delete-admin-job-fair',                                    
        ]);

        Role::create([
            'name' => 'recruiter'
        ])->givePermissionTo([
            'read-recruiter-dashboard',
            'create-recruiter-dashboard',
            'write-recruiter-dashboard',
            'delete-recruiter-dashboard',
            'read-recruiter-applied-candidates',
            'create-recruiter-applied-candidates',
            'write-recruiter-applied-candidates',
            'delete-recruiter-applied-candidates',
            'read-recruiter-job',
            'create-recruiter-job',
            'write-recruiter-job',
            'delete-recruiter-job',
            'read-feedback',
            'create-feedback',
            'write-feedback',
            'delete-feedback',
            'read-job-fair',
            'create-job-fair',
            'write-job-fair',
            'delete-job-fair',                      
        ]);

        Role::create([
            'name' => 'candidate'
        ])->givePermissionTo([
            'read-candidate-all-jobs',
            'create-candidate-all-jobs',
            'write-candidate-all-jobs',
            'delete-candidate-all-jobs',
            'read-candidate-applied-jobs',
            'create-candidate-applied-jobs',
            'write-candidate-applied-jobs',
            'delete-candidate-applied-jobs',
            'read-candidate-resume',
            'create-candidate-resume',
            'write-candidate-resume',
            'delete-candidate-resume',
            'read-candidate-video-resume',
            'create-candidate-video-resume',
            'write-candidate-video-resume',
            'delete-candidate-video-resume',
            'read-feedback',
            'create-feedback',
            'write-feedback',
            'delete-feedback',
            'read-job-fair',
            'create-job-fair',
            'write-job-fair',
            'delete-job-fair',                      
        ]);
    }
}
