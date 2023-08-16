<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    // protected $guarded = [];

    public function cities()
   	{
   		return $this->hasMany(City::class, 'division_id', 'id');
   	}
}
