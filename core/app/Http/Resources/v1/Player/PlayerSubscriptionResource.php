<?php

namespace App\Http\Resources\v1\Player;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerSubscriptionResource extends JsonResource
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

            'serial'=>$this->id,
            'startTime'=>$this->start_time,
            'endTime'=>$this->end_time,
            'status'=>$this->status,

        ];
    }
}
