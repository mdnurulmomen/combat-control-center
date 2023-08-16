<?php

namespace App\Http\Resources\v1\Player;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerStatistic extends JsonResource
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
            'playerLevel'=>$this->player_level,
            'coinsWon'=>$this->coins ?? 0,
            'gemsWon'=>$this->gems ?? 0,
            'totalXP'=>$this->xp_point ?? 0,
            'totalBattlesPlayed'=>$this->battle_played ?? 0,
            'totalBattlesWin'=>$this->battle_wins ?? 0,
            'totalTreasureCollected'=>$this->treasure_collected ?? 0,
            'totalTreasureWon'=>$this->treasure_won ?? 0,
            'totalOpponentsKilled'=>$this->opponent_killed ?? 0,
            'totalMonsterKilled'=>$this->monster_killed ?? 0,
            'totalDoubleKills'=>$this->double_killed ?? 0,
            'totalTripleKills'=>$this->triple_killed ?? 0,
            'totalGunsCollected'=>$this->guns_collected,
            'totalItemsCollected'=>$this->items_collected ?? 0,
            'totalCratesCollected'=>$this->crates_collected ?? 0,
            'totalAirDropsCollected'=>$this->air_drops ?? 0
        ];
    }
}
