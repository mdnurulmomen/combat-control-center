<?php

namespace App\Http\Controllers\Api\v2;

use Carbon\Carbon;
use App\Models\Player;
use App\Models\Earning;
use App\Models\Treasure;
use Illuminate\Support\Str;
use App\Models\GiftTreasure;
use Illuminate\Http\Request;
use App\Models\PlayerTreasure;
use App\Models\PlayerStatistic;
use App\Http\Traits\RetrieveToken;
use App\Models\TreasureRedemption;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestWithToken;
use App\Http\Resources\v2\Game\TreasureResource;
use App\Http\Resources\v2\Player\PlayerTreasureResource;

class TreasureController extends Controller
{
    use RetrieveToken;

    public function treasureIdentifier()
    {
        $updatedEarn = Earning::orderBy('total_earning', 'DESC')->first();
        $currentEarn = $updatedEarn->current_earning ?? 0;

        $giftTreasure = GiftTreasure::first();
        $required_earn = $giftTreasure->required_earn ?? 0;

        if ($required_earn <= $currentEarn) {
            
            $treasureDetails = Treasure::find($giftTreasure->treasure_id);

            if ($treasureDetails) {
                
                $updatedEarn->decrement('current_earning', $required_earn ?? 0);
                return ['giftTreasure'=>'true', 'treasureDetails'=>new TreasureResource($treasureDetails)];
            }

            return ['giftTreasure'=>'false'];
        }

        return ['giftTreasure'=>'false'];
    }

    public function playerTreasureList(RequestWithToken $postman)
    {
        $payload = $this->retrieveToken($postman);

        if (is_null($payload)) {
            return response()->json(['error'=>'Invalid token'], 422);
        }

        $request = new Request($payload);
        
        $request->validate([
            'userId'=>'required|exists:players,id'
        ]);

        $player = Player::find($request->userId);

        if (is_null($player)) {
            
            return response()->json(['error'=>'No Player Found'], 422);
        }

        return new PlayerTreasureResource($player);
    }

    public function treasureRedemption(RequestWithToken $postman)
    {
        $payload = $this->retrieveToken($postman);

        if (is_null($payload)) {
            return response()->json(['error'=>'Invalid token'], 422);
        }

        $request = new Request($payload);

        $request->validate([
            'serial'=>'required',
            'userId'=>'required',
            'treasureId'=>'required',
            'playerPhone'=>'nullable|regex:/(01)[0-9]{9}/',
            'agentPhone' => 'nullable|regex:/(01)[0-9]{9}/',
            'exchangingType'=>'required|in:coins,gems,MB,TalkTime,talkTime,talktime'
        ]);

        $playerTreasureExist = PlayerTreasure::where('player_id', $request->userId)
                                            ->where('treasure_id', $request->treasureId)
                                            ->where('id', $request->serial)
                                            ->where('status', 1)
                                            ->first();

        if ($playerTreasureExist) {
            
            $treasureDetails = Treasure::find($request->treasureId);
            $playerStatistics = PlayerStatistic::where('player_id', $request->userId)->first();

            // initiated
            $status = 1;

            if (Str::is('coins', $request->exchangingType)) {

                $playerStatistics->increment($request->exchangingType, $treasureDetails->exchanging_coins);
                $status = -1;
            }

            else if (Str::is('gems', $request->exchangingType)) {
                
                $playerStatistics->increment($request->exchangingType, $treasureDetails->exchanging_gems);
                $status = -1;
            }

            else if (Str::is('MB', $request->exchangingType)) {
                
                $status = -1;
            }

            else if (Str::is('*alk*', $request->exchangingType)) {
                
                $status = 0;
            }

            // Updating Player Treasure
            $playerTreasureExist->status = $status;
            $playerTreasureExist->save();

            // Creating Redeem History
            $this->createTreasureRedemptionHistory($request, $treasureDetails);
            
            return response()->json(['message'=>'success'], 200); 
        }

        return response()->json(['error'=>'Treasure does not belong'], 422);
    }

    public function createTreasureRedemptionHistory(Request $request, Treasure $treasureDetails)
    {
        $newTreasureRedemption = new TreasureRedemption();
        $newTreasureRedemption->player_id = $request->userId;
        $newTreasureRedemption->treasure_id = $request->treasureId;
        $newTreasureRedemption->exchanging_type = $request->exchangingType;
        $newTreasureRedemption->player_phone = $request->playerPhone;
        $newTreasureRedemption->agent_phone = $request->agentPhone;

        if (Str::is('*alk*', $request->exchangingType)) {
            $newTreasureRedemption->status = 0;
        }else{
            $newTreasureRedemption->status = -1;
        }

        $newTreasureRedemption->equivalent_price = $treasureDetails->equivalent_price;
        $newTreasureRedemption->save(); 
    }
}
