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
use App\Models\PlayerMission;
use Illuminate\Http\Request;
use App\Models\PlayerTreasure;
use App\Models\PlayerBoostPack;
use App\Models\PlayerStatistic;
use App\Http\Traits\RetrieveToken;
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

        /*if (is_null($player)) {

            return response()->json(['error'=>'Invalid player'], 422);
        }*/

        // If Game is Paid Mode 
        if (Str::is('*olo', $request->matchType)) {
                
            //  if player is subscribed    
            if ($player->subscribed()->count()) {
                
                // dont charge for match
                
            }else{

                $playerStatistics = $player->playerStatistics;
                $matchRate = GameSetting::first()->game_rate ?? 0;
                $lastEarning = Earning::latest()->first();       // Last Day Earning
                
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
    
        // $returningData = new MatchResource($player);

        // $payload = JWTFactory::emptyClaims()->data($returningData)->make();
        // return $token = JWTAuth::encode($payload);

        // JWTFactory::emptyClaims();
        // $token = JWTAuth::customClaims([$returningData])->fromUser($returningData);
        // $token = JWTAuth::fromUser($returningData, $returningData);

        // return response()->json([
        //     'token' => $token
        // ]);
    }

    // Add earning for solo mode
    public function addEarnings(Earning $lastEarning = null, $matchRate)
    {
        if (is_null($lastEarning)) {
            
            $newEarning = new Earning();
            $newEarning->current_gems_earning = $matchRate;
            $newEarning->total_gems_earning =  $matchRate;
            $newEarning->save();   
        }

        else {

            $lastEarningDate = Carbon::parse($lastEarning->updated_at->format('d-m-Y'));
            $presentDate = today()->format('d-m-Y');
            $difference = $lastEarningDate->diffInDays($presentDate);

            if ($difference > 0) {

                $newEarning = new Earning();

                $newEarning->current_gems_earning = $lastEarning->current_gems_earning + $matchRate;
                $newEarning->total_gems_earning = $lastEarning->total_gems_earning + $matchRate;

                $newEarning->current_currency_earning = $lastEarning->current_currency_earning;
                $newEarning->total_currency_earning = $lastEarning->total_currency_earning;

                $newEarning->save();           
            }

            else{

                $lastEarning->increment('current_gems_earning', $matchRate);
                $lastEarning->increment('total_gems_earning', $matchRate);
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
        // return encrypt($request->token);
        // return openssl_encrypt($request->payload, 'AES-256-CBC', 'IjtT8uqTWOHQ6xRBfqA2tVEhNgjGzlPy', 0, '0000000000000000');

        // try {
            // return decrypt($request->payload);
        // } catch (DecryptException $e) {
        //     
        // }        

        // $decryptedJWTPayload = openssl_decrypt($request->payload, 'AES-256-CBC', 'IjtT8uqTWOHQ6xRBfqA2tVEhNgjGzlPy', 0, '0000000000000000');

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

        $playerStatisticToUpdate->increment('battle_played');

        $newGameHistory->player_rank == 1 ? $playerStatisticToUpdate->increment('battle_wins') : 1;

        if ($request->xpGainInCurrentMatch) {
            
            $numberXpMultiplier = $playerBoostPacksToUpdate->xp_multiplier;
            
            if($numberXpMultiplier) {

                $playerStatisticToUpdate->increment('xp_point', $request->xpGainInCurrentMatch * 2 ?? 0);
                
                // Decrement xpMultiplier
                $playerBoostPacksToUpdate->decrement('xp_multiplier');
            } 
             
            else{

                $playerStatisticToUpdate->increment('xp_point', $request->xpGainInCurrentMatch ?? 0);
            }
        }

        if ($request->coinsGainInCurrentMatch) {
            
            $playerStatisticToUpdate->increment('coins', $request->coinsGainInCurrentMatch);
        }

        if ($request->gemsGainInCurrentMatch) {
            
            $playerStatisticToUpdate->increment('gems', $request->gemsGainInCurrentMatch);

        }

        if ($request->totalTreasureCollected) {
            
            $playerStatisticToUpdate->increment('treasure_collected', $request->totalTreasureCollected);

        }

        if ($request->totalOpponentsKilled) {
            
            $playerStatisticToUpdate->increment('opponent_killed', $request->totalOpponentsKilled);

        }

        if ($request->totalMonsterKilled) {
            
            $playerStatisticToUpdate->increment('monster_killed', $request->totalMonsterKilled);

        }

        if ($request->totalDoubleKills) {
            
            $playerStatisticToUpdate->increment('double_killed', $request->totalDoubleKills);

        }

        if ($request->totalTripleKills) {
            
            $playerStatisticToUpdate->increment('triple_killed', $request->totalTripleKills);

        }

        if ($request->totalItemsCollectedInField) {
            
            $playerStatisticToUpdate->increment('items_collected', $request->totalItemsCollectedInField);

        }

        if ($request->totalGunsCollectedInField) {
            
            $playerStatisticToUpdate->increment('guns_collected', $request->totalGunsCollectedInField);

        }

        if ($request->totalCratesCollected) {
            
            $playerStatisticToUpdate->increment('crates_collected', $request->totalCratesCollected); 

        }

        if ($request->totalAirDropsCollected) {
            
            $playerStatisticToUpdate->increment('air_drops', $request->totalAirDropsCollected ?? 0); 

        }
        
        $playerStatisticToUpdate->player_level = $this->definePlayerLevel($playerStatisticToUpdate->xp_point);
        $playerStatisticToUpdate->player_id = $request->userId;
        $playerStatisticToUpdate->save();

        // If Treasure is Won
        if ($request->totalTreasureWon > 0) {
            
            $this->addPlayerTreasure($request, $playerStatisticToUpdate);
        }

        $missionExists = PlayerMission::where('player_id', $request->userId)->whereDate('updated_at', today())->get();
        
        if (!$missionExists->isEmpty()) {

            $updateMissionProgression = $this->updateMissionProgression($request, $missionExists);

        }

        return ['statistics'=>new StatisticsResource(PlayerStatistic::find($playerStatisticToUpdate->id))];
    }

    public function updateMissionProgression(Request $request, $missions)
    {       
        foreach ($missions as $mission) {
            
            $mission->progress_play_number++;

            if ($request->matchPlayDuration) {

                $mission->progress_play_time +=  $request->matchPlayDuration;
            }

            if ($request->totalOpponentsKilled) {

                $mission->progress_kill_opponent +=  $request->totalOpponentsKilled;
            }

            if ($request->totalMonsterKilled) {
                
                $mission->progress_kill_monster +=  $request->totalMonsterKilled;
            }


            if ($request->playerRankInCurrentMatch == 1) {
                
                $mission->progress_win_top_time++;
                $mission->progress_among_two_time++;
                $mission->progress_among_three_time++;
                $mission->progress_among_five_time++;

            }

            else if ($request->playerRankInCurrentMatch < 3) {
                
                $mission->progress_among_two_time++;
                $mission->progress_among_three_time++;
                $mission->progress_among_five_time++;

            }

            else if ($request->playerRankInCurrentMatch < 4) {
                
                $mission->progress_among_three_time++;
                $mission->progress_among_five_time++;

            }

            else if ($request->playerRankInCurrentMatch < 6) {
                
                $mission->progress_among_five_time++;

            }

            $mission->save();
        }
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
        $giftTreasure = GiftTreasure::first();
        $treasureDetails = Treasure::find($giftTreasure->treasure_id);

        // Create Player new Treasure

        $newPlayerTreasure = new PlayerTreasure();

        $newPlayerTreasure->redeem_code = Str::random(8);

        $newPlayerTreasure->open_time = now();
        
        is_numeric($treasureDetails->durability) ? $newPlayerTreasure->close_time = now()->addDay($treasureDetails->durability) : $newPlayerTreasure->close_time = false;
        
        $newPlayerTreasure->status = 1;
        $newPlayerTreasure->treasure_id = $giftTreasure->treasure_id;
        $newPlayerTreasure->player_id = $request->userId;

        $newPlayerTreasure->save();

        $playerStatisticToUpdate->increment('treasure_won', $request->totalTreasureWon); 

        // Countdown total treasure collected
        $giftTreasure->increment('total_treasure_collected');

    }
}
