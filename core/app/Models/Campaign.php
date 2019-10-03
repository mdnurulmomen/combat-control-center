<?php

namespace App\Models;

use App\Models\CampaignImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $guarded = ['id'];
    
    // protected $fillable = [
    //     'name', 'total_impression', 'unique_impression', 'status', 'start_date', 'close_date'
    // ];

    protected $dates = [
        'start_date', 'close_date'
    ];

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

    public function setStatusAttribute($value)
    {
    	if ($value == 'on')
        {
    		$this->status()->update(array('status' => 0));
            $this->attributes['status'] = 1;
        }
    	
        else
            $this->attributes['status'] = 0;
    }

    public function campaignImages()
    {
    	return $this->hasMany(CampaignImage::class, 'campaign_id');
    }

    public function viewerPlayers()
    {
        return $this->hasMany(CampaignPlayerImpression::class, 'campaign_id');
    }
}
