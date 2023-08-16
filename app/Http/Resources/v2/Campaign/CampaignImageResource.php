<?php

namespace App\Http\Resources\v2\Campaign;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return asset($this->image_path);

        /*return $arrayRequest = parent::toArray($request);
        dd(is_object($arrayRequest->first()));

        $returningData = [];

        foreach ($arrayRequest as $key => $singleObject) {
            
            $returningData[$key] = $singleObject->image_path;
        }

        return $returningData;*/
    }
}
