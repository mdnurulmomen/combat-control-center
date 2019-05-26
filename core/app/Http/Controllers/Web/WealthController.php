<?php

namespace App\Http\Controllers\Web;

use App\Models\GemPack;
use App\Models\CoinPack;
use App\Http\Traits\UpdateStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WealthController extends Controller
{
    use UpdateStore;

    public function showEnabledCoinPacks()
    {
        $coins = CoinPack::paginate(6);
        return view('admin.other_layouts.coin_packs.all_coins_enabled', compact('coins'));
    }

    public function showDisabledCoinPacks()
    {
        $coins = CoinPack::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.coin_packs.all_coins_disabled', compact('coins'));
    }

    public function submitCreatedCoinPack(Request $request)
    {
        $request->validate([
            'amount'=>'required|required|unique:coin_packs,amount',
            
            'discount'=>'required|numeric|min:0',
            
            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0'
        ]);

        $newCoinPack = new CoinPack();

        $newCoinPack->name = $request->name;
        $newCoinPack->type = $request->type;
        $newCoinPack->description = $request->description;
        $newCoinPack->amount = round($request->amount);

        is_null($request->discount_type) ? $request->discount_type = [] : 0;

        in_array('taka', $request->discount_type) ? $newCoinPack->discount_taka = $request->discount : $newCoinPack->discount_taka = 0 ;
        
        in_array('gems', $request->discount_type) ? $newCoinPack->discount_gems = $request->discount : $newCoinPack->discount_gems = 0 ;
        
        $newCoinPack->price_taka = $request->price_taka;
        $newCoinPack->price_gems = round($request->price_gems);

        $newCoinPack->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'New Coins Pack is Created');
    }

    /*
    public function showCoinPackEditForm(Request$request, $coinId)
    {
        $coinPackToUpdate = CoinPack::findOrFail($coinId);
        return view('admin.other_layouts.coin_packs.edit_coin', compact('coinPackToUpdate'));
    }
    */

    public function submitEditedCoinPack(Request $request, $coinId)
    {
        $coinPackToUpdate = CoinPack::findOrFail($coinId);

        $request->validate([
            'amount'=>'required|unique:coin_packs,amount,'.$coinPackToUpdate->id,
            
            'discount'=>'required|numeric|min:0',
            
            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0'
        ]);


        $coinPackToUpdate->name = $request->name;
        $coinPackToUpdate->type = $request->type;
        $coinPackToUpdate->description = $request->description;
        $coinPackToUpdate->amount = round($request->amount);

        is_null($request->discount_type) ? $request->discount_type = [] : 0;
        
        in_array('taka', $request->discount_type) ? $coinPackToUpdate->discount_taka = $request->discount : $coinPackToUpdate->discount_taka = 0 ;
        
        in_array('gems', $request->discount_type) ? $coinPackToUpdate->discount_gems = $request->discount : $coinPackToUpdate->discount_gems = 0 ;
        
        $coinPackToUpdate->price_taka = $request->price_taka;
        $coinPackToUpdate->price_gems = round($request->price_gems);

        $coinPackToUpdate->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Coins Pack is Updated');
    }

    public function coinPackDeleteMethod($coinPackId)
    {
        $coinPackToDelete = CoinPack::findOrFail($coinPackId);
        $coinPackToDelete->delete();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Coins Pack is Deleted');
    }


    public function coinPackUndoMethod($coinPackId)
    {    
        $coinPackToUndo = CoinPack::withTrashed()->find($coinPackId);
        $coinPackToUndo->restore();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Coin Pack is Restored');
    }

    public function showEnabledGemPacks()
    {
        $gems = GemPack::paginate(6);
        return view('admin.other_layouts.gem_packs.all_gems_enabled', compact('gems'));
    }

    public function showDisabledGemPacks()
    {
        $gems = GemPack::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.gem_packs.all_gems_disabled', compact('gems'));
    }
    
    public function submitCreatedGemPack(Request $request)
    {
        $request->validate([
            'amount'=>'required|unique:gem_packs,amount',
            'price_taka'=>'required|numeric|min:0',
        ]);

        $newGemPack = new GemPack();

        $newGemPack->name = $request->name;
        $newGemPack->type = $request->type;
        $newGemPack->description = $request->description;

        $newGemPack->amount = round($request->amount);
        
        $newGemPack->price_taka = $request->price_taka;
        $newGemPack->discount_taka = $request->discount_taka ?? 0;

        $newGemPack->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'New Gems Pack is Created');
    }


    public function showGemPackEditForm(Request$request, $gemId)
    {
        $gemPackToUpdate = GemPack::findOrFail($gemId);
        return view('admin.other_layouts.gem_packs.edit_gem', compact('gemPackToUpdate'));
    }

    public function submitEditedGemPack(Request $request, $gemId)
    {
        $gemPackToUpdate = GemPack::findOrFail($gemId);

        $request->validate([
            'amount'=>'required|unique:gem_packs,amount,'.$gemPackToUpdate->id,
            'price_taka'=>'required|numeric|min:0',
        ]);

        $gemPackToUpdate->name = $request->name;
        $gemPackToUpdate->type = $request->type;
        $gemPackToUpdate->description = $request->description;
        
        $gemPackToUpdate->amount = round($request->amount);

        
        $gemPackToUpdate->price_taka = $request->price_taka;
        $gemPackToUpdate->discount_taka = $request->discount_taka ?? 0;

        $gemPackToUpdate->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Gems Pack is Updated');
    }

    public function gemPackDeleteMethod($gemPackId)
    {
        $gemPackToDelete = GemPack::findOrFail($gemPackId);
        $gemPackToDelete->delete();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Gems Pack is Deleted');
    }

    public function gemPackUndoMethod($gemPackId)
    {    
        $gemPackToUndo = GemPack::withTrashed()->find($gemPackId);
        $gemPackToUndo->restore();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Gem Pack is Restored');
    }
}
