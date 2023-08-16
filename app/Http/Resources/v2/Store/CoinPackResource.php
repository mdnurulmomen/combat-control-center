<?php

namespace App\Http\Resources\v2\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class CoinPackResource extends JsonResource
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
            'itemDescription'=>$this->description,
            'amount'=>$this->amount,
            'itemOffer'=>$this->discount,
            'originalPriceInGem'=>$this->origin_price_gems,
            'originalPriceInTaka'=>$this->origin_price_taka,
            'offeredPriceInGem'=>$this->offered_price_gems,
            'offeredPriceInTaka'=>$this->offered_price_taka,
        ];
    }
}
