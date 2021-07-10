<?php

namespace App\Traits;

use App\Models\RecruiterPackage;

trait PackageTrait
{

    public function is_any_plan_active($user_id)
    {
        $recruiter_package = RecruiterPackage::where(['recruiter_id'=>$user_id,'status' => 'active'])->first();
        if(empty($recruiter_package))
        {
            return false;
        }
        return true;
    }

}