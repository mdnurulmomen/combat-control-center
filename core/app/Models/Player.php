<?php

namespace App\Models;

use App\Models\News;
use App\Models\Message;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function dailyLoginReward()
    {
        $consecutiveLoginDays = $this->checkLoginDays->consecutive_days;
        $numberOfWeeks = (int) ($consecutiveLoginDays / 7) ;

        if ($consecutiveLoginDays % 7 == 0 ) 
            
            return $numberOfWeeks;

        else 
            return $numberOfWeeks + 1;
    }

    public function checkLoginDays()
    {
        return $this->hasOne('App\Models\DailyLoginCheck');
    }

    public function subscriptionPackage()
    {
        return $this->hasMany('App\Models\PlayerSubscription', 'player_id', 'id');
    }

    public function scopeSubscribed($query)
    {
        return $this->subscriptionPackage->where('player_id', $this->id)->where('status', 1);
    }

    public function playerBoostPacks()
    {
        return $this->hasOne('App\Models\PlayerBoostPack');
    }

    public function playerCharacters()
    {
        return $this->hasMany('App\Models\PlayerCharacter');
    }

    public function playerAnimations()
    {
        return $this->hasMany('App\Models\PlayerAnimation');
    }

    public function playerParachutes()
    {
        return $this->hasMany('App\Models\PlayerParachute');
    }

    public function playerWeapons()
    {
        return $this->hasMany('App\Models\PlayerWeapon');
    }

    public function playerTreasures()
    {
        return $this->hasMany('App\Models\PlayerTreasure');
    }

    public function playerAchievements()
    {
        return $this->hasMany('App\Models\PlayerAchievement');
    }

    public function playerStatistics()
    {  
        return $playerStatistics = $this->hasOne('App\Models\PlayerStatistic')->withDefault();
    }

    public function playerLeadershipPosition()
    {  
        return $this->hasOne('App\Models\Leader');
    }

    public function playerHistories()
    {
        return $this->hasMany('App\Models\PlayHistory');
    }

    public function playerMissions()
    {
        return $this->hasMany('App\Models\PlayerMission', 'player_id', 'id');
    }

    public function playerPurchases()
    {
        return $this->hasMany('App\Models\Purchase', 'buyer_id', 'id');
    }

    public function playerTreasureRedemptions()
    {
        return $this->hasMany('App\Models\TreasureRedemption', 'player_id', 'id');
    }

    public function allNews()
    {
        return News::all();
    }

    public function allMessages()
    {
        return Message::all();
    }
}
