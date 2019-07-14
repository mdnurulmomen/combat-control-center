<?php

namespace App\Http\Controllers\Web;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
   	public function showEnabledVendors()
    {
        $vendors = Vendor::paginate(6);
        return view('admin.other_layouts.vendors.all_vendors_enabled', compact('vendors'));
    }

    public function showDisabledVendors()
    {
        $vendors = Vendor::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.vendors.all_vendors_disabled', compact('vendors'));
    }
    
    public function submitCreateVendorForm(Request $request)
    {
        $request->validate([
            'address'=>'required',
            'area'=>'required',
            'division'=>'required',
            'mobile'=>'required|unique:vendors,mobile|regex:/(01)[0-9]{9}/',
            'treasure_type_id'=>'required|numeric'
        ]);

        $newVendor = new Vendor();

        $newVendor->name = $request->name;
        $newVendor->address = $request->address;
        $newVendor->area = $request->area;
        $newVendor->division = $request->division;
        $newVendor->mobile = $request->mobile;
        $newVendor->treasure_type_id = $request->treasure_type_id;

        $newVendor->save();

        // return $newVendor->mobile;

        return redirect()->back()->with('success', 'New Vendor has been Created');
    }

    public function showVendorEditForm(Request$request, $vendorId)
    {
        $vendorToUpdate = Vendor::findOrFail($vendorId);
        return view('admin.other_layouts.vendors.edit_vendor', compact('vendorToUpdate'));
    }

    public function submitVendorEditForm(Request $request, $vendorId)
    {
        $vendorToUpdate = Vendor::findOrFail($vendorId);

        $request->validate([
            'address'=>'required',
            'area'=>'required',
            'division'=>'required',
            'mobile'=>'required|regex:/(01)[0-9]{9}/|unique:vendors,mobile,'.$vendorToUpdate->id,
            'treasure_type_id'=>'required|numeric'
        ]);

        $vendorToUpdate->name = $request->name;
        $vendorToUpdate->address = $request->address;
        $vendorToUpdate->area = $request->area;
        $vendorToUpdate->division = $request->division;
        $vendorToUpdate->mobile = $request->mobile;
        $vendorToUpdate->treasure_type_id = $request->treasure_type_id;

        $vendorToUpdate->save();

        return redirect()->back()->with('success', 'Vendor has been Updated');
    }

    public function vendorDeleteMethod($vendorId)
    {
        $vendorToDelete = Vendor::findOrFail($vendorId);
        $vendorToDelete->delete();

        return redirect()->back()->with('success', 'Vendor is Deleted');
    }


    public function vendorUndoMethod($vendorId)
    { 
        $vendorToUndo = Vendor::withTrashed()->find($vendorId);
        $vendorToUndo->restore();

        return redirect()->back()->with('success', 'Vendor is Restored');
    }
}
