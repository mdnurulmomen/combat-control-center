<?php

namespace App\Http\Resources\v1\Campaign;

use App\Models\CampaignImageCategory;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\v1\Campaign\CampaignImageResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $returningDate = [];

        $returningDate['campaign_id'] = $this->id;
        $returningDate['campaign_name'] = $this->name;
        $returningDate['campaign_start_date'] = $this->start_date->format('d-m-Y');
        $returningDate['campaign_close_date'] = $this->close_date->format('d-m-Y');

        foreach (CampaignImageCategory::all() as $key => $campaignImageCategory) {
            
            $returningDate[str_replace(' ', '_', $campaignImageCategory->name)] = CampaignImageResource::collection($this->campaignImages()->where('campaign_image_category_id', $campaignImageCategory->id)->get());

            // $returningDate[str_replace(' ', '_', $campaignImageCategory->name)] = CampaignImageResource::collection($this->campaignImages()->where('campaign_image_category_id', $campaignImageCategory->id)->get());

        }

        return $returningDate;
    }
}
