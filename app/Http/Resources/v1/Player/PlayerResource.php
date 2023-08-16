<?php

namespace App\Http\Resources\v1\Player;

use App\Models\PlayerSubscription;
use App\Http\Resources\v1\Game\NewsResource;
use App\Http\Resources\v1\Game\MessageCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {

        return [
            'playerBasicInfo'=> new PlayerUserDetails($this->user),
            
            'playerAdvanceInfo'=>new PlayerSelectionDetails($this),

            'statistics'=>new PlayerStatistic($this->playerStatistics),

            'unlockedItems'=>new PlayerUnlockingDetails($this),
            
            'totalBoostItems'=>new PlayerBoostDetails($this),

            /*'playerSubscriptionDetails' => new PlayerSubscriptionResource($this->subscriptionPackage()->where('player_id', $this->id)->where('status', 1)->first() ?? new PlayerSubscription() ), */

            'playerSubscriptionDetails' => new PlayerSubscriptionResource($this->subscribed()->first() ?? new PlayerSubscription() ),

            'newsFeeds'=>NewsResource::collection($this->allNews()),

            'messages'=>new MessageCollection($this->allMessages()),

            'dailyLoginReward'=>new PlayerDailyLoginResource($this),
        ];
    }
}
