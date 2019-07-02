<?php

namespace App\Http\Controllers\Web;

use App\Models\BoostPack;
use Illuminate\Http\Request;
use App\Http\Traits\UpdateStore;
use App\Http\Controllers\Controller;

class BoostController extends Controller
{
    use UpdateStore;

    public function showEnabledBoostPacks(Request $request)
    {
        if ($request->ajax()) {
            
            return  datatables()->of(BoostPack::query())
                    ->setRowId(function ($boostPack) {
                        return $boostPack->id;
                    })
                    ->setRowClass(function ($boostPack) {
                        return $boostPack->id % 2 == 0 ? 'alert-success' : 'alert-warning';
                    })
                    ->setRowAttr([
                        'text-align' => 'left',
                    ])
                    ->addColumn('action', function($boostPack) {
                        
                        $button = "<i class = 'fa fa-fw fa-eye' style='transform: scale(1.5);' title='View'></i>";
                        $button .= "&nbsp; &nbsp; &nbsp;";

                        $button .= "<i class = 'fa fa-fw fa-edit text-info' style='transform: scale(1.5);' title='Edit'></i>";
                        $button .= "&nbsp; &nbsp; &nbsp;";

                        $button .= "<i class = 'fa fa-fw fa-trash text-danger' style='transform: scale(1.5);' title='Delete'></i>";

                        return $button;
                    })
                    ->make(true);
        }


        return view('admin.other_layouts.boost_packs.all_boost_packs_enabled');       

        /*
        $boostPacks = BoostPack::paginate(6);
        return view('admin.other_layouts.boost_packs.all_boost_packs_enabled', compact('boostPacks'));
        */
    }

    public function showDisabledBoostPacks()
    {
        $boostPacks = BoostPack::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.boost_packs.all_boost_packs_disabled', compact('boostPacks'));
    }

    public function submitCreatedBoostPack(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:boost_packs,name',

            'amount'=>'required',

            'discount'=>'required|numeric|min:0',

            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);

        $newBoostPack = new BoostPack();

        $newBoostPack->name = ucfirst($request->name);
        $newBoostPack->type = $request->type;
        $newBoostPack->description = $request->description;
        $newBoostPack->amount = round($request->amount);

        is_null($request->discount_type) ? $request->discount_type = [] : 0;
        
        in_array('taka', $request->discount_type) ? $newBoostPack->discount_taka = $request->discount : $newBoostPack->discount_taka = 0 ;
        in_array('gems', $request->discount_type) ? $newBoostPack->discount_gems = $request->discount : $newBoostPack->discount_gems = 0 ;
        in_array('coins', $request->discount_type) ? $newBoostPack->discount_coins = $request->discount : $newBoostPack->discount_coins = 0 ;


        $newBoostPack->price_taka = $request->price_taka;
        $newBoostPack->price_gems = round($request->price_gems);
        $newBoostPack->price_coins = round($request->price_coins);

        $newBoostPack->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'New Boost Pack is Created');
    }

    public function submitEditedBoostPack(Request $request, $boostPackId)
    {
        $boostPackToUpdate = BoostPack::findOrFail($boostPackId);

        $request->validate([
            'name'=>'required|unique:boost_packs,name,'.$boostPackToUpdate->id,

            'amount'=>'required',

            'discount'=>'required|numeric|min:0',

            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);

        $boostPackToUpdate->name = ucfirst($request->name);
        $boostPackToUpdate->type = $request->type;
        $boostPackToUpdate->description = $request->description;
        $boostPackToUpdate->amount = round($request->amount);


        is_null($request->discount_type) ? $request->discount_type = [] : 0;
        
        in_array('taka', $request->discount_type) ? $boostPackToUpdate->discount_taka = $request->discount : $boostPackToUpdate->discount_taka = 0 ;
        in_array('gems', $request->discount_type) ? $boostPackToUpdate->discount_gems = $request->discount : $boostPackToUpdate->discount_gems = 0 ;
        in_array('coins', $request->discount_type) ? $boostPackToUpdate->discount_coins = $request->discount : $boostPackToUpdate->discount_coins = 0 ;


        $boostPackToUpdate->price_taka = $request->price_taka;
        $boostPackToUpdate->price_gems = round($request->price_gems);
        $boostPackToUpdate->price_coins = round($request->price_coins);

        $boostPackToUpdate->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Boost Pack is Updated');
    }

    public function boostPackDeleteMethod($boostPackId)
    {
        $boostPackToDelete = BoostPack::findOrFail($boostPackId);
        $boostPackToDelete->delete();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Boost Pack is Deleted');
    }

    public function boostPackUndoMethod($boostPackId)
    {    
        $boostPackToUndo = BoostPack::withTrashed()->find($boostPackId);
        $boostPackToUndo->restore();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Boost Pack is Restored');
    }
}
