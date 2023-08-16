<?php

namespace App\Http\Resources\v2\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class OriginalPriceResource extends JsonResource
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
            "priceInCoin"=> $this->origin_price_coins,
            "priceInGem"=> $this->origin_price_gems,
            "priceInTaka"=> $this->origin_price_taka,
        ];
    }
}
