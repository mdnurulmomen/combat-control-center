<?php

namespace App\Http\Controllers\Web;

use App\Models\Animation;
use App\Http\Traits\UpdateStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AnimationController extends Controller
{
    use UpdateStore;

    public function showEnabledanimations()
    {
        $animations = Animation::paginate(6);
        return view('admin.other_layouts.animations.all_animations_enabled', compact('animations'));
    }

    public function showDisabledanimations()
    {
        $animations = Animation::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.animations.all_animations_disabled', compact('animations'));
    }

    public function submitCreateAnimationForm(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:animations,name',

            'discount'=>'required|numeric|min:0',

            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);

        $newAnimation = new Animation();

        $newAnimation->name = $request->name;
        $newAnimation->type = $request->type;
        $newAnimation->description = $request->description;
    
        is_null($request->discount_type) ? $request->discount_type = [] : 0;
            
        in_array('taka', $request->discount_type) ? $newAnimation->discount_taka = $request->discount : $newAnimation->discount_taka = 0 ;
        in_array('gems', $request->discount_type) ? $newAnimation->discount_gems = $request->discount : $newAnimation->discount_gems = 0 ;
        in_array('coins', $request->discount_type) ? $newAnimation->discount_coins = $request->discount : $newAnimation->discount_coins = 0 ;

        $newAnimation->price_taka = $request->price_taka;
        $newAnimation->price_gems = round($request->price_gems);
        $newAnimation->price_coins = round($request->price_coins);

        $newAnimation->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'New Animation has been Created');
    }

    public function submitAnimationEditForm(Request $request, $animationId)
    {
        $animationToUpdate = Animation::findOrFail($animationId);

        $request->validate([
            'name'=>'required|unique:animations,name,'.$animationToUpdate->id,
            
            'discount'=>'required|numeric|min:0',

            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);


        $animationToUpdate->name = $request->name;
        $animationToUpdate->type = $request->type;
        $animationToUpdate->description = $request->description;

        is_null($request->discount_type) ? $request->discount_type = [] : 0;
        
        in_array('taka', $request->discount_type) ? $animationToUpdate->discount_taka = $request->discount : $animationToUpdate->discount_taka = 0 ;
        in_array('gems', $request->discount_type) ? $animationToUpdate->discount_gems = $request->discount : $animationToUpdate->discount_gems = 0 ;
        in_array('coins', $request->discount_type) ? $animationToUpdate->discount_coins = $request->discount : $animationToUpdate->discount_coins = 0 ;

        $animationToUpdate->price_taka = $request->price_taka;
        $animationToUpdate->price_gems = round($request->price_gems);
        $animationToUpdate->price_coins = round($request->price_coins);

        $animationToUpdate->save();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Animation has been Updated');
    }

    public function animationDeleteMethod($animationId)
    {
        $animationToDelete = Animation::findOrFail($animationId);
        $animationToDelete->delete();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Animation is Deleted');
    }


    public function animationUndoMethod($animationId)
    {    
        $animationToUndo = Animation::withTrashed()->find($animationId);
        $animationToUndo->restore();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Animation is Restored');
    }
}
