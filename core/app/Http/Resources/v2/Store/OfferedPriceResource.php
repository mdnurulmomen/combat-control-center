<?php

namespace App\Http\Resources\v2\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferedPriceResource extends JsonResource
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
            "priceInCoin"=> $this->offered_price_coins,
            "priceInGem"=> $this->offered_price_gems,
            "priceInTaka"=> $this->offered_price_taka,
        ];
    }
}
