<?php

namespace App\Http\Middleware;

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
        if(empty($recruiter_package))
        {
            flash()->overlay('Purchase a plan or Upgarde your plan',' ');
            return back();
        }
        return $next($request);
    }
}
