<?php

namespace App\Http\Resources\v1\Player;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyLoginRewards extends JsonResource
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
            'name'=>$this->name,
            'amount'=>$this->amount,
            'description'=>$this->description,
            'rewardType'=>$this->rewardType->reward_type_name
        ];
    }
}
