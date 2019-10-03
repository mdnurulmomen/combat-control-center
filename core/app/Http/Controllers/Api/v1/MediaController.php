<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CampaignPlayerImpression;
use App\Http\Resources\v1\Campaign\CampaignResource;

class MediaController extends Controller
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

    public function updateGameCampaignDetails(Request $request)
    {
    	$request->validate([
    		'player_id'=>'required',
    		'campaign_id'=>'required',
    		'impression'=>'required'
    	]);

    	$expectedCampaign = Campaign::find($request->campaign_id);

    	if ($expectedCampaign) {
    		
    		$expectedCampaign->increment('total_impression', $request->impression);
	    	
	    	$alreadyViewed = CampaignPlayerImpression::where('player_id', $request->player_id)
	    											->where('campaign_id', $request->campaign_id)
	    											->first();
	    	if (!$alreadyViewed) {
	    		
	    		$expectedCampaign->increment('unique_impression');

	    		$newPlayer = $expectedCampaign->viewerPlayers()->create([
				    'player_id' => $request->player_id,
				]);
	    	}

	    	return new CampaignResource(Campaign::with('campaignImages')->first());
    	}

    	return response()->json(['error'=>'No Such Campaign'], 422);

    }
}
