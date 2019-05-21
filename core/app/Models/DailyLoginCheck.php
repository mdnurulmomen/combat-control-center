<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyLoginCheck extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = false; 
}
