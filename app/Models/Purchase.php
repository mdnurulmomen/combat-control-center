<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
   	public function buyer()
   	{
   		return $this->belongsTo(Player::class, 'buyer_id', 'id');
   	}
}
