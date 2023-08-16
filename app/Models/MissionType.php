<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionType extends Model
{
	use SoftDeletes;


   	public function missions()
    {
    	return $this->hasMany('App\Models\Mission', 'mission_type_id', 'id');
    }
}
