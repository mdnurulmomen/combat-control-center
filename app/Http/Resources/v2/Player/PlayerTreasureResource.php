<?php

namespace App\Http\Resources\v2\Player;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerTreasureResource extends JsonResource
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

            'redeemed'=> PlayerTreasureRedeemed::collection($this->playerTreasures()->where('status', -1)->orderBy('id', 'desc')->get()),

            'requested'=> PlayerTreasureRequested::collection($this->playerTreasures()->where('status', 0)->orderBy('id', 'desc')->get()),

            'remained'=> PlayerTreasureRemained::collection($this->playerTreasures()->where('status', 1)->orderBy('id', 'desc')->get()),

        ];
    }
}
