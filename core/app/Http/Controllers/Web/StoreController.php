<?php

namespace App\Http\Controllers\Web;

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
        $storeAll = Store::paginate(8);
        
        return view('admin.other_layouts.store.view_store')->with('storeAll', $storeAll);
    }


    public function viewAllPurchases()
    {
      $allPurchases = Purchase::paginate(10);
      return view('admin.other_layouts.store.view_purchases', compact('allPurchases'));
    }
}
