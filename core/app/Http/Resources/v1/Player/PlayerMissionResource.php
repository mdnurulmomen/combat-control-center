<?php

namespace App\Http\Resources\v1\Player;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerMissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arrayToReturn = [

            'type'=>$this->mission->missionType->mission_type_name,
            'description'=>$this->mission->description,
            'rewardAmount'=>$this->mission->reward_amount,
            'isRewarded'=>$this->rewarded ?? 0,
        ];
 
        if (Str::contains($this->mission->missionType->mission_type_name, ['Play', 'More'])) {
            
            $arrayToReturn['target'] = $this->mission->play_number ?? $this->mission->play_time;
            $arrayToReturn['progress'] = $this->progress_play_number ?? $this->mission->progress_play_time ?? 0;

        }

        if (Str::contains($this->mission->missionType->mission_type_name, ['Opponents'])) {
            
            $arrayToReturn['target'] = $this->mission->kill_opponent;
            $arrayToReturn['progress'] = $this->progress_kill_opponent ?? 0;
            
        }

        if (Str::contains($this->mission->missionType->mission_type_name, ['Monsters'])) {
            
            $arrayToReturn['target'] = $this->mission->kill_monster;
            $arrayToReturn['progress'] = $this->progress_kill_monster ?? 0;
            
        }

        if (Str::contains($this->mission->missionType->mission_type_name, ['Win', 'Battle'])) {
            
            $arrayToReturn['target'] = $this->mission->win_top_time;
            $arrayToReturn['progress'] = $this->progress_win_top_time ?? 0;
            
        }

        if (Str::contains($this->mission->missionType->mission_type_name, ['Among', 'Positions'])) {
            
            $arrayToReturn['target'] = $this->mission->among_two_time ?? $this->mission->among_three_time ?? $this->mission->among_five_time;

            if ($this->mission->among_two_time) {
                
                $arrayToReturn['progress'] = $this->progress_among_two_time;
            }

            else if ($this->mission->among_three_time) {
                
                $arrayToReturn['progress'] = $this->progress_among_three_time;
            }

            else if ($this->mission->among_five_time) {
                
                $arrayToReturn['progress'] = $this->progress_among_five_time;
            }
            
        }   


        return $arrayToReturn;
    }
}
