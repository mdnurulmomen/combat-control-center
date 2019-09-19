<?php

namespace App\Models;

use App\Models\CampaignImage;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public $timestamps = false;

    public function setStatusAttribute($value)
    {
    	if ($value == 'on') {
    		
    		$this->attributes['status'] = 1;
    	}
    }

    public function campaignImages()
    {
    	return $this->hasMany(CampaignImage::class, 'campaign_id');
    }
}
