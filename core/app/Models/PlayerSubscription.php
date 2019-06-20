<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerSubscription extends Model
{
    protected $dates = [
        'start_time', 'end_time'
    ];

    protected $guarded = ['id'];

    // protected $dateFormat = 'Y-m-d H:i:s';
    // public $timestamps = false;
}
