<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
   	use SoftDeletes;

   	public function city()
   	{
   		return $this->belongsTo(City::class, 'city_id', 'id');
   	}
}
