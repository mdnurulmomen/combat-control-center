<?php

namespace App\Http\Controllers\Web;

use DB;
use Carbon\Carbon;
use App\Models\Treasure;
use Illuminate\Http\Request;
use App\Models\GiftTreasure;
use App\Models\TreasureType;
use App\Models\PlayerTreasure;
use App\Models\TreasureRedemption;
use App\Http\Controllers\Controller;


class TreasureController extends Controller
{

    public function showAllEnabledTreasureTypes()
    {
        $treasureTypes = TreasureType::paginate(6);
        return view('admin.other_layouts.treasures.all_treasure_types_enabled', compact('treasureTypes'));
    }

    public function showAllDisabledTreasureTypes()
    {
        $treasureTypes = TreasureType::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.treasures.all_treasure_types_disabled', compact('treasureTypes'));
    }

    public function submitCreateTreasureTypeForm(Request $request)
    {
        $request->validate([
            'treasure_type_name'=>'required|unique:treasure_types,treasure_type_name'
        ]);

        $newTreasureType = new TreasureType();
        $newTreasureType->treasure_type_name = ucfirst($request->treasure_type_name);
        $newTreasureType->save();

        return redirect()->back()->with('success', 'New Treasure Type has been Created');
    }

    public function submitTreasureTypeEditForm(Request $request, $treasureTypeId)
    {
        $treasureTypeToUpdate =  TreasureType::find($treasureTypeId);

        $request->validate([
            'treasure_type_name'=>'required|unique:treasure_types,treasure_type_name,'.$treasureTypeToUpdate->id
        ]);

        $treasureTypeToUpdate->treasure_type_name = ucfirst($request->treasure_type_name);
        $treasureTypeToUpdate->save();

        return redirect()->back()->with('success', 'Treasure Type has been Updated');
    }


    public function treasureTypeDeleteMethod($treasureTypeId)
    {
        $treasureTypeToDelete = TreasureType::find($treasureTypeId);
        $treasureTypeToDelete->relatedTreasures()->delete(); 
        $treasureTypeToDelete->delete();

        return redirect()->back()->with('success', 'Treasure Type is Deleted');
    }

    public function treasureTypeUndoMethod($treasureTypeId)
    {
        $treasureTypeToUndo = TreasureType::withTrashed()->find($treasureTypeId);
        $treasureTypeToUndo->relatedTreasures()->restore();
        $treasureTypeToUndo->restore();

        return redirect()->back()->with('success', 'Treasure Type is Restored'); 
    }

    public function showEnabledTreasures()
    {
        $treasures = Treasure::paginate(6);
        return view('admin.other_layouts.treasures.all_treasures_enabled', compact('treasures'));
    }

    public function showDisabledTreasures()
    {
        $treasures = Treasure::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.treasures.all_treasures_disabled', compact('treasures'));
    }

    public function submitCreateTreasureForm(Request $request)
    {
        $request->validate([
            'treasure_type_id'=>'required',
            'equivalent_price'=>'required|numeric|min:0',
            'durability'=>'nullable|numeric'
        ]);

        $newTreasure = new Treasure();

        $newTreasure->name = ucfirst($request->name) ?? 'No Name';
        $newTreasure->amount = $request->amount ?? 1;
        $newTreasure->equivalent_price = $request->equivalent_price;   

        is_null($request->collecting_point) ? $newTreasure->collecting_point = -1 : $newTreasure->collecting_point = $request->collecting_point;
        is_null($request->durability) ? $newTreasure->durability = -1 : $newTreasure->durability = $request->durability;

        is_null($request->exchanging_coins) ? $newTreasure->exchanging_coins = 0 : $newTreasure->exchanging_coins = $request->exchanging_coins;
        is_null($request->exchanging_gems) ? $newTreasure->exchanging_gems = 0 : $newTreasure->exchanging_gems = $request->exchanging_gems;

        $newTreasure->treasure_type_id = $request->treasure_type_id;
        $newTreasure->description = $request->description; 

        $newTreasure->save();


        return redirect()->back()->with('success', 'New Treasure has been Created');
    }

    public function submitTreasureEditForm(Request $request, $treasureId)
    {
        $request->validate([
            'treasure_type_id'=>'required',
            'equivalent_price'=>'required|numeric|min:0',
            'durability'=>'nullable|numeric'
        ]);

        $treasureToUpdate = Treasure::findOrFail($treasureId);

        $treasureToUpdate->name = ucfirst($request->name) ?? 'No Name';
        $treasureToUpdate->amount = $request->amount ?? 1;
        $treasureToUpdate->equivalent_price = $request->equivalent_price;   

        is_null($request->collecting_point) ? $treasureToUpdate->collecting_point = -1 : $treasureToUpdate->collecting_point = $request->collecting_point;
        is_null($request->durability) ? $treasureToUpdate->durability = -1 : $treasureToUpdate->durability = $request->durability;

        is_null($request->exchanging_coins) ? $treasureToUpdate->exchanging_coins = 0 : $treasureToUpdate->exchanging_coins = $request->exchanging_coins;
        is_null($request->exchanging_gems) ? $treasureToUpdate->exchanging_gems = 0 : $treasureToUpdate->exchanging_gems = $request->exchanging_gems;

        $treasureToUpdate->treasure_type_id = $request->treasure_type_id;
        $treasureToUpdate->description = $request->description; 

        $treasureToUpdate->save();


        // Updating Gift Treasure Cost and Required Earn
        $this->updateGiftTreasure($treasureToUpdate);

        // Updating PlayerTreasure who Got the Same Treasure
        $this->updatePlayerGiftTreasure($treasureToUpdate);

        return redirect()->back()->with('success', 'Treasure has been Updated');
    }

    public function updateGiftTreasure(Treasure $treasureToUpdate)
    {
        $giftTreasure = GiftTreasure::firstOrFail();

        if ($giftTreasure->treasure_id == $treasureToUpdate->id) {
            
            $giftTreasure->treasure_cost = $treasureToUpdate->equivalent_price;
            $giftTreasure->required_earn = $giftTreasure->treasure_cost * $giftTreasure->required_percentage / 100;
            $giftTreasure->save();
        }
    }

    public function updatePlayerGiftTreasure(Treasure $treasureToUpdate)
    {
        $allPlayerTreasures = PlayerTreasure::all();

        foreach ($allPlayerTreasures as $playerTreasure) {

            if ($playerTreasure->treasure_id == $treasureToUpdate->id) {
                
                $treasureToUpdate->collecting_point == -1 ? $playerTreasure->collecting_point = 'nearest point' : $playerTreasure->collecting_point = $treasureToUpdate->collecting_point;
                $treasureToUpdate->durability == -1 ? $playerTreasure->close_time = 'undefined' : $playerTreasure->close_time = date_add(date_create($playerTreasure->open_time), date_interval_create_from_date_string($treasureToUpdate->durability." days"));

                $playerTreasure->save();

            }
        }
    }

    public function showAllTreasureGifted(Request $request)
    {    
        $request->validate([
            'treasure_id'=>'required',
            'date'=>'required|date|after:2000-01-01'
        ]);
        

        $allGiftedTreasures = PlayerTreasure::where('treasure_id', $request->treasure_id)
                                                    ->whereDate('created_at', $request->date)
                                                    ->paginate(8);


        return view('admin.other_layouts.treasures.all_gifted_treasure', compact('allGiftedTreasures'));
    }

    public function showAllTreasureRedeemed()
    {
        $allRedeemedTreasures = TreasureRedemption::paginate(8);
        return view('admin.other_layouts.treasures.all_redeemed_treasure', compact('allRedeemedTreasures'));
    }

    public function treasureDeleteMethod($treasureId)
    {
        $treasureToDelete = Treasure::find($treasureId);
        $treasureToDelete->delete();

        return redirect()->back()->with('success', 'Treasure is Deleted');
    }

    public function treasureUndoMethod($treasureId)
    {      
        $treasureToUndo = Treasure::withTrashed()->find($treasureId);
        $treasureToUndo->restore();

        return redirect()->back()->with('success', 'Treasure is Restored');
    }

    public function showTreasureRequested()
    {
        $allRequestedTreasures = TreasureRedemption::where('status', 0)->orderBy('created_at', 'desc')->paginate(8);
        return view('admin.other_layouts.treasures.all_treasure_requested', compact('allRequestedTreasures'));
    }

    public function confirmTreasureRequested(Request $request)
    {
        $request->validate([

            'id'=>'required',
            'player_phone'=>'required',
            'recharge_amount'=>'required'
        ]);

        $allRequestedTreasure = TreasureRedemption::findOrFail($request->id);
            
        foreach ($allRequestedTreasure as $requestedTreasure) {

            $requestedTreasure->update(['status' => -1]);

            // Updating Player Treasure
            PlayerTreasure::where('player_id', $requestedTreasure->player_id)
                            ->where('treasure_id', $requestedTreasure->treasure_id)
                            ->where('status', 0)
                            ->firstOrFail()
                            ->update(['status' => -1]);
        }
        
        return redirect()->back()->with('success', 'Treasure Request are Updated');
    }
}
