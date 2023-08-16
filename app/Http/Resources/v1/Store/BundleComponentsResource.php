<?php

namespace App\Http\Resources\v1\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class BundleComponentsResource extends JsonResource
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
            'component'=> $this->component_type,
            'amount'=>$this->amount
        ];
    }
}
