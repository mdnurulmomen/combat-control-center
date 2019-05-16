<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyLoginReward extends Model
{
   	use SoftDeletes;

   	public function rewardType()
   	{
   		return $this->belongsTo(RewardType::class, 'reward_type_id', 'id');
   	}
}
