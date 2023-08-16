<?php

namespace App\Http\Resources\v1\Game;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorsResource extends JsonResource
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

            'name' => $this->name,
            'treasure_type' => $this->treasureType->treasure_type_name,
            'logo' => asset($this->logo_picture),
            'mobile' => $this->mobile,
            'address' => $this->address,
            'area' => $this->area->name,
            'city' => $this->city->name,
            'division' => $this->division->name,

        ];
    }
}
