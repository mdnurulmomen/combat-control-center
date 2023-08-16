<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Player;
use App\Models\Mission;
use Illuminate\Support\Str;
use App\Models\MissionType;
use Illuminate\Http\Request;
use App\Models\PlayerMission;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Player\PlayerMissionResource;

class MissionController extends Controller
{
   	public function showPlayerMissions(Request $request)
   	{
   		$request->validate([

   			'userId'=>'required|exists:players,id'
   		]);


   		$player = Player::find($request->userId);

   		$missionExists = PlayerMission::where('player_id', $request->userId)->whereDate('updated_at', today())->get();
   		
   		if ($missionExists->isEmpty()) {

   			$missionExists = $this->addPlayerMissions($player);

   		}

   		$this->rewardCompletedMission($player->playerMissions, $player);

   		return ['missions' => PlayerMissionResource::collection($missionExists)];
   	}

   	public function rewardCompletedMission($playerMissions, Player $player)
   	{
   		foreach ($playerMissions as $playerMission) {

   			if (!$playerMission->rewarded) {
   				
	   			$mission = Mission::find($playerMission->mission_id);

	   			$missionType = $mission->missionType;

	   			$playerStatisticsToUpdate = $player->playerStatistics;
	   			
	   			if (Str::contains($missionType->mission_type_name, ['Play', 'More'])) {

		            if ($mission->play_number && $playerMission->progress_play_number >= $mission->play_number) {

		            	$playerStatisticsToUpdate->increment('xp_point', $mission->reward_amount);
		            	
		            	$playerMission->update([
		            		'mission_completion'=>true,
		            		'rewarded'=>true,
		            	]);
		            	
		            }

		            else if($mission->play_time && $playerMission->progress_play_time >= $mission->play_time) {

		            	$playerStatisticsToUpdate->increment('xp_point', $mission->reward_amount);

		            	$playerMission->update([
		            		'mission_completion'=>true,
		            		'rewarded'=>true,
		            	]);
		            }

		        }

		        else if (Str::contains($missionType->mission_type_name, ['Opponents'])) {
		            
		            if ($playerMission->progress_kill_opponent >= $mission->kill_opponent) {
		            	
		            	$playerStatisticsToUpdate->increment('xp_point', $mission->reward_amount);

		            	$playerMission->update([
		            		'mission_completion'=>true,
		            		'rewarded'=>true,
		            	]);
		            }
		            
		        }

		        else if (Str::contains($missionType->mission_type_name, ['Monsters'])) {

		            if ($playerMission->progress_kill_monster >= $mission->kill_monster) {
		            	
		            	$playerStatisticsToUpdate->increment('xp_point', $mission->reward_amount);

		            	$playerMission->update([
		            		'mission_completion'=>true,
		            		'rewarded'=>true,
		            	]);
		            } 
		        }

		        else if (Str::contains($missionType->mission_type_name, ['Win', 'Battle'])) {

		            if ($playerMission->progress_win_top_time >= $mission->win_top_time) {
		            	
		            	$playerStatisticsToUpdate->increment('xp_point', $mission->reward_amount);

		            	$playerMission->update([
		            		'mission_completion'=>true,
		            		'rewarded'=>true,
		            	]);
		            }   
		        }

		        else if (Str::contains($missionType->mission_type_name, ['Among', 'Positions'])) {

		            if ($mission->among_two_time && $playerMission->progress_among_two_time >= $mission->among_two_time) {
		            	
		            	$playerStatisticsToUpdate->increment('xp_point', $mission->reward_amount);

		            	$playerMission->update([
		            		'mission_completion'=>true,
		            		'rewarded'=>true,
		            	]);
		            }

		            else if ($mission->among_three_time && $playerMission->progress_among_three_time >= $mission->among_three_time) {
		            	
		            	$playerStatisticsToUpdate->increment('xp_point', $mission->reward_amount);

		            	$playerMission->update([
		            		'mission_completion'=>true,
		            		'rewarded'=>true,
		            	]);
		            }

		            else if ($mission->among_five_time && $playerMission->progress_among_five_time >= $mission->among_five_time) {
		            	
		            	$playerStatisticsToUpdate->increment('xp_point', $mission->reward_amount);

		            	$playerMission->update([
		            		'mission_completion'=>true,
		            		'rewarded'=>true,
		            	]);
		            }
		            
		        } 
   			}
   		}
   	}

   	public function addPlayerMissions(Player $player)
   	{
   		$distinctMissionTypesId = MissionType::distinct()->pluck('id');
		$randomMissions = collect([]);

		foreach($distinctMissionTypesId as $missionTypeId){

			$randomMission = Mission::inRandomOrder()->where('mission_type_id', $missionTypeId)->first();

			if ($randomMission) {
				
				$randomMissions = $randomMissions->push($randomMission);

			}
		}
		
		$playerAllMissions = collect([]);

		foreach($randomMissions as $mission){

			$playerNewMission = $player->playerMissions()->create([

	            'mission_id' => $mission->id,
			]);

			$playerAllMissions = $playerAllMissions->push($playerNewMission); 

		}


		return $playerAllMissions;
   	}
}
