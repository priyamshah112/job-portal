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
        // Create Permissions
        Permission::create([
            'name' => 'read-role',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-role',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-role',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-role',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'read-permission',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-permission',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-permission',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-permission',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'read-recruiter-dashboard',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-recruiter-dashboard',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-recruiter-dashboard',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-recruiter-dashboard',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'read-recruiter-job',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-recruiter-job',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-recruiter-job',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-recruiter-job',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'read-feedback',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-feedback',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-feedback',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-feedback',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'read-job-fair',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-job-fair',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-job-fair',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-job-fair',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'read-recruiter-applied-candidates',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-recruiter-applied-candidates',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-recruiter-applied-candidates',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-recruiter-applied-candidates',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'read-admin-recruiters',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-admin-recruiters',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-admin-recruiters',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-admin-recruiters',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'read-admin-candidates',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-admin-candidates',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-admin-candidates',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-admin-candidates',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'read-admin-dashboard',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-admin-dashboard',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-admin-dashboard',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-admin-dashboard',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'read-admin-job-fair',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-admin-job-fair',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-admin-job-fair',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-admin-job-fair',
            'guard_name' => 'web',
        ]);        
        Permission::create([
            'name' => 'read-candidate-all-jobs',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-candidate-all-jobs',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-candidate-all-jobs',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-candidate-all-jobs',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'read-candidate-applied-jobs',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-candidate-applied-jobs',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-candidate-applied-jobs',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-candidate-applied-jobs',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'read-candidate-resume',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-candidate-resume',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-candidate-resume',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-candidate-resume',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'read-candidate-video-resume',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'create-candidate-video-resume',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'write-candidate-video-resume',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'delete-candidate-video-resume',
            'guard_name' => 'web',
        ]);        
    }
}