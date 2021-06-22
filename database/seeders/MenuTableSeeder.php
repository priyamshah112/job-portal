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
            'permission_id'=> Permission::where('name','admin-dashboard')->first()->id,
            ]);
        Menu::create([
            "id"=> 2,
            'url'=> "admin/recruiters",
            'name'=> "Recruiters",
            'icon'=> "align-center",
            'slug'=> "arecruiters",
            'order'=> 2,
            'permission_id'=> Permission::where('name','admin-recruiter')->first()->id,
        ]);
        Menu::create([
            "id"=> 3,
            'url'=> "admin/candidates",
            'name'=> "Candidates",
            'icon'=> "image",
            'slug'=> "acandidates",
            'order'=> 3,
            'permission_id'=> Permission::where('name','admin-candidates')->first()->id,
        ]);
        Menu::create([
            "id"=> 4,
            'name'=> "Job Fair",
            'icon'=> "book",
            'slug'=> "",
            'order'=> 4,
            'permission_id'=> Permission::where('name','admin-jobfair')->first()->id,
        ]);
        Menu::create([
            "id"=> 5,
            'url'=> "admin/feedback",
            'name'=> "Feedback",
            'icon'=> "speaker",
            'slug'=> "feedback-admin",
            'order'=> 5,
            'permission_id'=> Permission::where('name','admin-feedback')->first()->id,
        ]);

        // Recruiter
        Menu::create([
            "id"=> 6,
            'url'=> "recruiter/dashboard",
            'name'=> "Dashboard",
            'icon'=> "speaker",
            'slug'=> "recruiter-dashboard",
            'order'=> 6,
            'permission_id'=> Permission::where('name','recruiter-dashboard')->first()->id,
        ]);
        Menu::create([
            "id"=> 7,
            'url'=> "recruiter/jobs",
            'name'=> "Jobs",
            'icon'=> "book",
            'slug'=> "recruiter-jobs",
            'order'=> 7,
            'permission_id'=> Permission::where('name','recruiter-jobs')->first()->id,
        ]);
        Menu::create([
            "id"=> 8,
            'url'=> "recruiter/applied_candidates",
            'name'=> "Applied Candidates",
            'icon'=> "speaker",
            'slug'=> "rappliedcandidates",
            'order'=> 8,
            'permission_id'=> Permission::where('name','recruiter-candidates')->first()->id,
        ]);

        Menu::create([
            "id"=> 9,
            'url'=> "recruiter/list-jobs",
            'name'=> "Job Fair",
            'icon'=> "plus",
            'slug'=> "recruiter-jobfair",
            'order'=> 9,
            'permission_id'=> Permission::where('name','recruiter-jobfair')->first()->id,
        ]);
        Menu::create([
            "id"=> 10,
            'url'=> "recruiter/feedback",
            'name'=> "Feedback",
            'icon'=> "speaker",
            'slug'=> "feedback-recruiter",
            'order'=> 10,
            'permission_id'=> Permission::where('name','recruiter-feedback')->first()->id,
        ]);


        //Candidates
        Menu::create([
            "id"=> 11,
            'url'=> "candidate/alljobs",
            'name'=> "All Jobs",
            'icon'=> "speaker",
            'slug'=> "candidate-dashboard",
            'order'=> 1,
            'permission_id'=> Permission::where('name','candidate-dashboard')->first()->id,
        ]);
        Menu::create([
            "id"=> 12,
            'url'=> "candidate/appliedjobs",
            'name'=> "Applied Jobs",
            'icon'=> "speaker",
            'slug'=> "candidate-jobs",
            'order'=> 12,
            'permission_id'=> Permission::where('name','candidate-jobs')->first()->id,
        ]);
        Menu::create([
            "id"=> 13,
            'url'=> "candidate/list-resume",
            'name'=> "My Resume",
            'icon'=> "book",
            'slug'=> "candidate-resume",
            'order'=> 13,
            'permission_id'=> Permission::where('name','candidate-resume')->first()->id,
        ]);
        Menu::create([
            "id"=> 14,
            'url'=> "candidate/video-resume",
            'name'=> "My Video CV",
            'icon'=> "camera",
            'slug'=> "candidate-video-resume",
            'order'=> 14,
            'permission_id'=> Permission::where('name','candidate-video-resume')->first()->id,
        ]);
        Menu::create([
            "id"=> 15,
            'url'=> "",
            'name'=> "Job Fair",
            'icon'=> "speaker",
            'slug'=> "candidate-jobfair",
            'order'=> 15,
            'permission_id'=> Permission::where('name','candidate-jobfair')->first()->id,
        ]);
        Menu::create([
            "id"=> 16,
            'url'=> "candidate/feedback",
            'name'=> "Feedback",
            'icon'=> "speaker",
            'slug'=> "candidate-feedback",
            'order'=> 16,
            'permission_id'=> Permission::where('name','candidate-feedback')->first()->id,
        ]);

    }
}
