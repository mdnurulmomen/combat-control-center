<?php

namespace App\Http\Resources\v2\Game;

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
            'logo' => asset($this->logo_picture),
            'address' => $this->address,
            'area' => $this->area,
            'city' => $this->city,
            'division' => $this->division,
            'mobile' => $this->mobile,
            'treasure_type' => $this->treasureType->treasure_type_name,

        ];
    }
}
