<?php

namespace App\Http\Resources\v1\Player;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerTreasureRedeemed extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'serial'=>$this->id,
            'treasureId'=>$this->treasure_id,
            'name'=>$this->treasure->name,
            'type'=>$this->treasure->treasureType->treasure_type_name,
            'amount'=>$this->treasure->amount,
            'exchangingCoins'=>$this->treasure->exchanging_coins,
            'exchangingGems'=>$this->treasure->exchanging_gems,
            'exchangingMB'=>$this->treasure->exchanging_megabyte,
            'exchangedWith'=>optional($this->treasureRedemption)->exchanging_type ?? 'MB',
            'winningTime'=>$this->open_time,
            'collectedOn'=>$this->updated_at->format('Y-m-d H:i:s'),
            'collectedPoint'=>optional($this->treasureRedemption)->collecting_point ?? 'Game Currency',
            'closingTime'=>$this->close_time,
            'status'=>$this->status,
            'description'=>$this->treasure->description
         ];
    }
}
