<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecruiterPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recruiter_id',
        'from_date',
        'to_date',
        'package_id',
        'post_quota_used',
        'status'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
