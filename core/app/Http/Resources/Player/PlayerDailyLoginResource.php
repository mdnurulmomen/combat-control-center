<?php

namespace App\Http\Resources\Player;

use App\Models\DailyLoginReward;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerDailyLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [

            'consecutiveLogin'=> $this->checkLoginDays->consecutive_days,

            'rewards' => new DailyLoginRewardsCollection(DailyLoginReward::orderBy("id", "ASC")->take($this->checkLoginDays->consecutive_days * 7)->get()->slice( ($this->checkLoginDays->consecutive_days - 1) *7 ))              
        ];
    }
}
