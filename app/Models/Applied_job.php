<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applied_job extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'recruiter_id',
        'candidate_id',
        'job_status'
    ];
}
