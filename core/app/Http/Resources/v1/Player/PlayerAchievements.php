<?php

namespace App\Http\Resources\v1\Player;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerAchievements extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->achievement_id;
    }
}
