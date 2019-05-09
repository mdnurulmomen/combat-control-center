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

    public function checkLoginDays(){
        return $this->hasOne('App\Models\DailyLoginCheck');
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

    public function allNews()
    {
        return News::all();
    }

    public function allMessages()
    {
        return Message::all();
    }
}
