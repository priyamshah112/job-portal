<?php

namespace App\Traits;

use App\Models\Package;
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

    public function is_quota_exceeded($user_id)
    {
        $recruiter_package = RecruiterPackage::where(['recruiter_id'=>$user_id,'status' => 'active'])->first();
        $package = Package::where('id',$recruiter_package->package_id)->first();

        if($recruiter_package->post_quota_used >= $package->post_quota)
        {
            return true;
        }
        
        return false;
    }

}