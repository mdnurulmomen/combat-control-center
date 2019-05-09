<?php

namespace App\Http\Controllers\Web;

use App\Models\BundlePack;
use App\Models\BundleComponent;
use App\Http\Traits\UpdateStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BundleController extends Controller
{
    use UpdateStore;

    public function showEnabledBundlePacks()
    {
        $bundlePacks = BundlePack::paginate(6);
        return view('admin.other_layouts.bundle_packs.all_bundle_packs_enabled', compact('bundlePacks'));
    }

    public function showDisabledBundlePacks()
    {
        $bundlePacks = BundlePack::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.bundle_packs.all_bundle_packs_disabled', compact('bundlePacks'));
    }

    public function submitCreatedBundlePack(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:bundle_packs,name',

            'type'=>'required',
            'amount'=>'required',

            'discount'=>'required|numeric|min:0',

            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);

        $newBundlePack = new BundlePack();
        $newBundlePack->name = $request->name;
        $newBundlePack->type = $request->type;
        $newBundlePack->description = $request->description;

        is_null($request->discount_type) ? $request->discount_type = [] : 0;
        
        in_array('taka', $request->discount_type) ? $newBundlePack->discount_taka = $request->discount : $newBundlePack->discount_taka = 0 ;
        in_array('gems', $request->discount_type) ? $newBundlePack->discount_gems = $request->discount : $newBundlePack->discount_gems = 0 ;
        in_array('coins', $request->discount_type) ? $newBundlePack->discount_coins = $request->discount : $newBundlePack->discount_coins = 0 ;

        $newBundlePack->price_taka = $request->price_taka;
        $newBundlePack->price_gems = round($request->price_gems);
        $newBundlePack->price_coins = round($request->price_coins);
        $newBundlePack->save();

        
        for($i=0; $i < count($request->elements); $i++){

            $newBundleComponent = new BundleComponent();

            $newBundleComponent->component_type = $request->elements[$i];
            $newBundleComponent->amount = round($request->amount[$i]);
            $newBundleComponent->bundle_packs_id = $newBundlePack->id;

            $newBundleComponent->save();
        }

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'New Bundle Pack is Created');
    }

    public function showBundlePackEditForm(Request$request, $bundlePackId)
    {
        $bundlePackToUpdate = BundlePack::findOrFail($bundlePackId);
        return view('admin.other_layouts.bundle_packs.edit_bundle_pack', compact('bundlePackToUpdate'));
    }

    public function submitEditedBundlePack(Request $request, $bundlePackId)
    {
        $bundlePackToUpdate = BundlePack::findOrFail($bundlePackId);

        $request->validate([
            'name'=>'required|unique:bundle_packs,name,'.$bundlePackToUpdate->id,
            'type'=>'required',
            'amount'=>'required',

            'discount'=>'required|numeric|min:0',

            'price_taka'=>'required|numeric|min:0',
            'price_gems'=>'required|numeric|min:0',
            'price_coins'=>'required|numeric|min:0'
        ]);

        $bundlePackToUpdate->name = $request->name;
        $bundlePackToUpdate->type = $request->type;
        $bundlePackToUpdate->description = $request->description;

        is_null($request->discount_type) ? $request->discount_type = [] : 0;
        
        in_array('taka', $request->discount_type) ? $bundlePackToUpdate->discount_taka = $request->discount : $bundlePackToUpdate->discount_taka = 0 ;
        in_array('gems', $request->discount_type) ? $bundlePackToUpdate->discount_gems = $request->discount : $bundlePackToUpdate->discount_gems = 0 ;
        in_array('coins', $request->discount_type) ? $bundlePackToUpdate->discount_coins = $request->discount : $bundlePackToUpdate->discount_coins = 0 ;

        $bundlePackToUpdate->price_taka = $request->price_taka;
        $bundlePackToUpdate->price_gems = round($request->price_gems);
        $bundlePackToUpdate->price_coins = round($request->price_coins);

        $bundlePackToUpdate->save();

        // Clearing Previous Components
        $bundlePackToUpdate->bundleComponents()->delete();

        for($i=0; $i < count($request->elements); $i++){

            $newBundleComponent = new BundleComponent();

            $newBundleComponent->component_type = $request->elements[$i];
            $newBundleComponent->amount = round($request->amount[$i]);
            $newBundleComponent->bundle_packs_id = $bundlePackToUpdate->id;

            $newBundleComponent->save();
        }

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Bundle Pack is Updated');
    }

    public function bundlePackDeleteMethod($bundlePackId)
    {
        $bundlePackToDelete = BundlePack::findOrFail($bundlePackId);
        $bundlePackToDelete->bundleComponents()->delete();
        $bundlePackToDelete->delete();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Bundle Pack is Deleted');
    }

    public function bundlePackUndoMethod($bundlePackId)
    {    
        $bundlePackToUndo = BundlePack::withTrashed()->find($bundlePackId);
        $bundlePackToUndo->bundleComponents()->restore();
        $bundlePackToUndo->restore();

        $this->createStoreMethod();

        return redirect()->back()->with('success', 'Bundle Pack is Restored');
    }
}
