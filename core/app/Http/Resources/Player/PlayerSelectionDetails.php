<?php

namespace App\Http\Resources\Player;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerSelectionDetails extends JsonResource
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
            'totalCoin'=>$this->playerStatistics->coins,
            'totalGem'=>$this->playerStatistics->gems,
            'selectedCharacter'=>$this->selected_character,
            'selectedAnimation'=>$this->selected_animation,
            'selectedParachute'=>$this->selected_parachute,
            'selectedWeapon'=>$this->selected_weapon
        ];
    }
}
