<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
   	use SoftDeletes;
   	protected $guarded = [];

   	public function division()
   	{
   		return $this->belongsTo(Division::class, 'division_id', 'id');
   	}

   	public function areas()
   	{
   		return $this->hasMany(Area::class, 'city_id', 'id');
   	}
}
