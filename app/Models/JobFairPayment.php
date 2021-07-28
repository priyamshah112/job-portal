<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobFairPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'razorpay_payment_id',
        'razorpay_order_id',
        'razorpay_signature',
        'job_fair_id',
        'job_fairs',
        'amount',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'job_fairs' => 'array'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
