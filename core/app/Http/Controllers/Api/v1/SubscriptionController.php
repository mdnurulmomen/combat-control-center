<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use App\Models\Player;
use App\Models\Earning;
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
    	]);

        $player = Player::find($request->userId);
        $checkSubscription = $player->subscribed()->first();

    	if ($checkSubscription) {

            $subscriptionPackage = SubscriptionPackage::find($checkSubscription->subscription_package_id);
			
            return [
                'playerSubscriptionDetails'=> new PlayerSubscriptionResource($checkSubscription), 
				'subscriptionPackageDetails'=> new SubscriptionPackageResource($subscriptionPackage)
            ];
    	}

    	return [
            'playerSubscriptionDetails'=> new PlayerSubscriptionResource(new PlayerSubscription()), 
            'subscriptionPackageDetails'=> new SubscriptionPackageResource(SubscriptionPackage::first())
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
        
        // create new subscribed player
        return $this->createSubscribedPlayer($request, $subscriptionPackage);
    }

    public function createSubscribedPlayer(Request $request, SubscriptionPackage $subscriptionPackage)
    {
        $player = Player::find($request->userId);
        $playerStatistics = $player->playerStatistics;
        
        if($playerStatistics->gems < $subscriptionPackage->price_gem) {
            return response()->json(['error'=>'Not sufficient gems'], 400); 
        }
        else{
            
            $playerStatistics->decrement('gems', $subscriptionPackage->price_gem); 

            // Add earning for solo mode
            $this->addEarnings($subscriptionPackage->price_gem); 
        }            

        $newSubscribedPlayer = $subscriptionPackage->playerSubscription()->create([
            'start_time' => now()->format('Y-m-d'),
            'end_time' => now()->addHours($subscriptionPackage->offered_time)->format('Y-m-d'),
            'status' => 1,
            'player_id' => $request->userId
        ]);

        return [
            'message'=>'1',                             // 1 for success create
            'playerSubscriptionDetails'=> new PlayerSubscriptionResource($newSubscribedPlayer), 
            'subscriptionPackageDetails'=> new SubscriptionPackageResource($subscriptionPackage)
        ];
    }

    // Add earning for solo mode
    public function addEarnings($packagePrice)
    {
        // Last Day Earning
        $lastEarning = Earning::orderBy('total_earning', 'DESC')->first();   

        if (is_null($lastEarning)) {
            
            $newEarning = new Earning();
            $newEarning->current_earning = 0 + $packagePrice ?? 0;
            $newEarning->total_earning =  0 + $packagePrice ?? 0;
            $newEarning->save();   
        }

        else {

            $lastEarningDate = Carbon::parse($lastEarning->updated_at->format('d-m-Y'));
            $presentDate = Carbon::now()->format('d-m-Y');
            $difference = $lastEarningDate->diffInDays($presentDate);

            if ($difference > 0) {

                $newEarning = new Earning();
                $newEarning->current_earning = $lastEarning->current_earning + $packagePrice;
                $newEarning->total_earning = $lastEarning->total_earning + $packagePrice;
                $newEarning->save();           
            }

            else{

                $lastEarning->increment('current_earning', $packagePrice);
                $lastEarning->increment('total_earning', $packagePrice);
            }
        }
    }
}
