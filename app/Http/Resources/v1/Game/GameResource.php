<?php

namespace App\Http\Resources\v1\Game;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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
            'requiredVersion'=>empty($this->game_version_required) ? 'No version found' : $this->game_version_required,
            'currentVersion'=>empty($this->game_version_optional) ? 'No version found' : $this->game_version_optional,

            'gameMaintainanceMode'=>$this->maintainance_mode == 1 ? true : false,
            'maintainanceStartTime' => $this->maintainance_mode == 1 ? $this->maintainance_start_time->format('d-m-Y H:i:s') : 'NA' ,
            'maintainanceEndTime' => $this->maintainance_mode == 1 ? $this->maintainance_end_time->format('d-m-Y H:i:s') : 'NA' 
        ];
    }
}
