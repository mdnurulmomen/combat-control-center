<?php

namespace App\Http\Resources\v1\Player;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaderResource extends JsonResource
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

            'name'=>$this->username,
            'totalKill'=>$this->total_kill,
            'treasureWon'=>$this->treasure_won,
            'level'=>$this->level,
            'profilePic'=>$this->profile_pic,
            'facebookId'=>$this->user->facebook_id,
            'location'=>$this->location
        ];
    }
}
