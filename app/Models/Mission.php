<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Mission extends Model
{
   	use SoftDeletes;

   	protected $guarded = [];

    public function missionType()
    {
    	return $this->belongsTo('App\Models\MissionType', 'mission_type_id', 'id')->withTrashed();
    }
}
