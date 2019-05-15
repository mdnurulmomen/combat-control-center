<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Player;
use App\Models\Leader;
use App\Models\GiftPoint;
use App\Models\GiftWeapon;
use Illuminate\Http\Request;
use App\Models\PlayerWeapon;
use App\Models\GiftCharacter;
use App\Models\GiftAnimation;
use App\Models\GiftParachute;
use App\Models\GiftBoostPack;
use App\Models\PlayerAnimation;
use App\Models\PlayerCharacter;
use App\Models\PlayerParachute;
use App\Models\PlayerBoostPack;
use App\Models\DailyLoginCheck;
use App\Models\PlayerStatistic;
use App\Http\Traits\RetrieveToken;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestWithToken;
use App\Http\Resources\Player\PlayerResource;
use App\Http\Resources\Player\LeaderResource;
use App\Http\Resources\Player\MyLeaderResource;

class PlayerController extends Controller
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

    use RetrieveToken;

    public function checkPlayerExist(RequestWithToken $postman)
    {
        $payload = $this->retrieveToken($postman);

        if (is_null($payload)) {
            return response()->json(['error'=>'Invalid token'], 422);
        }

        $request = new Request($payload);

        $request->validate([
          'facebookId'=>'required_without:userDeviceId'
        ]);

        if(is_null($request->facebookId) || empty($request->facebookId)) {

            if ($userExist = User::where('device_info', $request->userDeviceId)->first()) {

                return redirect()->route('api.player_view', $userExist->player->id);
                // return redirect()->route('api.player_view')->with('userId', $userExist->player->id);
            }
            else{
                return $this->createPlayerMethod($request);
            }
        }

        else{

            if ($userExist = User::where('facebook_id', $request->facebookId)->first()) {

                return redirect()->route('api.player_view', $userExist->player->id);
                // return redirect()->route('api.player_view')->with('userId', $userExist->player->id);
            }

            else if ($userExist = User::where('device_info', $request->userDeviceId)->first()) {

                // Merging with Guest Account
                $userExist->username = $request->facebookName;
                $userExist->device_info = '';
                $userExist->email = $request->userEmail;
                $userExist->facebook_id = $request->facebookId;
                $userExist->facebook_name = $request->facebookName;
                $userExist->login_type = 'true';

                $userExist->save();

                return redirect()->route('api.player_view', $userExist->player->id);
            }

            else{
                return $this->createPlayerMethod($request);
            }
        }
    }

    public function createPlayerMethod($request)
    {
        // Creating New User
        $newUser = new User();
        $newUser->username = $request->facebookName ?? $request->userName;
        $newUser->phone = $request->mobileNo ?? '';
        $newUser->email = $request->userEmail ?? '';
        $newUser->location = $request->userLocation ?? 'Dhaka';
        $newUser->facebook_id = $request->facebookId ?? '';
        $newUser->facebook_name = $request->facebookName ?? '';
        $newUser->profile_pic = $request->profilePic ?? '';
        $newUser->country = $request->country ?? 'Bangladesh';
        $newUser->connection_type = $request->connectionType;
        $newUser->type = strtolower('player');
        empty($request->facebookId) ? $newUser->device_info = $request->userDeviceId : $newUser->device_info = '';
        empty($request->facebookId) ? $newUser->login_type = 'false' : $newUser->login_type = 'true';
        $newUser->save();


        // Creating New Player
        $newPlayer = $newUser->player()->create([
            'selected_parachute' => $request->selectedParachute ?? 0,
            'selected_character' => $request->selectedCharacter ?? 0,
            'selected_animation' => $request->selectedAnimation ?? 0,
            'selected_weapon' => $request->selectedWeapon ?? 0,
        ]);


        // Creating New Players Boost Packs
        $giftBoostPack = GiftBoostPack::first();
        
        $newPlayerBoostPack = $newPlayer->playerBoostPacks()->create([
            'melee_boost' => $giftBoostPack->gift_melee_boost ?? 0,
            'light_boost' => $giftBoostPack->gift_light_boost ?? 0,
            'heavy_boost' => $giftBoostPack->gift_heavy_boost ?? 0,
            'ammo_boost' => $giftBoostPack->gift_ammo_boost ?? 0,
            'range_boost' => $giftBoostPack->gift_range_boost ?? 0,
            'speed_boost' => $giftBoostPack->gift_speed_boost ?? 0,
            'armor_boost' => $giftBoostPack->gift_armor_boost ?? 0,
            'xp_multiplier' => $giftBoostPack->gift_multiplier_boost ?? 0,
        ]);
          

        // Creating New Players Statistics
        $giftPoints = GiftPoint::first();

        $newPlayerStatistic = $newPlayer->playerStatistics()->create([
            'coins' => $giftPoints->gift_coins ?? 0,
            'gems' => $giftPoints->gift_gems ?? 0,
        ]);


        // Creating New Players Gift Characters
        $giftCharacters = GiftCharacter::all();

        if ($giftCharacters->isNotEmpty() && !$giftCharacters->contains('gift_character_index', -1)) {
            
            foreach ($giftCharacters as $giftCharacter) {

                $newPlayerCharacter = $newPlayer->playerCharacters()->create([

                    'character_index' => $giftCharacter->gift_character_index,
                ]);
            }
        } 


        // Creating New Players Gift Animations
        $giftAnimations = GiftAnimation::all();

        if ($giftAnimations->isNotEmpty() && !$giftAnimations->contains('gift_animation_index', -1)) {

            foreach ($giftAnimations as $giftAnimation) {

                $newPlayerAnimation = $newPlayer->playerAnimations()->create([

                    'animation_index' => $giftAnimation->gift_animation_index,
                ]);
            }
        }


        // Creating New Players Gift Parachutes
        $giftParachutes = GiftParachute::all();

        if ($giftParachutes->isNotEmpty() && !$giftParachutes->contains('gift_parachute_index', -1)) { 

            foreach ($giftParachutes as $giftParachute) {

                $newPlayerParachute = $newPlayer->playerParachutes()->create([

                    'parachute_index' => $giftParachute->gift_parachute_index,
                ]);
            }
        }


        // Creating New Players Gift Weapons
        $giftWeapons = GiftWeapon::all();

        if ($giftWeapons->isNotEmpty() && !$giftWeapons->contains('gift_weapon_index', -1)) {

            foreach ($giftWeapons as $giftWeapon) {

                $newPlayerWeapon = $newPlayer->playerWeapons()->create([

                    'weapon_index' => $giftWeapon->gift_weapon_index,
                ]);
            }
        }

        // Creating New Players Login History
        $newLogin = $newPlayer->checkLoginDays()->create([

            'consecutive_days' => 1,
        ]);


        return new PlayerResource($newPlayer);
    }
    

    // Creating Players Login Data

    public function consecutiveLoginDays($playerId)
    {
        $playerLogin = DailyLoginCheck::where('player_id', $playerId)->first();

        if (is_null($playerLogin) || empty($playerLogin)) {
            
            DailyLoginCheck::create(['player_id' => $playerId, 'consecutive_days' => 1]);
        }

        else{

            $previousLoginDate = new Carbon($playerLogin->updated_at);
            $currentDate = Carbon::now();

            $difference = $previousLoginDate->diff($currentDate)->days;
            
            if($difference > 0 && $difference < 2){
                $playerLogin->increment('consecutive_days');
            }

            elseif($difference > 1){
                $playerLogin->update(['consecutive_days' => 1]);
                $playerLogin->touch();              // To Update updated_at            
            }
            
        }
    }

    public function showPlayerDetails(Request $request, $playerId = null)
    {   
        if ($request->token) {
            
            $payload = $this->retrieveToken($request);

            if (is_null($payload)) {
                return response()->json(['error'=>'Invalid token'], 422);
            }

            $request = new Request($payload);
        }

        // $request->validate([
        //     'userId'=>'required'
        // ]);

        $playerToShow = Player::find($request->userId ?? $playerId);

        if(is_null($playerToShow) || empty($playerToShow)){

            return response()->json(['error'=>'Invalid player'], 422);
        }

        $this->consecutiveLoginDays($playerToShow->id);
        
        return new PlayerResource($playerToShow);
    }

    public function editUserInfo(RequestWithToken $postman)
    {
        $payload = $this->retrieveToken($postman);

        if (is_null($payload)) {
            return response()->json(['error'=>'Invalid token'], 422);
        }

        $request = new Request($payload);

        $request->validate([
            'userId'=>'required'
        ]);

        $request = $this->sanitize($request);

        $request_1 = $request->only(['username', 'phone', 'device_info', 'email', 'location', 'facebook_id', 'facebook_name', 'profile_pic', 'login_type', 'connection_type', 'country']);

        $request_2 = $request->only(['player_batch','selected_parachute', 'selected_character', 'selected_animation', 'selected_weapon']);

        $request_1 = array_filter($request_1, function($value) {
            return ($value !== null); 
        });

        $request_2 = array_filter($request_2, function($value) {
            return ($value !== null && $value !== false); 
        });

        // $userToUpdate = User::find(Auth::guard('api')->user()->id);

        $userToUpdate = User::find($request->userId);

        if(!is_null($userToUpdate)){
            
            $playerToUpdate = Player::find($userToUpdate->player->id);

            $userToUpdate->update($request_1);
            $playerToUpdate->update($request_2);
   
            return new PlayerResource($playerToUpdate);
        }

        return response()->json(['error'=>'Invalid user'], 422);
    }

    public function sanitize(Request $request)
    {
        if (!empty($request->facebookName)) {
            $request['username'] = $request->facebookName;
        }
        else{
            $request['username'] = $request->userName;
        }
        
        unset($request['userName']);

        $request['phone'] = $request->mobileNo;
        unset($request['mobileNo']);

        $request['email'] = $request->userEmail;
        unset($request['userEmail']);

        $request['location'] = $request->userLocation;
        unset($request['userLocation']);

        $request['facebook_id'] = $request->facebookId;
        unset($request['facebookId']);

        $request['facebook_name'] = $request->facebookName;
        unset($request['facebookName']);

        $request['profile_pic'] = $request->profilePic;
        unset($request['profilePic']);

        $request['connection_type'] = $request->connectionType;
        unset($request['connectionType']);

        if (empty($request->facebook_id)) {
            $request['device_info'] = $request->userDeviceId;
            $request['login_type'] = 'false';
        }
        else{
            $request['device_info'] = '';
            $request['login_type'] = 'true';
        }

        $request['player_batch'] = $request->playerBatch;
        unset($request['playerBatch']);

        $request['selected_parachute'] = $request->selectedParachute;
        unset($request['selectedParachute']);

        $request['selected_character'] = $request->selectedCharacter;
        unset($request['selectedCharacter']);

        $request['selected_animation'] = $request->selectedAnimation;
        unset($request['selectedAnimation']);

        $request['selected_weapon'] = $request->selectedWeapon;
        unset($request['selectedWeapon']);

        return $request;
    }

    public function showLeaderboard(Request $request)
    {
        $request->validate([
          'userId'=>'required'
        ]);


        $topLeaders = PlayerStatistic::orderBy(DB::raw("`opponent_killed` + `monster_killed` + `double_killed` + `triple_killed`"), 'DESC')->get();

        if ($topLeaders->isEmpty()) {
            return response()->json(['message'=>'No player found'], 422);
        }

        Leader::truncate();

        foreach($topLeaders as $leader){
            $newLeader = new Leader();
            $newLeader->username = $leader->player->user->username;
            $newLeader->total_kill =  $leader->opponent_killed + $leader->monster_killed + $leader->double_killed + $leader->triple_killed;
            $newLeader->treasure_won = $leader->treasure_won;
            $newLeader->level = $leader->player_level;
            $newLeader->location = $leader->player->user->location;
            $newLeader->profile_pic = $leader->player->user->profile_pic;
            $newLeader->player_id = $leader->player_id;
            $newLeader->save();
        }

        $leaders = Leader::take(20)->get();
        $myPossition = Player::find($request->userId)->playerLeadershipPosition;


        return ['topLeaders' => LeaderResource::collection($leaders), 'myPossition'=> new MyLeaderResource($myPossition)];
    }


    public function updateMultipleAssets(RequestWithToken $postman)
    {
        $payload = $this->retrieveToken($postman);

        if (is_null($payload)) {
            return response()->json(['error'=>'Invalid token'], 422);
        }

        $request = new Request($payload);

        $request->validate([
            'userId'=>'required'
        ]);

        $playerToUpdate = Player::find($request->userId);

        $playerStatisticsToUpdate = $playerToUpdate->playerStatistics;
        $playerBoostPacksToUpdate = $playerToUpdate->playerBoostPacks;

        $coins = $request->coinsEarned ?? 0;
        $gems = $request->gemsEarned ?? 0;
        $xp_multiplier = $request->xpMultiplierEarned ?? 0;

        $playerStatisticsToUpdate->increment('coins', $coins);
        $playerStatisticsToUpdate->increment('gems', $gems);
        $playerBoostPacksToUpdate->increment('xp_multiplier', $xp_multiplier);

        return response()->json(['message'=>'success'], 200);
    }
}
