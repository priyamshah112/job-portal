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
        'alt_mobile_number', 
        'alt_email',
        'permanent_address', 
        'category',
        'department_id', 
        'previous_company',
        'previous_position',
        'previous_ctc',
        'experience',
        'expected_salary',
        'state',
        'city', 
        'preferred_state',
        'preferred_city', 
        'resume_path',
        'video_resume_name',
        'video_resume_path'
    ];

    protected $casts = [
        'skills' => 'array',
    ];
    
    public function user(){
        return $this->belongsTo(User::class)->whereNull('deleted_at');
    }

    public function qualification(){
        return $this->belongsTo(Qualification::class,'qualification_id','id');
    }

    public function state_detail(){
        return $this->belongsTo(State::class,'state','id');
    }

    public function city_detail(){
        return $this->belongsTo(City::class,'city','id');
    }

    public function previous_position_detail(){
        return $this->belongsTo(Position::class,'previous_position','id');
    }
}
