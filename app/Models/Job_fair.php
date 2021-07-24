<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_fair extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'img_name',
        'img_path',
        'organizer_name',
        'address',
        'mobile_number',
        'email',
        'type',
        'price',
        'amount',
        'number_of_days',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'additional_info',
        'department_id',
        'status',
        'draft',
    ];

    protected $appends = [
        'start',
        'end'
    ];

    public function getStartAttribute()
    {
        return Carbon::parse($this->start_date)->format('d M') .' ('.Carbon::parse($this->start_time)->format('h:i a').'-'.Carbon::parse($this->end_time)->format('h:i a').')';
    }

    public function getEndAttribute()
    {
        return Carbon::parse($this->end_date)->format('d M') .' ('.Carbon::parse($this->start_time)->format('h:i a').'-'.Carbon::parse($this->end_time)->format('h:i a').')';
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
