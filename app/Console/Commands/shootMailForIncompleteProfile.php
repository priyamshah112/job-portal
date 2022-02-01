<?php

namespace App\Console\Commands;

use App\Mail\IncompleteProfile;
use App\Models\User;
use App\Traits\JobTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class shootMailForIncompleteProfile extends Command
{
    use JobTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shoot-mail-for-incomplete-profile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shoot Mail For Incomplete Profile';

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
        $this->withProgressBar(User::where('user_type', 'candidate')->get(), function ($user) {
            if(!$this->checkCandidateProfileCompleted($user->id) && !$this->checkVideoResumeCompleted($user->id))
            { 
                try
                {
                    $input = [
                        'subject' => 'Your Profile is incomplete | NaukriWala.co.in',
                        'email' => $user->email,
                    ];

                    Mail::to($input['email'])->send(new IncompleteProfile($input));
                }
                catch (\Exception $e)
                {
                    $this->error("\n Mail has been not sent to ".$user->first_name." ".$user->last_name);
                }
            }
        });
    }
}
