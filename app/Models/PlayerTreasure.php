<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerTreasure extends Model
{
    protected $guarded = [];
    protected $table = 'player_treasures';

    public function player()
    {
    	return $this->belongsTo('App\Models\Player', 'player_id', 'id');
    }

    public function treasure()
    {
    	return $this->belongsTo('App\Models\Treasure', 'treasure_id', 'id');
    }

    public function treasureRedemption()
    {
        return $this->hasOne('App\Models\TreasureRedemption', 'player_treasure_serial', 'id');
    }
}
