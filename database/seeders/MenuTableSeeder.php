<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin

        Menu::create([  
            "id"=> 1,          
            'url'=> "admin/dashboard",
            'name'=> "Dashboard",
            'icon'=> "home",
            'slug'=> "admin-dashboard",
            'order'=> 1,
            'permission_id'=> Permission::where('name','read-admin-dashboard')->first()->id,
            ]);

        Menu::create([
            "id"=> 2, 
            'url'=> "admin/recruiters",
            'name'=> "Recruiters",
            'icon'=> "align-center",
            'slug'=> "arecruiters",
            'order'=> 2,
            'permission_id'=> Permission::where('name','read-admin-recruiters')->first()->id,
        ]);

        Menu::create([
            "id"=> 3, 
            'url'=> "admin/candidates",
            'name'=> "Candidates",
            'icon'=> "image",
            'slug'=> "acandidates",
            'order'=> 3,
            'permission_id'=> Permission::where('name','read-admin-candidates')->first()->id,
        ]);

        Menu::create([
            "id"=> 4, 
            'name'=> "Job Fair",
            'icon'=> "book",
            'slug'=> "",
            'order'=> 4,
            'permission_id'=> Permission::where('name','read-admin-job-fair')->first()->id,
        ]);

        Menu::create([
            "id"=> 5, 
            'url'=> "admin/create-job-fair",
            'name'=> "Create Job Fair",
            'icon'=> "plus",
            'slug'=> "create-job-fair",
            'order'=> 5,
            'parent_id'=> 4,
            'permission_id'=> Permission::where('name','create-admin-job-fair')->first()->id,
        ]);

        Menu::create([
            "id"=> 6, 
            'url'=> "admin/list-job-fair",
            'name'=> "View Job Fair",
            'icon'=> "list",
            'slug'=> "list-job-fair",
            'order'=> 6,
            'parent_id'=> 4,
            'permission_id'=> Permission::where('name','read-admin-job-fair')->first()->id,
        ]);

        // Recruiter
        
        Menu::create([
            "id"=> 7, 
            'url'=> "recruiter/dashboard",
            'name'=> "Dashboard",
            'icon'=> "speaker",
            'slug'=> "recruiter-dashboard",
            'order'=> 7,
            'permission_id'=> Permission::where('name','read-recruiter-dashboard')->first()->id,
        ]);

        Menu::create([
            "id"=> 8, 
            'name'=> "Jobs",
            'icon'=> "book",
            'slug'=> "",
            'order'=> 8,
            'permission_id'=> Permission::where('name','read-recruiter-job')->first()->id,
        ]);

        Menu::create([
            "id"=> 9, 
            'url'=> "recruiter/create-jobs",
            'name'=> "Create Jobs",
            'icon'=> "plus",
            'slug'=> "create-jobs",
            'order'=> 9,
            'parent_id'=> 8,
            'permission_id'=> Permission::where('name','create-recruiter-job')->first()->id,
        ]);

        Menu::create([
            "id"=> 10, 
            'url'=> "recruiter/list-jobs",
            'name'=> "View Jobs",
            'icon'=> "list",
            'slug'=> "list-jobs",
            'order'=> 10,
            'parent_id'=> 8,
            'permission_id'=> Permission::where('name','read-recruiter-job')->first()->id,
        ]);

        Menu::create([
            "id"=> 11, 
            'url'=> "recruiter/applied_candidates",
            'name'=> "Applied Candidates",
            'icon'=> "speaker",
            'slug'=> "rappliedcandidates",
            'order'=> 11,
            'permission_id'=> Permission::where('name','read-recruiter-applied-candidates')->first()->id,
        ]);


        //Candidates

        Menu::create([
            "id"=> 12, 
            'url'=> "candidate/alljobs",
            'name'=> "All Jobs",
            'icon'=> "speaker",
            'slug'=> "calljobs",
            'order'=> 12,
            'permission_id'=> Permission::where('name','read-candidate-all-jobs')->first()->id,
        ]);

        Menu::create([
            "id"=> 13, 
            'url'=> "candidate/appliedjobs",
            'name'=> "Applied Jobs",
            'icon'=> "speaker",
            'slug'=> "cappliedjobs",
            'order'=> 13,
            'permission_id'=> Permission::where('name','read-candidate-applied-jobs')->first()->id,
        ]);

        Menu::create([
            "id"=> 14, 
            'name'=> "My Resume",
            'icon'=> "book",
            'slug'=> "",
            'order'=> 14,
            'permission_id'=> Permission::where('name','read-candidate-resume')->first()->id,
        ]);

        Menu::create([
            "id"=> 15, 
            'url'=> "candidate/create-resume",
            'name'=> "Add Resume",
            'icon'=> "plus",
            'slug'=> "create-resume",
            'order'=> 15,
            'parent_id'=> 14,
            'permission_id'=> Permission::where('name','create-candidate-resume')->first()->id,
        ]);

        Menu::create([
            "id"=> 16, 
            'url'=> "candidate/list-resume",
            'name'=> "View Resume",
            'icon'=> "list",
            'slug'=> "list-resume",
            'order'=> 16,
            'parent_id'=> 14,
            'permission_id'=> Permission::where('name','read-candidate-resume')->first()->id,
        ]);

        Menu::create([
            "id"=> 17, 
            'url'=> "candidate/videoresume",
            'name'=> "Video Resume",
            'icon'=> "speaker",
            'slug'=> "cvideoresume",
            'order'=> 17,
            'permission_id'=> Permission::where('name','read-candidate-video-resume')->first()->id,
        ]);

        // Common
        Menu::create([
            "id"=> 18, 
            'url'=> "job_fair",
            'name'=> "Job Fair",
            'icon'=> "speaker",
            'slug'=> "jobfair",
            'order'=> 18,
            'permission_id'=> Permission::where('name','read-job-fair')->first()->id,
        ]);

        Menu::create([
            "id"=> 19, 
            'url'=> "feedback",
            'name'=> "Feedback",
            'icon'=> "speaker",
            'slug'=> "feedback",
            'order'=> 19,
            'permission_id'=> Permission::where('name','read-feedback')->first()->id,
        ]);        
    }
}
