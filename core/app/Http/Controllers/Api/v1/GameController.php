<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use App\Models\User;
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
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Http\Controllers\Controller;
use App\Http\Traits\DefinePlayerLevel;
use App\Http\Resources\v1\Game\GameResource;
use App\Http\Resources\v1\Player\MatchResource;
use App\Http\Resources\v1\Player\PlayerStatistic as StatisticsResource;

class GameController extends Controller
{
    // use RetrieveToken;
    use DefinePlayerLevel;

    public function showGameVersion()
    {
        $gameBasics = GameSetting::first();
        return new GameResource($gameBasics);
    }

    public function matchStart(Request $request)
    {
        $request->validate([
            'userId'=>'required|exists:players,id'
        ]);

        $player = Player::find($request->userId);

        if (is_null($player)) {

            return response()->json(['error'=>'Invalid player'], 422);
        }

        // If Game is Paid Mode 
        if (Str::is('*olo', $request->matchType)) {
            
            //  if player is subscribed    
            if ($player->subscribed()->count()) {
                
                // dont charge for match
                
            }else{

                $playerStatistics = $player->playerStatistics;
                $matchRate = GameSetting::first()->game_rate ?? 0;
                $lastEarning = Earning::orderBy('total_earning', 'DESC')->first();       // Last Day Earning
                
                if($playerStatistics->gems < $matchRate) {
                    return response()->json(['error'=>'Not sufficient gems'], 400); 
                }
                else{
                    $playerStatistics->decrement('gems', $matchRate); 
                }            

                // Add earning for solo mode
                $this->addEarnings($lastEarning, $matchRate);
            }  
        }

        // Reducing all selections for match start
        $matchStartSelections = $this->matchStartSelections($player, $request);

        if ($matchStartSelections) {
            
            return $matchStartSelections;
        }
        
        return new MatchResource($player);
    }

    // Add earning for solo mode
    public function addEarnings(Earning $lastEarning, $matchRate)
    {
        if (is_null($lastEarning)) {
            
            $newEarning = new Earning();
            $newEarning->current_earning = 0 + $matchRate ?? 0;
            $newEarning->total_earning =  0 + $matchRate ?? 0;
            $newEarning->save();   
        }

        else {

            $lastEarningDate = Carbon::parse($lastEarning->updated_at->format('d-m-Y'));
            $presentDate = Carbon::now()->format('d-m-Y');
            $difference = $lastEarningDate->diffInDays($presentDate);

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

    // Reducing selections when starting a match 
    public function matchStartSelections(Player $player, Request $request)
    {
        $playerBoostPacks = $player->playerBoostPacks;
        $itemToDecrement = array();

        if($request->gameBoostItems['meleeBooster'] > 102) {

            if($playerBoostPacks->melee_boost > 0)
                $itemToDecrement[] = 'melee_boost'; 
            else
                return response()->json(['error'=>'Not sufficient melee booster'], 401);
        } 
            
        if($request->gameBoostItems['lightBooster'] > 0) {

            if($playerBoostPacks->light_boost > 0)
                $itemToDecrement[] = 'light_boost';
            else
                return response()->json(['error'=>'Not sufficient light booster'], 401);
        } 

        if($request->gameBoostItems['heavyBooster'] > 106) {

            if($playerBoostPacks->heavy_boost > 0)
                $itemToDecrement[] = 'heavy_boost'; 
            else
                return response()->json(['error'=>'Not sufficient heavy booster'], 401);
        }

        if($request->gameBoostItems['ammoBoost']) {

            if($playerBoostPacks->ammo_boost > 0)
                $itemToDecrement[] = 'ammo_boost';  
            else
                return response()->json(['error'=>'Not sufficient ammo booster'], 401);
        }

        if($request->gameBoostItems['speedBoost']) {

            if($playerBoostPacks->speed_boost > 0)
                $itemToDecrement[] = 'speed_boost'; 
            else
                return response()->json(['error'=>'Not sufficient speed booster'], 401);
        }

        if($request->gameBoostItems['armorBoost']) {

            if($playerBoostPacks->armor_boost > 0)
                $itemToDecrement[] = 'armor_boost'; 
            else
                return response()->json(['error'=>'Not sufficient armor booster'], 401);
        }

        if($request->gameBoostItems['rangeBoost']) {

            if($playerBoostPacks->range_boost > 0)
                $itemToDecrement[] = 'range_boost'; 
            else
                return response()->json(['error'=>'Not sufficient range booster'], 401);
        }

        if($request->gameBoostItems['xpMultiplier']) {

            if($playerBoostPacks->xp_multiplier < 1)
                return response()->json(['error'=>'Not sufficient xp booster'], 401);
        }

        // Decrementing Selected Boosts

        if (!empty($itemToDecrement)) {
           
            foreach ($itemToDecrement as $item) {

                $playerBoostPacks->decrement($item, 1); 
            } 
        }
    }

    public function updateGameOverHistory (Request $request)
    {
        $request->validate([
            'userId'=>'required|exists:players,id',
            'matchPlayDuration'=>'required'
        ]);

        // Player
        $playerToUpdate = Player::find($request->userId);

        // Player Statistics
        $playerStatisticToUpdate = $playerToUpdate->playerStatistics;
        
        // Player BoostPacks
        $playerBoostPacksToUpdate = $playerToUpdate->playerBoostPacks;
        
        if (is_null($playerToUpdate) || is_null($playerStatisticToUpdate) || is_null($playerBoostPacksToUpdate)) {
            
            return response()->json(['error'=>'Invalid Player'], 422);
        }

        // New Game History
        $newGameHistory = $this->createNewGameHistory($playerToUpdate, $request);

        $playerStatisticToUpdate->increment('coins', $request->coinsGainInCurrentMatch ?? 0);
        $playerStatisticToUpdate->increment('gems', $request->gemsGainInCurrentMatch ?? 0);

        $numberXpMultiplier = $playerBoostPacksToUpdate->xp_multiplier;

        if($numberXpMultiplier) {

            $playerStatisticToUpdate->increment('xp_point', $request->xpGainInCurrentMatch * 2 ?? 0);
            
            // Decrement xpMultiplier
            $playerBoostPacksToUpdate->decrement('xp_multiplier');
        } 
         
        else{

            $playerStatisticToUpdate->increment('xp_point', $request->xpGainInCurrentMatch ?? 0);
        }

        $playerStatisticToUpdate->increment('battle_played');
        $newGameHistory->player_rank == 1 ? $playerStatisticToUpdate->increment('battle_wins') : 1;
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

        // If Treasure is Won
        $this->addPlayerTreasure($request, $playerStatisticToUpdate);

        return [
            
            'statistics'=>new StatisticsResource($playerStatisticToUpdate),
        ];
    }

    public function createNewGameHistory(Player $playerToUpdate, Request $request)
    {
        return $playerToUpdate->playerHistories()->create([
            'game_date' => now(),
            'battle_mode' => $request->battleMode ?? 'free',
            'play_duration' => $request->matchPlayDuration,
            'player_rank' => $request->playerRankInCurrentMatch ?? 0
        ]);
    }

    // If Player Win Treasure after Game Over
    public function addPlayerTreasure(Request $request, PlayerStatistic $playerStatisticToUpdate)
    {
        if ($request->totalTreasureWon > 0) {

            $giftTreasure = GiftTreasure::first();
            $treasureDetails = Treasure::find($giftTreasure->treasure_id);

            // Create Player new Treasure

            if ($treasureDetails && $giftTreasure) {
                
                $newPlayerTreasure = new PlayerTreasure();

                $newPlayerTreasure->redeem_code = Str::random(8);

                $treasureDetails->collecting_point == -1 ? $newPlayerTreasure->collecting_point = 'nearest point' : $newPlayerTreasure->collecting_point = $treasureDetails->collecting_point;

                $newPlayerTreasure->open_time = now();

                $treasureDetails->durability == -1 ? $newPlayerTreasure->close_time = 'undefined' : $newPlayerTreasure->close_time = now()->addDay($treasureDetails->durability) ;
                
                $newPlayerTreasure->status = 1;
                $newPlayerTreasure->treasure_id = $giftTreasure->treasure_id;
                $newPlayerTreasure->player_id = $request->userId;

                $newPlayerTreasure->save();
            }


            $playerStatisticToUpdate->increment('treasure_won', $request->totalTreasureWon);
        }  
    }
}
