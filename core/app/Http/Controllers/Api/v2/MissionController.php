<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Player;
use App\Models\Mission;
use App\Models\MissionType;
use Illuminate\Http\Request;
use App\Models\PlayerMission;
use App\Http\Controllers\Controller;
use App\Http\Resources\v2\Player\PlayerMissionResource;

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

   		return ['missions' => PlayerMissionResource::collection($missionExists)];
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


?>