<?php

namespace App\Http\Controllers\Web;

use DataTables;
use App\Models\Store;
use App\Models\Purchase;
use App\Http\Traits\UpdateStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    use UpdateStore;

    public function showStoreMethod()
    {
        $this->createStoreMethod();
        $storeAll = Store::with('bundleComponents')->paginate(8);
        
        return view('admin.other_layouts.store.view_store')->with('storeAll', $storeAll);
    }


    public function viewAllPurchases(Request $request)
    {
      if ($request->ajax()) {

            $model = Purchase::query();

            return  DataTables::eloquent($model)

                    ->setRowId(function (Purchase $purchase) {
                        return $purchase->id;
                    })

                    ->setRowClass(function (Purchase $purchase) {
                        return $purchase->id % 2 == 0 ? 'alert-success' : 'alert-warning';
                    })

                    ->setRowAttr([
                        'align' => 'center',
                    ])
                    
                    ->make(true);
        }

        return view('admin.other_layouts.store.view_purchases');

        /*
        $allPurchases = Purchase::paginate(10);
        return view('admin.other_layouts.store.view_purchases', compact('allPurchases'));
        */
    }
}
