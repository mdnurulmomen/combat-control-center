<?php

namespace App\Http\Resources\v2\Player;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Character;

class PlayerUnlockingDetails extends JsonResource
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
            // 'unlockedCharacters'=>[$this],

            'unlockedCharacters'=>$this->playerCharacters->isEmpty() ? 'null' : new PlayerCharacters($this->playerCharacters->pluck('character_index')->toArray()),

            'unlockedAnimations'=>$this->playerAnimations->isEmpty() ? 'null' : new PlayerAnimations($this->playerAnimations->pluck('animation_index')->toArray()),
            
            'unlockedWeapons'=>$this->playerWeapons->isEmpty() ? 'null' : new PlayerWeapons($this->playerWeapons->pluck('weapon_index')->toArray()),

            'unlockedParachutes'=>$this->playerParachutes->isEmpty() ? 'null' : new PlayerParachutes($this->playerParachutes->pluck('parachute_index')->toArray()),

            // 'unlockedAchievements'=>$this->playerAchievements->isEmpty() ? 'null' : PlayerAchievements::collection($this->playerAchievements)
        ];
    }
}
