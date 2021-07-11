<?php

namespace App\Traits;


use App\Models\Candidate;
use App\Models\Recruiter;
use App\Models\User;
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

        if(count(array_intersect(json_decode($candidate->skills),json_decode($job->skills))) > 0)
        {
            $score++;
        }

        if(count(array_intersect(json_decode($candidate->preferred_state),json_decode($job->state))) > 0)
        {
            $score++;
        }

        if($candidate->category === 'fresher' && $job->experience < 1)
        {
            $score++;
        }
        else if($candidate->category === 'experience')
        {
            $score++;
        }

        // candidate not expected salaray. have to add
        if($candidate->category === 'experience')
        {
            $score++;
        }



        return (int)(($score/8)*100);
    }

    public function age_by_dob($dob){
        return Carbon::parse($dob)->age;
    }

    public function checkCandidateProfileCompleted($id){
        $user = User::with('candidate')->where('id',$id)->first();
        if($user->candidate['gender'] === null || $user->candidate['qualification_id'] === null || $user->candidate['dateOfBirth'] === null || $user->candidate['department_id'] === null || $user->candidate['skills'] === null || $user->candidate['preferred_state'] === null || 
        $user->candidate['preferred_city'] === null || $user->candidate['category'] === null || $user->candidate['about'] === null)
        {
            return false;
        }
        else{
            return true;
        }
    }
}