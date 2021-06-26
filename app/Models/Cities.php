<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'state_id'
    ];


}
