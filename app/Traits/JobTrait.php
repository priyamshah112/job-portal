<?php

namespace App\Traits;


use App\Models\Candidate;
use App\Models\City;
use App\Models\Qualification;
use App\Models\Recruiter;
use App\Models\Skill;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Exception;

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
        try{
            $candidate = Candidate::where('user_id', $candidate_id)->first();
            $score = 0;

            if($candidate->gender === $job->gender || $job->gender === 'any')
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

            if($candidate->department_id === $job->department_id)
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

            if($candidate->category === 'fresher')
            {
                $score++;
            }
            else if($candidate->category === 'experience' && in_array($candidate->experience,range($job->experience,$job->maxexperience)))
            {
                $score++;
            }

            // candidate expected salaray. have to add
            if($candidate->category === 'fresher' && $job->experience < 1)
            {
                $score++;
            }
            else if($candidate->category === 'experience' && $candidate->expected_salary <= $job->salary_max)
            {
                $score++;
            }

            return (int)(($score/8)*100);
        }
        catch(Exception $e){
            return "error";
        }
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

    public function checkVideoResumeCompleted($id){
        $user = User::with('candidate')->where('id',$id)->first();
        if($user->candidate['video_resume_path'] === null)
        {
            return false;
        }
        else{
            return true;
        }
    }

    public function convertSkillIdsToSkillNames($values)
    {
        $skillNames = [];

        if($values !== null || !empty($values))
        {
            foreach(json_decode($values) as $skill_id)
            {
                $skill = Skill::where('id', $skill_id)->first();
                if(!empty($skill))
                {
                    $skillNames[] = $skill->name;
                }
            }
        }

        return $skillNames;
    }

    public function convertQualificationIdsToQualificationNames($values)
    {        
        $qualificationNames = [];

        if($values !== null || !empty($values))
        {
            foreach(json_decode($values) as $id)
            {
                $qualification = Qualification::where('id', $id)->first();
                if(!empty($qualification))
                {
                    $qualificationNames[] = $qualification->name;
                }
            }
        }

        return $qualificationNames;
    }

    public function convertStateIdsToStateNames($values)
    {        
        $stateNames = [];    
        

        if($values !== null || !empty($values))
        {
            foreach(json_decode($values) as $id)
            {
                $state = State::where('id', $id)->first();
                if(!empty($state))
                {
                    $stateNames[] = $state->name;
                }
            }
        }

        return $stateNames;
    }

    public function convertCityIdsToCityNames($values)
    { 
        $cityNames = [];
        
        if($values !== null || !empty($values))
        {
            foreach(json_decode($values) as $id)
            {
                $city = City::where('id', $id)->first();
                if(!empty($city))
                {
                    $cityNames[] = $city->name;
                }
            }
        }
        return $cityNames;
    }

}