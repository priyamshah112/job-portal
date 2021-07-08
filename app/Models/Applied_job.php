<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $appends = [
        'posting_date',
    ];

    public function getPostingDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }
}
