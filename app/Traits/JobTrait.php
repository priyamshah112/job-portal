<?php

namespace App\Traits;


use App\Models\Candidate;
use App\Models\Recruiter;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
 */

trait JobTrait
{

    public function score($job, $candidate_id){
        $candidate = Candidate::where('user_id', $candidate_id)->first();
        $recruiter = Recruiter::where('user_id', $job->recruiter_id)->first();
        $score = 0;

        if($candidate->gender === $job->gender)
        {
            $score++;
        }
        
        if(in_array($candidate->qualification_id, json_decode($job->qualification_id)))
        {
            $score++;
        }

        if(in_array($this->age_by_dob($candidate->dateOfBirth), range($job->age_min,$job->age_max)))
        {
            $score++;
        }

        if($candidate->department_id === $recruiter->department_id)
        {
            $score++;
        }

        if($candidate->skills === $job->skills)
        {
            $score++;
        }

        if($candidate->job_location_state === $job->state && $candidate->job_location_city === $job->city )
        {
            $score++;
        }

        if($candidate->category === 'fresher' && $job->experience < 1)
        {
            $score++;
        }

        if($candidate->category === 'experience')
        {
            $score++;
        }

        return (int)(($score/8)*100);
    }

    public function age_by_dob($dob){
        return Carbon::parse($dob)->age;
    }
}