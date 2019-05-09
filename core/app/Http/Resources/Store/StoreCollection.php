<?php

namespace App\Http\Resources\Store;

use App\Http\Resources\Store\CharacterCollection;
use App\Http\Resources\Store\AnimationCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;


class StoreCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            
            'characters'=>CharacterResource::collection($this->collection->where('type', 'character')),
            'weapons'=>WeaponResource::collection($this->collection->where('type', 'weapon')),
            'animations' => AnimationResource::collection($this->collection->where('type', 'animation')),
            'parachutes' => ParachuteResource::collection($this->collection->where('type', 'parachute')),
            'coinPacks' => CoinPackResource::collection($this->collection->where('type', 'Coins Pack')),
            'gemPacks' => GemPackResource::collection($this->collection->where('type', 'Gems Pack')),
            'boostPacks' => BoostPackResource::collection($this->collection->where('type', 'Boost Pack')),
            'bundle' => BundlePackResource::collection($this->collection->where('type', 'Bundle'))   
        ];
    }
}
