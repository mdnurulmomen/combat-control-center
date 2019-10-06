<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CampaignPlayerImpression;
use App\Http\Resources\v2\Campaign\CampaignResource;

class AdController extends Controller
{
   	public function showAllCampaignsAndImages()
    {
    	$campaignEnabled = Campaign::where('status', 1)->with('campaignImages')->first();

    	if ($campaignEnabled) {
    		
    		return new CampaignResource($campaignEnabled);
    	}

    	else
    	{
    		// default campaign
    		return new CampaignResource(Campaign::with('campaignImages')->first());
    	}
    }

    public function updateGameCampaignDetails(RequestWithToken $postman)
    {
    	$payload = $this->retrieveToken($postman);

        if (is_null($payload)) {
            return response()->json(['error'=>'Invalid token'], 422);
        }

        $request = new Request($payload);

    	$request->validate([
    		'playerId'=>'required',
    		'campaignId'=>'required',
    		'impression'=>'required'
    	]);

    	$expectedCampaign = Campaign::find($request->campaignId);

    	if ($expectedCampaign) {
    		
    		$expectedCampaign->increment('total_impression', $request->impression);
	    	
	    	$alreadyViewed = CampaignPlayerImpression::where('player_id', $request->playerId)
	    											->where('campaign_id', $request->campaignId)
	    											->first();
	    	if (!$alreadyViewed) {
	    		
	    		$expectedCampaign->increment('unique_impression');

	    		$newPlayer = $expectedCampaign->viewerPlayers()->create([
				    'player_id' => $request->playerId,
				]);
	    	}

	    	return new CampaignResource(Campaign::with('campaignImages')->first());
    	}

    	return response()->json(['error'=>'No Such Campaign'], 422);

    }
}
