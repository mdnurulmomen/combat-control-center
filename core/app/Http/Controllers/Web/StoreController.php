<?php

namespace App\Http\Controllers\Web;

use App\Models\Store;
use App\Models\Purchase;
use App\Http\Traits\UpdateStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*
use App\Models\Weapon;
use App\Models\GemPack;
use App\Models\CoinPack;
use App\Models\BoostPack;
use App\Models\Character;
use App\Models\Animation;
use App\Models\Parachute;
use App\Models\BundlePack;
*/

class StoreController extends Controller
{
    use UpdateStore;

    public function showStoreMethod()
    {

    /*
       $allCharacters = Character::all();
       $allAnimations = Animation::all();
       $allParachutes = Parachute::all();
       $allWeapons = Weapon::all();
       $allBundlePacks = BundlePack::all();

       $allCoinsPacks = CoinPack::all();
       $allGemsPacks = GemPack::all();
       $allBoostPacks = BoostPack::all();

       $stereotypeObjectsCollection_1 = collect([$allCharacters, $allAnimations, $allParachutes, $allWeapons, $allBundlePacks]);

       $stereotypeObjectsCollection_2 = collect([$allCoinsPacks, $allGemsPacks, $allBoostPacks]);

       // Empty the Store Table
       Store::truncate();

        foreach ($stereotypeObjectsCollection_1->all() as $objectInEloquentAll) {
                
            // returning Character::all();
            foreach ($objectInEloquentAll as $object) {   
                    
                $newStoreItem = new Store();

                $newStoreItem->type = $object->type;
                $newStoreItem->name = $object->name;
                $newStoreItem->description = $object->description;

                $newStoreItem->amount = 1;
                $newStoreItem->discount = max($object->discount_taka, $object->discount_coins, $object->discount_gems) ;

                $newStoreItem->origin_price_taka = $object->price_taka;
                $newStoreItem->origin_price_gems = $object->price_gems;
                $newStoreItem->origin_price_coins = $object->price_coins;

                $newStoreItem->offered_price_taka = round($object->price_taka - ($object->price_taka * $object->discount_taka / 100), 2);

                $newStoreItem->offered_price_coins = round($object->price_coins - ($object->price_coins * $object->discount_coins / 100));

                $newStoreItem->offered_price_gems = round($object->price_gems - ($object->price_gems * $object->discount_gems / 100));

                // To Find Bundle Pack Components with Relation
                if($object->type == 'Bundle'){
                    $newStoreItem->bundle_id = $object->id;
                }

                $newStoreItem->save();
            }
        }

        foreach ($stereotypeObjectsCollection_2->all() as $objectInEloquentAll) {
                
            // returning Character::all();
            foreach ($objectInEloquentAll as $object) {

                $newStoreItem = new Store();

                $newStoreItem->type = $object->type;
                $newStoreItem->name = $object->name;
                $newStoreItem->description = $object->description;

                $newStoreItem->amount = $object->amount;
                $newStoreItem->discount = max($object->discount_taka, $object->discount_coins, $object->discount_gems) ;

                $newStoreItem->origin_price_taka = $object->price_taka;
                $newStoreItem->origin_price_gems = $object->price_gems;
                $newStoreItem->origin_price_coins = $object->price_coins;

                $newStoreItem->offered_price_taka = round($object->price_taka - ($object->price_taka * $object->discount_taka / 100), 2);

                $newStoreItem->offered_price_coins = round($object->price_coins - ($object->price_coins * $object->discount_coins / 100));

                $newStoreItem->offered_price_gems = round($object->price_gems - ($object->price_gems * $object->discount_gems / 100));


                $newStoreItem->save();
            }
        }
    */

        $this->createStoreMethod();
        $storeAll = Store::paginate(8);
        
        return view('admin.other_layouts.store.view_store')->with('storeAll', $storeAll);
    }


    public function viewAllPurchases()
    {
      $allPurchases = Purchase::paginate(10);
      return view('admin.other_layouts.store.view_purchases', compact('allPurchases'));
    }
}
