<?php

namespace App\Http\Resources\Player;

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

            // 'rewards' => DailyLoginRewardsCollection()
        ];
    }
}
