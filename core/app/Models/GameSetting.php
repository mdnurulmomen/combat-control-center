<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GameSetting extends Model
{
   	protected $dates = ['maintainance_start_time', 'maintainance_end_time'];

   	public function setMaintainanceStartTimeAttribute($value)
    {
        $this->attributes['maintainance_start_time'] = Carbon::parse($value)->format('Y-m-d H:i:s') ;
    }

    public function setMaintainanceEndTimeAttribute($value)
    {
        $this->attributes['maintainance_end_time'] = Carbon::parse($value)->format('Y-m-d H:i:s') ;
    }
}
