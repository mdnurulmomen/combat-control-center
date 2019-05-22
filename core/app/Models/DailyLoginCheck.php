<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyLoginCheck extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false; 
    protected $dates = ['created_at', 'updated_at'];			// As Timestamps is false
}
