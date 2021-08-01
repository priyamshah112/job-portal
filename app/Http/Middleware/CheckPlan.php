<?php

namespace App\Http\Middleware;

use App\Models\Package;
use App\Models\RecruiterPackage;
use Closure;
use Illuminate\Http\Request;

class CheckPlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user_id = auth()->user()->id;
        $recruiter_package = RecruiterPackage::where(['recruiter_id'=>$user_id,'status' => 'active'])->first();
        if(!empty($recruiter_package))
        {
            $package = Package::where('id', $recruiter_package->package_id)->first();
            if($recruiter_package->post_quota_used >= $package->post_quota)
            {
                flash()->overlay('Your quota has been exceeded. Please Upgrade Your Plan',' ');
                return back();
            }
            return $next($request);
        }
        else
        {
            flash()->overlay('To Enjoy Are Services. Please Purchase a Plan',' ');
            return back();
        }
    }
}
