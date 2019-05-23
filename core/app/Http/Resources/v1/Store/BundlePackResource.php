<?php

namespace App\Http\Resources\v1\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class BundlePackResource extends JsonResource
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
            'itemId'=>$this->id,
            'itemType'=>$this->type,
            'itemName'=>$this->name,
            'bundleData'=>BundleComponentsResource::collection($this->bundleComponents),
            
            'hasMb'=>$this->bundleComponents->contains('component_type','Megabyte') ? true : false,

            'itemOffer'=>$this->discount,
            'originalPrice'=>new OriginalPriceResource($this),
            'offeredPrice'=>new OfferedPriceResource($this)
        ];
    }
}
