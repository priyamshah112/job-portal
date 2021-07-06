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
    protected $fillable = [
        'user_id',
        'about',
        'qualification_id',
        'skills',
        'dateOfBirth', 
        'gender',
        'mobile_number', 
        'alt_email',
        'permanent_address', 
        'category',
        'department_id', 
        'category_work',
        'current_location_state',
        'current_location_city',  
        'job_location_state',
        'job_location_city',
        'resume_path',
        'video_resume_name',
        'video_resume_path'];

    public function user(){
        return $this->belongsTo(User::class)->whereNull('deleted_at');
    }

    public function qualification(){
        return $this->belongsTo(Qualification::class,'qualification_id','id');
    }
}
