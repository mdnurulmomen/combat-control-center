<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardType extends Model
{
   	use SoftDeletes;

   	public function relatedRewards()
    {
    	return $this->hasMany('App\Models\DailyLoginReward', 'reward_type_id', 'id');
    }
}
