<?php

namespace App\Http\Resources\v2\Player;

use Illuminate\Http\Resources\Json\JsonResource;

class MyLeaderResource extends JsonResource
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
            'position'=>$this->id ?? 'invalid',
            'name'=>$this->username ?? 'invalid',
            'totalKill'=>$this->total_kill ?? 0,
            'treasureWon'=>$this->treasure_won ?? 0,
            'level'=>$this->level  ?? 0,
            'profilePic'=>$this->profile_pic ?? 'invalid',
            'facebookId'=>$this->user->facebook_id ?? 'invalid',
            'location'=>$this->location ?? 'invalid'
        ];
    }
}
