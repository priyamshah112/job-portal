<?php

namespace App\Console\Commands;

use App\Models\RecruiterPackage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckSubscribersPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-subscribers-plan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Start Checking For Expired Plans");
        $users = User::where('user_type', 'recruiter')->get();
        foreach ($users as $user) {
            $user_package = RecruiterPackage::where([
                'recruiter_id' => $user->id,
                'status' => 'active'
            ])->first();

            if(!empty($user_package) && Carbon::parse($user_package->to_date)->lte(Carbon::now()))
            {
                $user_package->update([
                    'status' => 'expired',
                    'updated_at' => Carbon::now()
                ]);
                $this->warn($user->first_name." ".$user->last_name." plan has been expired");
            }
        }
        $this->info("End Checking For Expired Plans");
    }
}
