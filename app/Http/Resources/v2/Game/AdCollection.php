<?php

namespace App\Http\Resources\v2\Game;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'allUrls'=>AdResource::collection($this->collection),
        ];
    }
}
