<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerMission extends Model
{
   	protected $guarded = ['id'];

   	public function mission()
   	{
   		return $this->belongsTo(Mission::class, 'mission_id', 'id');
   	}
}
