<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPackage extends Model
{
   	protected $dates = [
        'start_time', 'end_time'
    ];

   	use SoftDeletes;
   	
   	public function subscriptionPackageType()
   	{
   		return $this->belongsTo('App\Models\SubscriptionPackageType', 'subcription_package_type_id', 'id');
   	}

   	public function playerSubscription()
   	{
   		return $this->hasMany('App\Models\PlayerSubscription', 'subscription_package_id', 'id');
   	}
}
