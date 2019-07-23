<?php

namespace App\Http\Controllers\Web;

use DB;
use DataTables;
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
        $treasures = Treasure::with('treasureType')->paginate(6);
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
            'durability'=>'nullable|min:1'
        ]);

        $newTreasure = new Treasure();

        $newTreasure->name = ucfirst($request->name) ?? 'No Name';
        $newTreasure->amount = $request->amount ?? 1;
        $newTreasure->equivalent_price = $request->equivalent_price;   

        // is_null($request->collecting_point) ? $newTreasure->collecting_point = -1 : $newTreasure->collecting_point = $request->collecting_point;
        
        is_numeric($request->durability) ? $newTreasure->durability = $request->durability : $newTreasure->durability = 'undefined';

        is_null($request->exchanging_coins) ? $newTreasure->exchanging_coins = 0 : $newTreasure->exchanging_coins = $request->exchanging_coins;
        is_null($request->exchanging_gems) ? $newTreasure->exchanging_gems = 0 : $newTreasure->exchanging_gems = $request->exchanging_gems;
        is_null($request->exchanging_megabyte) ? $newTreasure->exchanging_megabyte = 0 : $newTreasure->exchanging_megabyte = $request->exchanging_megabyte;

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
            'durability'=>'nullable|min:1'
        ]);

        $treasureToUpdate = Treasure::findOrFail($treasureId);

        $treasureToUpdate->name = ucfirst($request->name) ?? 'No Name';
        $treasureToUpdate->amount = $request->amount ?? 1;
        $treasureToUpdate->equivalent_price = $request->equivalent_price;   

        // is_null($request->collecting_point) ? $treasureToUpdate->collecting_point = -1 : $treasureToUpdate->collecting_point = $request->collecting_point;

        is_numeric($request->durability) ? $treasureToUpdate->durability = $request->durability : $treasureToUpdate->durability = 'undefined';

        // is_null($request->durability) ? $treasureToUpdate->durability = -1 : $treasureToUpdate->durability = $request->durability;

        is_null($request->exchanging_coins) ? $treasureToUpdate->exchanging_coins = 0 : $treasureToUpdate->exchanging_coins = $request->exchanging_coins;
        is_null($request->exchanging_gems) ? $treasureToUpdate->exchanging_gems = 0 : $treasureToUpdate->exchanging_gems = $request->exchanging_gems;
        is_null($request->exchanging_megabyte) ? $treasureToUpdate->exchanging_megabyte = 0 : $treasureToUpdate->exchanging_megabyte = $request->exchanging_megabyte;

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
        $allPlayerTreasures = PlayerTreasure::where('treasure_id', $treasureToUpdate->id)
                                            ->where('status', 1)
                                            ->get();

        foreach ($allPlayerTreasures as $playerTreasure) {

            is_numeric($treasureToUpdate->durability) ? $playerTreasure->close_time = now()->addDay($treasureToUpdate->durability) : $playerTreasure->close_time = false;

            $playerTreasure->save();

           
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
                                                    ->with('player', 'treasure')
                                                    ->paginate(8);


        return view('admin.other_layouts.treasures.all_gifted_treasure', compact('allGiftedTreasures'));
    }

    public function showAllTreasureRedeemed(Request $request)
    {
        if ($request->ajax()) {
            
            $modal = TreasureRedemption::where('status', -1)->with(['player.user', 'treasure'])->select('treasure_redemptions.*');

            return  DataTables::eloquent($modal)
                    
                    ->addColumn('action', function(){
                        return "<i class='fa fa-eye fa-2x tooltip-test' title='View'></i>";
                    })

                    ->setRowId(function (TreasureRedemption $redemption) {
                        return $redemption->id;
                    })

                    ->setRowClass(function (TreasureRedemption $redemption) {
                        return $redemption->id % 2 == 0 ? 'alert-success' : 'alert-warning';
                    })

                    ->setRowAttr([
                        'align' => 'center',
                    ])

                    ->make(true);
        }

        return view('admin.other_layouts.treasures.all_redeemed_treasure');

        /*
        $allRedeemedTreasures = TreasureRedemption::where('status', -1)->with('player', 'treasure')->paginate(8);
        return view('admin.other_layouts.treasures.all_redeemed_treasure', compact('allRedeemedTreasures'));
        */
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

    public function showTreasureRequested(Request $request)
    {
        if ($request->ajax()) {
            
            $modal = TreasureRedemption::where('status', 0)->with(['player.user', 'treasure'])->select('treasure_redemptions.*');

            return  DataTables::eloquent($modal)
                    
                    ->addColumn('selection', function(TreasureRedemption $requested){

                        return "<input type='checkbox' class='requestedTreasure' id='$requested->id' data-playerPhone='$requested->player_phone' data-rechargeAmount='$requested->equivalent_price' data-toggle='toggle' data-on='Marked' data-off='Not Marked' data-onstyle='success' data-offstyle='outline-danger' data-style='ios' data-size='sm'>";
                    })

                    ->rawColumns(['selection', 'checkbox'])

                    ->setRowData([
                        'send' => function() {
                            return "<button type='button' class='btn btn-info float-right' data-toggle='modal' data-target='#confirmRequestedNumbers'>
                                    Send
                                  </button>";
                        }
                    ])

                    ->setRowId(function (TreasureRedemption $redemption) {
                        return $redemption->id;
                    })

                    ->setRowClass(function (TreasureRedemption $redemption) {
                        return $redemption->id % 2 == 0 ? 'alert-success' : 'alert-warning';
                    })

                    ->setRowAttr([
                        'align' => 'center',
                    ])

                    ->make(true);
        }

        return view('admin.other_layouts.treasures.all_treasure_requested');

        /*
        $allRequestedTreasures = TreasureRedemption::where('status', 0)->with('player', 'treasure')->latest()->paginate(8);
        return view('admin.other_layouts.treasures.all_treasure_requested', compact('allRequestedTreasures'));
        */
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
        
        return redirect()->back()->with('success', 'Treasure Requests are Updated');
    }
}
