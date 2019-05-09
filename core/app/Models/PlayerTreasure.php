<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerTreasure extends Model
{
    protected $table = 'player_treasures';
    protected $guarded = [];

    public function player()
    {
    	return $this->belongsTo('App\Models\Player', 'player_id', 'id');
    }

    public function treasure()
    {
    	return $this->belongsTo('App\Models\Treasure', 'treasure_id', 'id');
    }
}
