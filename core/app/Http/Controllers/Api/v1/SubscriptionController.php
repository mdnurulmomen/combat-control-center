<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\PlayerSubscription;
use App\Models\SubscriptionPackage;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Player\PlayerSubscriptionResource;
use App\Http\Resources\v1\Game\SubscriptionPackageResource;

class SubscriptionController extends Controller
{
    public function showPlayerSubscriptionDetails(Request $request)
    {
    	$request->validate([
    		'userId'=>'required|exists:players,id',
    		'subscriptionPackageId'=>'required|exists:subscription_packages,id',
    	]);

    	$subscriptionPackage = SubscriptionPackage::find($request->subscriptionPackageId);

    	$checkSubscription = $subscriptionPackage->playerSubscription()->where('player_id', $request->userId)->where('status', 1)->first();

    	if ($checkSubscription) {

			return [
                'playerSubscriptionDetails'=> new PlayerSubscriptionResource($checkSubscription), 
				'subscriptionPackageDetails'=> new SubscriptionPackageResource($subscriptionPackage)
            ];
    	}


    	return ['message'=>'0', 
                'playerSubscriptionDetails'=> new PlayerSubscriptionResource($checkSubscription ?? new PlayerSubscription()), 
                'subscriptionPackageDetails'=> new SubscriptionPackageResource($subscriptionPackage)
            ];

    }

    public function addPlayerSubscriptionPackage(Request $request)
    {
        $request->validate([
            'userId'=>'required|exists:players,id',
            'subscriptionPackageId'=>'required|exists:subscription_packages,id'
        ]);

        $subscriptionPackage = SubscriptionPackage::find($request->subscriptionPackageId);

        $checkSubscription = $subscriptionPackage->playerSubscription()->where('player_id', $request->userId)->where('status', 1)->first();

        if ($checkSubscription) {

            return [
                'message'=>'2',                             // 2 for already Subscribed
                'playerSubscriptionDetails'=> new PlayerSubscriptionResource($checkSubscription), 
                'subscriptionPackageDetails'=> new SubscriptionPackageResource($subscriptionPackage)
            ];
        }

        $newSubscribedPlayer = $subscriptionPackage->playerSubscription()->create([
            'start_time' => now(),
            'end_time' => now()->addHours($subscriptionPackage->offered_time),
            'status' => 1,
            'player_id' => $request->userId
        ]);

        return [
            'message'=>'1',                             // 1 for success
            'playerSubscriptionDetails'=> new PlayerSubscriptionResource($newSubscribedPlayer), 
            'subscriptionPackageDetails'=> new SubscriptionPackageResource($subscriptionPackage)
        ];
    }
}
