<?php

namespace App\Http\Resources\v2\Game;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionPackageResource extends JsonResource
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
            'name'=>$this->name,
            'type'=>$this->subscriptionPackageType->name,
            'time'=>$this->offered_time.' Hours'
        ];
    }
}
