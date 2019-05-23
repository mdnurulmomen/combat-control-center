<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use App\Models\Player;
use App\Models\Earning;
use App\Models\Treasure;
use Illuminate\Support\Str;
use App\Models\PlayHistory;
use App\Models\GameSetting;
use App\Models\GiftTreasure;
use Illuminate\Http\Request;
use App\Models\PlayerTreasure;
use App\Models\PlayerBoostPack;
use App\Models\PlayerStatistic;
use App\Http\Traits\DefinePlayerLevel;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Game\GameResource;
use App\Http\Resources\v1\Player\MatchResource;
use App\Http\Resources\v1\Player\PlayerStatistic as StatisticsResource;

class GameController extends Controller
{
    /*
    protected $request;

    public function __construct(Request $postman)
    {
        $postman->validate([
            'payload'=>'required'
        ]);    

        $decryptedJWTPayload = openssl_decrypt($postman->payload, 'AES-256-CBC', env('CUSTOM_ENCRYPTION_KEY'), 0, env('CUSTOM_IV_KEY'));
        $this->request = JWTAuth::getPayload(JWTAuth::setToken($decryptedJWTPayload))->get();
        $this->request = new Request($this->request);
    }
    */

    use DefinePlayerLevel;

    public function showGameVersion()
    {
        $gameBasics = GameSetting::first();
        return new GameResource($gameBasics);
    }

    public function matchStart(Request $request)
    {
        $request->validate([
            'userId'=>'required'
        ]);

        $player = Player::find($request->userId);

        if (is_null($player)) {

            return response()->json(['error'=>'Invalid player'], 422);
        }

        $playerBoostPacks = $player->playerBoostPacks;
        $itemToDecrement = array();

        if($request->gameBoostItems['meleeBooster'] > 102) {

            if($playerBoostPacks->melee_boost > 0)
                $itemToDecrement[] = 'melee_boost'; 
            else
                return response()->json(['error'=>'Not sufficient melee booster'], 400);
        } 
                    
        if($request->gameBoostItems['lightBooster'] > -1) {

            if($playerBoostPacks->light_boost > 0)
                $itemToDecrement[] = 'light_boost';
            else
                return response()->json(['error'=>'Not sufficient light booster'], 400);
        } 
        
        if($request->gameBoostItems['heavyBooster'] > -1) {

            if($playerBoostPacks->heavy_boost > 0)
                $itemToDecrement[] = 'heavy_boost'; 
            else
                return response()->json(['error'=>'Not sufficient heavy booster'], 400);
        }
        
        if($request->gameBoostItems['ammoBoost']) {

            if($playerBoostPacks->ammo_boost > 0)
                $itemToDecrement[] = 'ammo_boost';  
            else
                return response()->json(['error'=>'Not sufficient ammo booster'], 400);
        }
        
        if($request->gameBoostItems['speedBoost']) {

            if($playerBoostPacks->speed_boost > 0)
                $itemToDecrement[] = 'speed_boost'; 
            else
                return response()->json(['error'=>'Not sufficient speed booster'], 400);
        }
      
        if($request->gameBoostItems['armorBoost']) {

            if($playerBoostPacks->armor_boost > 0)
                $itemToDecrement[] = 'armor_boost'; 
            else
                return response()->json(['error'=>'Not sufficient armor booster'], 400);
        }
        
        if($request->gameBoostItems['rangeBoost']) {

            if($playerBoostPacks->range_boost > 0)
                $itemToDecrement[] = 'range_boost'; 
            else
                return response()->json(['error'=>'Not sufficient range booster'], 400);
        }

        if($request->gameBoostItems['xpMultiplier']) {

            if($playerBoostPacks->xp_multiplier < 1)
                return response()->json(['error'=>'Not sufficient xp booster'], 400);
        }

        // Decrementing Selected Boosts

        if (!empty($itemToDecrement)) {
           
            foreach ($itemToDecrement as $item) {

                $playerBoostPacks->decrement($item, 1); 
            } 
        }
        

        if (Str::is('*olo', $request->matchType)) {
			
			$playerStatistics = $player->playerStatistics;
			
			if($playerStatistics->gems < 2) {
				return response()->json(['error'=>'Not sufficient gems'], 400);	
			}
			else{
				$playerStatistics->decrement('gems', 2); 
			}
				

            $matchRate = GameSetting::first()->game_rate;
            $lastEarning = Earning::orderBy('total_earning', 'DESC')->first();

            if (is_null($lastEarning)) {
                
                $newEarning = new Earning();
                $newEarning->current_earning = 0 + $matchRate ?? 0;
                $newEarning->total_earning =  0 + $matchRate ?? 0;
                $newEarning->save(); 

                return new MatchResource($player);         
            }

            else{

                $lastEarningDate = new Carbon($lastEarning->created_at);
                $presentDate = Carbon::now();

                $difference = $lastEarningDate->diff($presentDate)->days;
                
                if ($difference > 0) {

                    $newEarning = new Earning();
                    $newEarning->current_earning = $lastEarning->current_earning + $matchRate;
                    $newEarning->total_earning = $lastEarning->total_earning + $matchRate;
                    $newEarning->save();           
                }

                else{

                    $lastEarning->increment('current_earning', $matchRate);
                    $lastEarning->increment('total_earning', $matchRate);
                }
            }
        }

        
        return new MatchResource($player);
    }


    public function updateGameOverHistory (Request $request)
    {
        $request->validate([
            'userId'=>'required',
            'matchPlayDuration'=>'required'
        ]);

        // Game History
        $newGameHistory = new PlayHistory();
        $newGameHistory->game_date = Carbon::now()->format('Y-m-d H:i:s');
        $newGameHistory->battle_mode = $request->battleMode ?? 'free';
        $newGameHistory->play_duration = $request->matchPlayDuration;
        $newGameHistory->player_rank = $request->playerRankInCurrentMatch ?? 0;
        $newGameHistory->player_id = $request->userId;
        $newGameHistory->save();
        

        // Player Statistics
        $playerStatisticToUpdate = PlayerStatistic::where('player_id', $request->userId)->first();

        if (is_null($playerStatisticToUpdate)) {
            return response()->json(['error'=>'Invalid Player'], 422);
        }

        $playerStatisticToUpdate->increment('coins', $request->coinsGainInCurrentMatch ?? 0);

        // Player BoostPacks
        $playerBoostPacksToUpdate = PlayerBoostPack::where('player_id', $request->userId)->first();
        $numberXpMultiplier = $playerBoostPacksToUpdate->xp_multiplier;

        if($numberXpMultiplier > 0) {

            $playerStatisticToUpdate->increment('xp_point', $request->xpGainInCurrentMatch * 2 ?? 0);
            // Decrement xpMultiplier
            $playerBoostPacksToUpdate->decrement('xp_multiplier');
        } 
         
        else{
            $playerStatisticToUpdate->increment('xp_point', $request->xpGainInCurrentMatch ?? 0);
        }

        $playerStatisticToUpdate->increment('battle_played');
        $newGameHistory->player_rank == 1 ? $playerStatisticToUpdate->increment('battle_wins') : 1;

        // If Treasure is Won
        if ($request->totalTreasureWon > 0) {

            $giftTreasure = GiftTreasure::first();
            $treasureDetails = Treasure::find($giftTreasure->treasure_id);

            $newPlayerTreasure = new PlayerTreasure();

            $newPlayerTreasure->redeem_code = Str::random(8);

            $treasureDetails->collecting_point == -1 ? $newPlayerTreasure->collecting_point = 'Nearest Point' : $newPlayerTreasure->collecting_point = $treasureDetails->collecting_point;

            $newPlayerTreasure->open_time = Carbon::now();

            $treasureDetails->durability == -1 ? $newPlayerTreasure->close_time = 'undefined' : $newPlayerTreasure->close_time = Carbon::now()->addDay($treasureDetails->durability) ;
            
            $newPlayerTreasure->status = 1;
            $newPlayerTreasure->treasure_id = $giftTreasure->treasure_id;
            $newPlayerTreasure->player_id = $request->userId;

            $newPlayerTreasure->save();

            $playerStatisticToUpdate->increment('treasure_won', $request->totalTreasureWon);
        }


        $playerStatisticToUpdate->increment('treasure_collected', $request->totalTreasureCollected ?? 0);
        $playerStatisticToUpdate->increment('opponent_killed', $request->totalOpponentsKilled ?? 0);
        $playerStatisticToUpdate->increment('monster_killed', $request->totalMonsterKilled ?? 0);
        $playerStatisticToUpdate->increment('double_killed', $request->totalDoubleKills ?? 0);
        $playerStatisticToUpdate->increment('triple_killed', $request->totalTripleKills ?? 0);
        $playerStatisticToUpdate->increment('items_collected', $request->totalItemsCollectedInField ?? 0);
        $playerStatisticToUpdate->increment('guns_collected', $request->totalGunsCollectedInField ?? 0);
        $playerStatisticToUpdate->increment('crates_collected', $request->totalCratesCollected ?? 0);
        $playerStatisticToUpdate->increment('air_drops', $request->totalAirDropsCollected ?? 0);
        $playerStatisticToUpdate->player_level = $this->definePlayerLevel($playerStatisticToUpdate->xp_point);
        $playerStatisticToUpdate->player_id = $request->userId;
        $playerStatisticToUpdate->save();

        
        return [
            
            'statistics'=>new StatisticsResource($playerStatisticToUpdate),
        ];

        // return response()->json(['message'=>'success'], 200);
    }
}
