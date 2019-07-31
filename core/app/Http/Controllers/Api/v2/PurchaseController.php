<?php

namespace App\Http\Controllers\Api\v2;

use Carbon\Carbon;
use App\Models\Store;
use App\Models\Player;
use App\Models\Weapon;
use App\Models\Earning;
use App\Models\GemPack;
use App\Models\CoinPack;
use App\Models\Purchase;
use App\Models\BoostPack;
use App\Models\Animation;
use App\Models\Character;
use App\Models\Parachute;
use App\Models\BundlePack;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PlayerWeapon;
use App\Models\PlayerCharacter;
use App\Models\PlayerAnimation;
use App\Models\PlayerParachute;
use App\Models\BlackListedNumber;
use App\Http\Traits\RetrieveToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestWithToken;

class PurchaseController extends Controller
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

    protected $itemId;
    protected $userId;
    protected $gatewayName;
    protected $paymentId;

    use RetrieveToken;

    public function addPlayerCharacter($characterIndexToAdd, $playerId, $itemToDeduct, $priceToDeduct)
    {
        $alreadyExist = PlayerCharacter::where('player_id', $playerId)
                                        ->where('character_index', $characterIndexToAdd)
                                        ->exists();

        if(!$alreadyExist){

            $playerStatistics = Player::find($playerId)->playerStatistics;

            $playerStatistics->decrement($itemToDeduct, $priceToDeduct);

            if (!$priceToDeduct) {
                
                $this->updateEarnings();

            }

            $playerCharacter = new PlayerCharacter();
            $playerCharacter->character_index = $characterIndexToAdd;
            $playerCharacter->player_id = $playerId;
            $playerCharacter->save();

            $this->addPurchaseHistory();
        }

        return response()->json(['message'=>'success'], 200);
    }

    public function addPlayerWeapon($weaponIndexToAdd, $playerId, $itemToDeduct, $priceToDeduct)
    {
        $alreadyExist = PlayerWeapon::where('player_id', $playerId)
                                    ->where('weapon_index', $weaponIndexToAdd)
                                    ->exists();

        if(!$alreadyExist){

            $playerStatistics = Player::find($playerId)->playerStatistics;

            $playerStatistics->decrement($itemToDeduct, $priceToDeduct);

            if (!$priceToDeduct) {
                
                $this->updateEarnings();

            }

            $playerWeapon = new PlayerWeapon();
            $playerWeapon->weapon_index = $weaponIndexToAdd;
            $playerWeapon->player_id = $playerId;
            $playerWeapon->save();

            $this->addPurchaseHistory();
        }

        return response()->json(['message'=>'success'], 200);
    }

    public function addPlayerParachute($parachuteIndexToAdd, $playerId, $itemToDeduct, $priceToDeduct)
    {
        $alreadyExist = PlayerParachute::where('player_id', $playerId)
                                        ->where('parachute_index', $parachuteIndexToAdd)
                                        ->exists();

        if(!$alreadyExist){
            
            $playerStatistics = Player::find($playerId)->playerStatistics;

            $playerStatistics->decrement($itemToDeduct, $priceToDeduct);

            if (!$priceToDeduct) {
                
                $this->updateEarnings();

            }

            $playerParachute = new PlayerParachute();
            $playerParachute->parachute_index = $parachuteIndexToAdd;
            $playerParachute->player_id = $playerId;
            $playerParachute->save();

            $this->addPurchaseHistory();
        }

        return response()->json(['message'=>'success'], 200);
    }

    // All these are Index's, Not ID
    public function addPlayerAnimation($animationIndexToAdd, $playerId, $itemToDeduct, $priceToDeduct)
    {
        $alreadyExist = PlayerAnimation::where('player_id', $playerId)
                                        ->where('animation_index', $animationIndexToAdd)
                                        ->exists();

        if(!$alreadyExist){

            $playerStatistics = Player::find($playerId)->playerStatistics;

            $playerStatistics->decrement($itemToDeduct, $priceToDeduct);

            if (!$priceToDeduct) {
                
                $this->updateEarnings();

            }

            $playerAnimation = new PlayerAnimation();
            $playerAnimation->animation_index = $animationIndexToAdd;
            $playerAnimation->player_id = $playerId;
            $playerAnimation->save();

            $this->addPurchaseHistory();
        }

        return response()->json(['message'=>'success'], 200);
    }

    public function addPlayerBoostPack(BoostPack $boostPackToAdd, $playerId)
    {
        if($boostPackToAdd){

            $boostPackName = $boostPackToAdd->name;

            $playerBoostPack = Player::find($playerId)->playerBoostPacks;

            if (Str::is('Mele*', $boostPackName)) {
                $playerBoostPack->increment('melee_boost', $boostPackToAdd->amount);
            }
            else if (Str::is('Light*', $boostPackName)) {
                $playerBoostPack->increment('light_boost', $boostPackToAdd->amount);
            }
            else if (Str::is('Heavy*', $boostPackName)) {
                $playerBoostPack->increment('heavy_boost', $boostPackToAdd->amount);
            }
            else if (Str::is('Ammo*', $boostPackName)) {
                $playerBoostPack->increment('ammo_boost', $boostPackToAdd->amount);
            }
            else if (Str::is('Range*', $boostPackName)) {
                $playerBoostPack->increment('range_boost', $boostPackToAdd->amount);
            }
            else if (Str::is('Speed*', $boostPackName)) {
                $playerBoostPack->increment('speed_boost', $boostPackToAdd->amount);
            }
            else if (Str::is('Armor*', $boostPackName)) {
                $playerBoostPack->increment('armor_boost', $boostPackToAdd->amount);
            }
            else if (Str::is('X*', $boostPackName)) {
                $playerBoostPack->increment('xp_multiplier', $boostPackToAdd->amount);
            }

            $this->addPurchaseHistory();

            return response()->json(['message'=>'success'], 200);
        }

        return response()->json(['error'=>'Invalid BoostPack'], 422);
    }


    public function addPlayerBundlePack($bundlePackId, $playerId)
    {
        $bundlePackExist = BundlePack::where('id', $bundlePackId)->exists();       

        if($bundlePackExist){

            $bundleComponents = BundlePack::find($bundlePackId)->bundleComponents;

            $playerStatistics = Player::find($playerId)->playerStatistics;
            $playerBoostPacks = Player::find($playerId)->playerBoostPacks;

            foreach ($bundleComponents as $component) {
                
                if($component->component_type == 'Gems Pack'){
                    $playerStatistics->increment('gems', $component->amount ?? 0);
                }
                else if($component->component_type == 'Coins Pack'){
                    $playerStatistics->increment('coins', $component->amount ?? 0);
                }
                elseif (Str::is('Mel*', $component->component_type)) {
                    $playerBoostPacks->increment('melee_boost', $component->amount ?? 0);
                }
                elseif (Str::is('Light*', $component->component_type)) {
                    $playerBoostPacks->increment('light_boost', $component->amount ?? 0);
                }
                elseif (Str::is('Heavy*', $component->component_type)) {
                    $playerBoostPacks->increment('heavy_boost', $component->amount ?? 0);
                }
                elseif (Str::is('Ammo*', $component->component_type)) {
                    $playerBoostPacks->increment('ammo_boost', $component->amount ?? 0);
                }
                elseif (Str::is('Range*', $component->component_type)) {
                    $playerBoostPacks->increment('range_boost', $component->amount ?? 0);
                }
                elseif (Str::is('Speed*', $component->component_type)) {
                    $playerBoostPacks->increment('speed_boost', $component->amount ?? 0);
                }
                elseif (Str::is('Armor*', $component->component_type)) {
                    $playerBoostPacks->increment('armor_boost', $component->amount ?? 0);
                }
                elseif (Str::is('X*', $component->component_type)) {
                    $playerBoostPacks->increment('xp_multiplier', $component->amount ?? 0);
                }
            }

            $this->addPurchaseHistory();

            return response()->json(['message'=>'success'], 200);
        }

        return response()->json(['error'=>'Invalid Bundle Pack'], 422);
    }


    public function purchaseStoreItem(RequestWithToken $postman)
    {
        $payload = $this->retrieveToken($postman);

        if (is_null($payload)) {
            return response()->json(['error'=>'Invalid token'], 422);
        }

        $request = new Request($payload);

        $request->validate([
            'userId'=>'required|exists:players,id',
            'itemId'=>'required',
            'gatewayName'=>'required'
        ]);

        // Item Details
        $this->itemId = $request->itemId;
        $this->userId = $request->userId;
        $this->gatewayName = $request->gatewayName;
        $this->paymentId = $request->paymentId ?? 'None';

        $item = Store::find($this->itemId);
        $player = Player::find($this->userId);

        if (!$player || !$item) {

            return response()->json(['error'=>'Invalid Item or Player'], 422);
        }

        $playerStatistics = $player->playerStatistics;

        // purchase
        if (Str::is('*oin*', $this->gatewayName) || Str::is('*em*', $this->gatewayName)) {

            // Gems/Coins Cant be Purchased with Coins
            if(Str::is('*oin*', $this->gatewayName) && $item->offered_price_coins <= $playerStatistics->coins && $item->type != 'Gems Pack' && $item->type != 'Coins Pack'){

                $price = $item->offered_price_coins;
                return $this->addPurchasedItem($item, $this->userId, 'coins', $price);
            }

            // Gems Cant be Purchased with Gems
            else if(Str::is('*em*', $this->gatewayName) && $item->offered_price_gems <= $playerStatistics->gems  && $item->type != 'Gems Pack'){

                $price = $item->offered_price_gems;
                return $this->addPurchasedItem($item, $this->userId, 'gems', $price);
            }

            else{

                return response()->json(['error'=>'Not Sufficient Coins or Gems or Invalid Request'], 401);
            }
        }

        // For Other Gateways
        else{

            $price = 0;

            return $this->addPurchasedItem($item, $this->userId, 'coins', $price);
        }

    }

    public function updateEarnings()
    {
        $item = Store::find($this->itemId);
        $priceToAdd = $item->offered_price_taka;

        $lastEarning = Earning::latest()->first();

        if (is_null($lastEarning)) {
            
            $newEarning = new Earning();
            $newEarning->current_currency_earning = $priceToAdd;
            $newEarning->total_currency_earning =  $priceToAdd;
            $newEarning->save();   
        }

        else {

            $lastEarningDate = Carbon::parse($lastEarning->updated_at->format('d-m-Y'));
            $presentDate = today()->format('d-m-Y');
            $difference = $lastEarningDate->diffInDays($presentDate);

            if ($difference > 0) {

                $newEarning = new Earning();

                $newEarning->current_gems_earning = $lastEarning->current_gems_earning;
                $newEarning->total_gems_earning = $lastEarning->total_gems_earning;

                $newEarning->current_currency_earning = $lastEarning->current_currency_earning + $priceToAdd;
                $newEarning->total_currency_earning = $lastEarning->total_currency_earning + $priceToAdd;

                $newEarning->save();           
            }

            else{

                $lastEarning->increment('current_currency_earning', $priceToAdd);
                $lastEarning->increment('total_currency_earning', $priceToAdd);
            }
        }

    }

    public function addPurchaseHistory()
    {
        // Purchase History
        $newPurchase = new Purchase();
        $newPurchase->item_id = $this->itemId;
        $newPurchase->buyer_id = $this->userId;
        $newPurchase->gateway_name = $this->gatewayName;
        $newPurchase->payment_id = $this->paymentId ?? 'None';
        $newPurchase->save();
    }

    public function addPurchasedItem(Store $item, $userId, $itemToDeduct, $priceToDeduct)
    {
        $playerStatistics = Player::find($userId)->playerStatistics;

        if($item->type == 'character'){

            $allCharactersName = Character::all()->pluck('name')->toArray();
            $characterIndexToAdd = array_search($item->name, $allCharactersName);   // Returns Array Index Number Or Key
                
            return $this->addPlayerCharacter($characterIndexToAdd, $userId, $itemToDeduct, $priceToDeduct);
        }

        else if($item->type=='weapon'){
            
            $allWeaponsName = Weapon::all()->pluck('name')->toArray();
            $weaponIndexToAdd = array_search($item->name, $allWeaponsName);   // Returns Array Index Number Or Key
                
            return $this->addPlayerWeapon($weaponIndexToAdd, $userId, $itemToDeduct, $priceToDeduct);
        }

        else if($item->type=='animation'){

            $allAnimationsName = Animation::all()->pluck('name')->toArray();
            $animationIndexToAdd = array_search($item->name, $allAnimationsName);   // Returns Array Index Number Or Key
                
            return $this->addPlayerAnimation($animationIndexToAdd, $userId, $itemToDeduct, $priceToDeduct);
        }


        else if($item->type=='parachute'){

            $allParachutesName = Parachute::all()->pluck('name')->toArray();
            $parachuteIndexToAdd = array_search($item->name, $allParachutesName);   // Returns Array Index Number Or Key
                
            return $this->addPlayerParachute($parachuteIndexToAdd, $userId, $itemToDeduct, $priceToDeduct);
        }


        else if($item->type=='Coins Pack'){

            $playerStatistics->decrement($itemToDeduct, $priceToDeduct);
            $playerStatistics->increment('coins', $item->amount);

            if (!$priceToDeduct) {
                
                $this->updateEarnings();

            }
            
            $this->addPurchaseHistory();
            
            return response()->json(['message'=>'success'], 200);
            
        }

        else if($item->type=='Gems Pack'){
            
            $playerStatistics->increment('gems', $item->amount);

            if (!$priceToDeduct) {
                
                $this->updateEarnings();

            }

            $this->addPurchaseHistory();

            return response()->json(['message'=>'success'], 200);
        }

        else if($item->type=='Boost Pack'){
            
            $playerStatistics->decrement($itemToDeduct, $priceToDeduct);

            if (!$priceToDeduct) {
                
                $this->updateEarnings();
            
            }

            $boostPackToAdd = BoostPack::where('name', $item->name)->first();

            return $this->addPlayerBoostPack($boostPackToAdd, $userId);
        }

        else if($item->type=='Bundle'){

            $playerStatistics->decrement($itemToDeduct, $priceToDeduct);

            if (!$priceToDeduct) {
                
                $this->updateEarnings();

            }

            return $this->addPlayerBundlePack($item->bundle_id, $userId);
        }
    }

    public function checkBlackListNumber(Request $request)
    {
        $request->validate([
            'mobileNumber'=>'required',
            'block'=>'required|boolean'
        ]);

        if($request->block){
            $numberToAdd = new BlackListedNumber();
            $numberToAdd->mobile_number = $request->mobileNumber;
            $numberToAdd->save();
            return response()->json(['message'=>'added'], 200);

        }else{

            $numberToCheck = BlackListedNumber::where('mobile_number', $request->mobileNumber)->first();

            if (is_null($numberToCheck)) {
                return response()->json(['message'=>'Not BlackListed'], 200);
            }
            else
                return response()->json(['message'=>'BlackListed'], 200);
        }

    }
}
