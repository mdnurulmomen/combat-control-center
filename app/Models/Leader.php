<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'player_id', 'id');
    }
}
