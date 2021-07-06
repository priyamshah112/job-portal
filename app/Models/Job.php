<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
            'recruiter_id',
            'position',
            'description',
            'num_position',
            'state',
            'city',
            'age_min',
            'age_max',
            'gender',
            'qualification_id',
            'experience',
            'maxexperience',
            'salary_min',
            'salary_max',
            'skills',
            'deadline',
            'status',
            'draft'
    ];

    protected $casts = [
        'qualification_id' => 'array',
    ];  

    public function user(){
        return $this->belongsTo(User::class)->whereNull('deleted_at');
    }
}
