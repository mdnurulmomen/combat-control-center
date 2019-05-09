<?php

namespace App\Http\Controllers\Web;

use App\Models\Weapon;
use App\Http\Traits\UpdateStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WeaponController extends Controller
{
	use UpdateStore;
    
    public function showEnabledweapons()
    {
        $weapons = Weapon::paginate(6);
        return view('admin.other_layouts.weapons.all_weapons_enabled', compact('weapons'));
    }

    public function showDisabledweapons()
    {
        $weapons = Weapon::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.weapons.all_weapons_disabled', compact('weapons'));
    }
    
    public function submitCreateWeaponForm(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:weapons,name',
            
            'discount'=>'required|numeric|min:0',

            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);

        $newWeapon = new Weapon();

        $newWeapon->name = $request->name;
        $newWeapon->type = $request->type;
        $newWeapon->description = $request->description;

        is_null($request->discount_type) ? $request->discount_type = [] : 0;

        in_array('taka', $request->discount_type) ? $newWeapon->discount_taka = $request->discount : $newWeapon->discount_taka = 0 ;
        in_array('gems', $request->discount_type) ? $newWeapon->discount_gems = $request->discount : $newWeapon->discount_gems = 0 ;
        in_array('coins', $request->discount_type) ? $newWeapon->discount_coins = $request->discount : $newWeapon->discount_coins = 0 ;

        $newWeapon->price_taka = $request->price_taka;
        $newWeapon->price_gems = round($request->price_gems);
        $newWeapon->price_coins = round($request->price_coins);

        $newWeapon->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'New Weapon has been Created');
    }

    public function showWeaponEditForm(Request$request, $weaponId)
    {
        $weaponToUpdate = Weapon::findOrFail($weaponId);
        return view('admin.other_layouts.weapons.edit_weapon', compact('weaponToUpdate'));
    }

    public function submitWeaponEditForm(Request $request, $weaponId)
    {
        $weaponToUpdate = Weapon::findOrFail($weaponId);

        $request->validate([
            'name'=>'required|unique:weapons,name,'.$weaponToUpdate->id,
            
            'discount'=>'required|numeric|min:0',

            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);

        $weaponToUpdate->name = $request->name;
        $weaponToUpdate->type = $request->type;
        $weaponToUpdate->description = $request->description;

        is_null($request->discount_type) ? $request->discount_type = [] : 0;
        
        in_array('taka', $request->discount_type) ? $weaponToUpdate->discount_taka = $request->discount : $weaponToUpdate->discount_taka = 0 ;
        in_array('gems', $request->discount_type) ? $weaponToUpdate->discount_gems = $request->discount : $weaponToUpdate->discount_gems = 0 ;
        in_array('coins', $request->discount_type) ? $weaponToUpdate->discount_coins = $request->discount : $weaponToUpdate->discount_coins = 0 ;

        $weaponToUpdate->price_taka = $request->price_taka;
        $weaponToUpdate->price_gems = round($request->price_gems);
        $weaponToUpdate->price_coins = round($request->price_coins);

        $weaponToUpdate->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Weapon has been Updated');
    }

    public function weaponDeleteMethod($weaponId)
    {
        $weaponToDelete = Weapon::findOrFail($weaponId);
        $weaponToDelete->delete();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Weapon is Deleted');
    }


    public function weaponUndoMethod($weaponId)
    { 
        $weaponToUndo = Weapon::withTrashed()->find($weaponId);
        $weaponToUndo->restore();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Weapon is Restored');
    }
}
