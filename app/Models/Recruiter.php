<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruiter extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'company_name', 'company_address', 'company_mobile_1', 'company_mobile_2',
        'industry_segment_id', 'company_landline_1', 'company_landline_2',
        'no_of_employees', 'annual_turnover','state','city'];

    public function user(){
        return $this->belongsTo(User::class)->whereNull('deleted_at');
    }
    public function packages()
    {
        return $this->hasMany(RecruiterPackage::class)->join('packages', 'recruiter_packages.package_id', '=', 'packages.id')
            ->select('recruiter_packages.*', 'packages.plan_name', 'packages.post_quota', 'packages.amount');
    }
    public function package()
    {
        return $this->hasOne(RecruiterPackage::class,'recruiter_id','user_id')->latest()->join('packages', 'recruiter_packages.package_id', '=', 'packages.id')
            ->select('recruiter_packages.*', 'packages.plan_name', 'packages.post_quota', 'packages.amount');
    }
    public function attachments()
    {
        return $this->hasMany(Attachments::class);
    }
}
