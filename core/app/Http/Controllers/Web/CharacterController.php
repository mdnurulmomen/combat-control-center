<?php

namespace App\Http\Controllers\Web;

use DataTables;
use App\Models\Character;
use App\Http\Traits\UpdateStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CharacterController extends Controller
{
    use UpdateStore;

    public function showEnabledCharacters(Request $request)
    {
        if($request->ajax()){

            return DataTables::of(Character::query())

                    ->addColumn('action', function(){

                        $button = "<i class='fa fa-fw fa-eye' style='transform: scale(1.5);' title='View'></i>";

                        $button .= "&nbsp;&nbsp;&nbsp;";

                        $button .=  "<i class='fa fa-fw fa-edit' style='transform: scale(1.5);' title='Edit'></i>";

                        $button .= "&nbsp;&nbsp;&nbsp;";

                        $button .= "<i class='fa fa-fw fa-trash text-danger' style='transform: scale(1.5);' title='Delete'></i>";

                        return $button;

                    })

                    ->setRowId(function (Character $character) {
                        return $character->id;
                    })

                    ->setRowClass(function (Character $character) {
                        return $character->id % 2 == 0 ? 'alert-success' : 'alert-warning';
                    })

                    ->setRowAttr([
                        'align' => 'center',
                    ])
                    
                    ->make(true);
        }

        return view('admin.other_layouts.characters.all_characters_enabled');

        /*
        $characters = Character::paginate(6);
        return view('admin.other_layouts.characters.all_characters_enabled', compact('characters'));
        */
    }

    public function showDisabledCharacters()
    {
        $characters = Character::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.characters.all_characters_disabled', compact('characters'));
    }
    
    public function submitCreateCharacterForm(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:characters,name',

            'discount'=>'required|numeric|min:0',

            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);
        
        $newCharacter = new Character();
        
        $newCharacter->name = $request->name;
        $newCharacter->type = $request->type;
        $newCharacter->description = $request->description;

        is_null($request->discount_type) ? $request->discount_type = [] : 0;

        in_array('taka', $request->discount_type) ? $newCharacter->discount_taka = $request->discount : $newCharacter->discount_taka = 0 ;
        in_array('gems', $request->discount_type) ? $newCharacter->discount_gems = $request->discount : $newCharacter->discount_gems = 0 ;
        in_array('coins', $request->discount_type) ? $newCharacter->discount_coins = $request->discount : $newCharacter->discount_coins = 0 ;

        $newCharacter->price_taka = $request->price_taka;
        $newCharacter->price_gems = round($request->price_gems);
        $newCharacter->price_coins = round($request->price_coins);

        $newCharacter->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'New Character is Created');
    }

    public function submitCharacterEditForm(Request $request, $characterId)
    {
        $characterToUpdate = Character::findOrFail($characterId);

        $request->validate([
            'name'=>'required|unique:characters,name,'.$characterToUpdate->id,
            
            'discount'=>'required|numeric|min:0',

            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);


        $characterToUpdate->name = $request->name;
        $characterToUpdate->type = $request->type;
        $characterToUpdate->description = $request->description;

        is_null($request->discount_type) ? $request->discount_type = [] : 0;

        in_array('taka', $request->discount_type) ? $characterToUpdate->discount_taka = $request->discount : $characterToUpdate->discount_taka = 0 ;
        in_array('gems', $request->discount_type) ? $characterToUpdate->discount_gems = $request->discount : $characterToUpdate->discount_gems = 0 ;
        in_array('coins', $request->discount_type) ? $characterToUpdate->discount_coins = $request->discount : $characterToUpdate->discount_coins = 0 ;


        $characterToUpdate->price_taka = $request->price_taka;
        $characterToUpdate->price_gems = round($request->price_gems);
        $characterToUpdate->price_coins = round($request->price_coins);

        $characterToUpdate->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Character has been Updated');
    }

    public function characterDeleteMethod($characterId)
    {
        $characterToDelete = Character::findOrFail($characterId);
        $characterToDelete->delete();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Character is Deleted');
    }
    
    public function characterUndoMethod($characterId)
    {     
        $characterToUndo = Character::withTrashed()->find($characterId);
        $characterToUndo->restore();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Character is Restored');
    }
}
