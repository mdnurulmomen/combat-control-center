<?php

namespace App\Http\Controllers\Web;

use App\Models\Parachute;
use App\Http\Traits\UpdateStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParachuteController extends Controller
{
    use UpdateStore;
    
    public function showEnabledParachutes()
    {
        $parachutes = Parachute::paginate(6);
        return view('admin.other_layouts.parachutes.all_parachutes_enabled', compact('parachutes'));
    }

    public function showDisabledParachutes()
    {
        $parachutes = Parachute::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.parachutes.all_parachutes_disabled', compact('parachutes'));
    }
    
    public function submitCreateParachuteForm(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:parachutes,name',
            
            'discount'=>'required|numeric|min:0',

            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);

        $newParachute = new Parachute();

        $newParachute->name = $request->name;
        $newParachute->type = $request->type;
        $newParachute->description = $request->description;
     
        is_null($request->discount_type) ? $request->discount_type = [] : 0;
           
        in_array('taka', $request->discount_type) ? $newParachute->discount_taka = $request->discount : $newParachute->discount_taka = 0 ;

        in_array('gems', $request->discount_type) ? $newParachute->discount_gems = $request->discount : $newParachute->discount_gems = 0 ;

        in_array('coins', $request->discount_type) ? $newParachute->discount_coins = $request->discount : $newParachute->discount_coins = 0 ;

        $newParachute->price_taka = $request->price_taka;
        $newParachute->price_gems = round($request->price_gems);
        $newParachute->price_coins = round($request->price_coins);

        $newParachute->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'New Parachute has been Created');
    }

    public function showParachuteEditForm(Request$request, $parachuteId)
    {
        $parachuteToUpdate = Parachute::findOrFail($parachuteId);
        return view('admin.other_layouts.parachutes.edit_parachute', compact('parachuteToUpdate'));
    }

    public function submitParachuteEditForm(Request $request, $parachuteId)
    {
        $parachuteToUpdate = Parachute::findOrFail($parachuteId);

        $request->validate([
            'name'=>'required|unique:parachutes,name,'.$parachuteToUpdate->id,
            
            'discount'=>'required|numeric|min:0',
            
            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);


        $parachuteToUpdate->name = $request->name;
        $parachuteToUpdate->type = $request->type;
        $parachuteToUpdate->description = $request->description;

        is_null($request->discount_type) ? $request->discount_type = [] : 0;
        
        in_array('taka', $request->discount_type) ? $parachuteToUpdate->discount_taka = $request->discount : $parachuteToUpdate->discount_taka = 0 ;

        in_array('gems', $request->discount_type) ? $parachuteToUpdate->discount_gems = $request->discount : $parachuteToUpdate->discount_gems = 0 ;

        in_array('coins', $request->discount_type) ? $parachuteToUpdate->discount_coins = $request->discount : $parachuteToUpdate->discount_coins = 0 ;

        $parachuteToUpdate->price_taka = $request->price_taka;
        $parachuteToUpdate->price_gems = round($request->price_gems);
        $parachuteToUpdate->price_coins = round($request->price_coins);

        $parachuteToUpdate->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Parachute has been Updated');
    }


    public function parachuteDeleteMethod($parachuteId)
    {
        $parachuteIdToDelete = Parachute::findOrFail($parachuteId);
        $parachuteIdToDelete->delete();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Parachute is Deleted');
    }

    public function parachuteUndoMethod($parachuteId)
    {    
        $parachuteToUndo = Parachute::withTrashed()->find($parachuteId);
        $parachuteToUndo->restore();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Parachute is Restored');
    }
}
