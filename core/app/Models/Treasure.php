<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treasure extends Model
{
    use SoftDeletes;
    
    public function treasureType()
    {
    	return $this->belongsTo('App\Models\TreasureType', 'treasure_type_id', 'id');
    }

    public function playerWhoGotThis()
    {
        return $this->hasMany('App\Models\PlayerTreasure');
    }
}
