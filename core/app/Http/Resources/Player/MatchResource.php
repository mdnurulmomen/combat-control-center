<?php

namespace App\Http\Resources\Player;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource implements JWTSubject
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
            
            'statistics'=> new PlayerStatistic($this->playerStatistics),
        ];
    }

    public function getJWTIdentifier()
    {
      return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
      return [];
    }
}
