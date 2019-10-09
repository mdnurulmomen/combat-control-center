<?php

namespace App\Http\Controllers\Web;

use App\Models\Weapon;
use App\Models\Treasure;
use App\Models\Animation;
use App\Models\Character;
use App\Models\GiftPoint;
use App\Models\Parachute;
use App\Models\GiftWeapon;
use App\Models\GiftTreasure;
use App\Models\GiftAnimation;
use App\Models\GiftCharacter;
use App\Models\GiftParachute;
use App\Models\GiftBoostPack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class GiftController extends Controller
{       
    public function showTreasureSettingsForm()
    {
        $allTreasures = Treasure::all();

        if ($allTreasures->isEmpty()) {
            
            return redirect()->back()->withErrors('Please Make Treasure Package First');
        }

        $giftTreasure = GiftTreasure::first();

        return view('admin.other_layouts.gifts.gift_treasure', compact('allTreasures', 'giftTreasure'));
    }

    public function submitTreasureSettingsForm(Request $request)
    {
        $request->validate([]);
  
        $giftTreasure = GiftTreasure::firstOrFail();
        $giftTreasure->treasure_id = $request->treasure_id;
        $giftTreasure->treasure_cost = Treasure::find($request->treasure_id)->equivalent_price;
        $giftTreasure->required_percentage = $request->required_percentage;
        $giftTreasure->required_earn = $giftTreasure->treasure_cost * $request->required_percentage / 100;
        $giftTreasure->save();

        Cache::forever('giftTreasureSetting', $giftTreasure);
        Cache::forever('giftTreasureDetails', Treasure::find($giftTreasure->treasure_id));

        return redirect()->back()->with('success', 'Gift Treasure is Updated');
    }

    public function showGiftAnimations()
    {
        $allAnimations = Animation::all();

        if ($allAnimations->isEmpty()) {
            
            return redirect()->back()->withErrors('Please Make Animation Package First');
        }

        $giftAnimations = GiftAnimation::all()->pluck('gift_animation_index')->toArray();

        return view('admin.other_layouts.gifts.gift_animations', compact('allAnimations', 'giftAnimations'));
    }

    public function submitGiftAnimations(Request $request)
    {
        $request->validate([]);

        GiftAnimation::truncate();

        foreach ($request->gift_animation_index as $key => $value) {

            if ($value > -1) {

                $newGiftAnimation = new GiftAnimation();
                $newGiftAnimation->gift_animation_index = $value;
                $newGiftAnimation->save();
            }

        }

        return redirect()->back()->with('success', 'Gift Animation is Updated');
    }


	public function showGiftBoostPacks()
    {
        $allGiftBoostPacks = GiftBoostPack::firstOrFail();

        return view('admin.other_layouts.gifts.gift_boost_packs', compact('allGiftBoostPacks'));
    }

    public function submitGiftBoostPacks(Request $request)
    {
        $request->validate([
           
        ]);
        
        $giftBoostPack = GiftBoostPack::firstOrFail();

        $giftBoostPack->gift_melee_boost = $request->gift_melee_boost ?? 0;
        $giftBoostPack->gift_light_boost = $request->gift_light_boost ?? 0;
        $giftBoostPack->gift_heavy_boost = $request->gift_heavy_boost ?? 0;
        $giftBoostPack->gift_ammo_boost = $request->gift_ammo_boost ?? 0;
        $giftBoostPack->gift_range_boost = $request->gift_range_boost ?? 0;
        $giftBoostPack->gift_speed_boost = $request->gift_speed_boost ?? 0;
        $giftBoostPack->gift_armor_boost = $request->gift_armor_boost ?? 0;
        $giftBoostPack->gift_multiplier_boost = $request->gift_multiplier_boost ?? 0;

        $giftBoostPack->save();

        return redirect()->back()->with('success', 'Gift Boost Pack is Updated');
    }

    public function showGiftCharacters()
    {
        $allCharacters = Character::all();
        
        if ($allCharacters->isEmpty()) {
            
            return redirect()->back()->withErrors('Please Make Character Package First');
        }

        $giftCharacter = GiftCharacter::all()->pluck('gift_character_index')->toArray();

        return view('admin.other_layouts.gifts.gift_characters', compact('allCharacters', 'giftCharacter'));
    }

    public function submitGiftCharacters(Request $request)
    {
        $request->validate([]);

        GiftCharacter::truncate();

        foreach ($request->gift_character_index as $key => $value) {

            if ($value > -1) {

                $newGiftCharacter = new GiftCharacter();
                $newGiftCharacter->gift_character_index = $value;
                $newGiftCharacter->save();
            }

        }

        return redirect()->back()->with('success', 'Gift Character is Updated');
    }


    public function showGiftParachutes()
    {
        $allParachutes = Parachute::all();

        if ($allParachutes->isEmpty()) {
            
            return redirect()->back()->withErrors('Please Make Parachute Package First');
        }

        $giftParachute = GiftParachute::all()->pluck('gift_parachute_index')->toArray();

        return view('admin.other_layouts.gifts.gift_parachutes', compact('allParachutes', 'giftParachute'));
    }

    public function submitGiftParachutes(Request $request)
    {
        $request->validate([]);

        GiftParachute::truncate();

        foreach ($request->gift_parachute_index as $key => $value) {

            if ($value > -1) {

                $newGiftParachute = new GiftParachute();
                $newGiftParachute->gift_parachute_index = $value;
                $newGiftParachute->save();
            }

        }

        return redirect()->back()->with('success', 'Gift Parachute is Updated');
    }

    public function showGiftWeapons()
    {
        $allWeapons = Weapon::all();
        
        if ($allWeapons->isEmpty()) {
            
            return redirect()->back()->withErrors('Please Make Weapon Package First');
        }

        $giftWeapon = GiftWeapon::all()->pluck('gift_weapon_index')->toArray();

        return view('admin.other_layouts.gifts.gift_weapons', compact('allWeapons', 'giftWeapon'));
    }

    public function submitGiftWeapons(Request $request)
    {
        $request->validate([]);

        GiftWeapon::truncate();

        foreach ($request->gift_weapon_index as $key => $value) {

            if ($value > -1) {

                $newGiftWeapon = new GiftWeapon();
                $newGiftWeapon->gift_weapon_index = $value;
                $newGiftWeapon->save();
            }

        }

        return redirect()->back()->with('success', 'Gift Weapon is Updated');
    }

    public function showGiftPoints()
    {
        $allGiftPoints = GiftPoint::firstOrFail();

        return view('admin.other_layouts.gifts.gift_points', compact('allGiftPoints'));
    }

    public function submitGiftPoints(Request $request)
    {
        $request->validate([]);

        $giftPoints = GiftPoint::firstOrFail();

        $giftPoints->gift_coins = $request->gift_coins ?? 0;
        $giftPoints->gift_gems = $request->gift_gems ?? 0;

        $giftPoints->save();

        return redirect()->back()->with('success', 'Gift Point is Updated');
    }
}
