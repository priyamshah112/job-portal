<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecruiterJobFair extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recruiter_id',
        'job_fair_id',
        'job_ids',
    ];
    
    protected $casts = [
        'job_ids' => 'array'
    ];
}
