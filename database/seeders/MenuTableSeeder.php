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
        Menu::create([
            "id"=> 1,
            'url'=> "dashboard",
            'name'=> "Dashboard",
            'icon'=> "home",
            'slug'=> "dashboard",
            'order'=> 1,
            'permission_id'=> Permission::where('name','dashboard')->first()->id,
        ]);
        
        Menu::create([
            "id"=> 2,
            'url'=> "recruiters",
            'name'=> "Recruiters",
            'icon'=> "user-check",
            'slug'=> "recruiters",
            'order'=> 2,
            'permission_id'=> Permission::where('name','recruiter')->first()->id,
        ]);
        
        Menu::create([
            "id"=> 3,
            'url'=> "candidates",
            'name'=> "Candidates",
            'icon'=> "users",
            'slug'=> "candidates",
            'order'=> 3,
            'permission_id'=> Permission::where('name','candidate')->first()->id,
        ]);

        Menu::create([
            "id"=> 4,
            'url'=> "jobs",
            'name'=> "Jobs",
            'icon'=> "briefcase",
            'slug'=> "jobs",
            'order'=> 4,
            'permission_id'=> Permission::where('name','job')->first()->id,
        ]);

        Menu::create([
            "id"=> 5,
            'url'=> "applied-candidates",
            'name'=> "Applied Candidates",
            'icon'=> "align-center",
            'slug'=> "applied-candidates",
            'order'=> 5,
            'permission_id'=> Permission::where('name','applied-candidate')->first()->id,
        ]);

        Menu::create([
            "id"=> 6,
            'url'=> "applied-jobs",
            'name'=> "Applied Jobs",
            'icon'=> "file-plus",
            'slug'=> "applied-jobs",
            'order'=> 6,
            'permission_id'=> Permission::where('name','applied-job')->first()->id,
        ]);

        Menu::create([
            "id"=> 7,
            'url'=> "job-fair",
            'name'=> "Job Fair",
            'icon'=> "book",
            'slug'=> "job-fairs",
            'order'=> 7,
            'permission_id'=> Permission::where('name','jobfair')->first()->id,
        ]);


        Menu::create([
            "id"=> 8,
            'url'=> "list-resume",
            'name'=> "My Resume",
            'icon'=> "file",
            'slug'=> "resume",
            'order'=> 8,
            'permission_id'=> Permission::where('name','resume')->first()->id,
        ]);

        Menu::create([
            "id"=> 9,
            'url'=> "video-resume",
            'name'=> "My Video CV",
            'icon'=> "film",
            'slug'=> "video-resume",
            'order'=> 9,
            'permission_id'=> Permission::where('name','video-resume')->first()->id,
        ]);

        Menu::create([
            "id"=> 10,
            'url'=> "feedback",
            'name'=> "Feedback",
            'icon'=> "file-text",
            'slug'=> "feedbacks",
            'order'=> 10,
            'permission_id'=> Permission::where('name','feedback')->first()->id,
        ]);

    }
}
