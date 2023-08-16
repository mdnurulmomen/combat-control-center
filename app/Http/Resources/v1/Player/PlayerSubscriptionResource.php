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
        return [

            'status'=> $this->status ?? 0,
            'startTime'=>optional($this->start_time)->format('Y-m-d H:i:s') ?? '',
            'endTime'=>optional($this->end_time)->format('Y-m-d H:i:s') ?? '',

        ];
    }
}
