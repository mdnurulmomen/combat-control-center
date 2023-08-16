<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreasureRedemption extends Model
{
    protected $guarded = [];
    
    public function player()
    {
    	return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function treasure()
    {
    	return $this->belongsTo('App\Models\Treasure', 'treasure_id', 'id');
    }

    public function playerTreasure()
    {
        return $this->belongsTo('App\Models\PlayerTreasure', 'player_treasure_serial', 'id');
    }
}
