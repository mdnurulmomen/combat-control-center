<?php

namespace App\Models;

use App\Models\Player;
use Illuminate\Database\Eloquent\Model;

class PlayerStatistic extends Model
{
    
	protected $table = 'player_statistics';

	protected $guarded = ['id'];
	
    public function player(){
        return $this->belongsTo('App\Models\Player');
    }
}
