<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedJobFair extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_fair_id',
        'candidate_id',
    ];
}
