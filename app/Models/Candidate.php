<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Candidate extends Model
{
    use HasFactory,Notifiable, HasRoles, SoftDeletes;
    protected $fillable = ['user_id','about','education','skills','dateOfBirth', 'mobile_number', 'alt_email','permanent_address', 'category','industry_type', 'category_work',
        'current_location_state','current_location_city',  'job_location_state','job_location_city','resume_path','video_resume_name','video_resume_path'];

    public function user(){
        return $this->belongsTo(User::class)->whereNull('deleted_at');
    }
}
