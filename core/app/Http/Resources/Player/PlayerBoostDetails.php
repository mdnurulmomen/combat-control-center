<?php

namespace App\Http\Resources\Player;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerBoostDetails extends JsonResource
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
            'totalMeleeBoost'=>$this->playerBoostPacks->melee_boost,
            'totalLightBoost'=>$this->playerBoostPacks->light_boost,
            'totalHeavyBoost'=>$this->playerBoostPacks->heavy_boost,
            'totalAmmoBoost'=>$this->playerBoostPacks->ammo_boost,
            'totalRangeBoost'=>$this->playerBoostPacks->range_boost,
            'totalSpeedBoost'=>$this->playerBoostPacks->speed_boost,
            'totalArmorBoost'=>$this->playerBoostPacks->armor_boost,
            'totalXPMultiplier'=>$this->playerBoostPacks->xp_multiplier
        ];
    }
}
