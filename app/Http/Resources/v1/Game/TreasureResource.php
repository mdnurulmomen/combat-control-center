<?php

namespace App\Http\Resources\v1\Game;

use Illuminate\Http\Resources\Json\JsonResource;

class TreasureResource extends JsonResource
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
            'treasureId'=>$this->id,
            'name'=>$this->name,
            'type'=>$this->treasureType->treasure_type_name,
            'amount'=>$this->amount,
            'exchangingCoins'=>$this->exchanging_coins,
            'exchangingGems'=>$this->exchanging_gems,
            'exchangingMB'=>$this->exchanging_megabyte,
            'collectingPoint'=>$this->collecting_point == -1 ? 'nearest' : $this->collecting_point,
            'durability'=>$this->durability == -1 ? 'undefined' : $this->durability
        ];
    }
}
