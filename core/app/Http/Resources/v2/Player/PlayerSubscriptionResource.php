<?php

namespace App\Http\Resources\v2\Player;

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

            // 'serial'=>$this->id,
            'startTime'=>$this->start_time->format('Y-m-d H:i:s'),
            'endTime'=>$this->end_time->format('Y-m-d H:i:s'),
            // 'status'=>$this->status,

        ];
    }
}
