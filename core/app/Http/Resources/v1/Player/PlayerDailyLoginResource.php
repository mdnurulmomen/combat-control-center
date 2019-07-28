<?php

namespace App\Http\Resources\v1\Player;

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

            'consecutiveLogin' => $this->checkLoginDays->consecutive_days,

            'lastLoginDateAndTime' => optional($this->checkLoginDays->created_at)->format('Y-m-d H:i:s') ?? $this->checkLoginDays->updated_at->format('Y-m-d H:i:s'),

            'rewardList' => DailyLoginRewards::collection(DailyLoginReward::with('rewardType')->orderBy("id", "ASC")->take($this->dailyLoginReward() * 7)->get()->slice( ($this->dailyLoginReward() - 1) * 7 ))              
        ];
    }
}
