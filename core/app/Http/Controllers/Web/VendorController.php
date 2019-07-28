<?php

namespace App\Http\Controllers\Web;

use App\Models\City;
use App\Models\Vendor;
use App\Models\Division;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
   	public function showEnabledVendors(Request $request)
    {
        if ($request->ajax()) {
            
            if ($request->has('divisionId')) {
                
                $request->validate([
                    'divisionId'=>'required|exists:divisions,id'
                ]);

                $divisionToLoad = Division::find($request->divisionId);
                return $allRelatedCities = $divisionToLoad->cities;
            }

            if ($request->has('cityId')) {
                
                $request->validate([
                    'cityId'=>'required|exists:cities,id'
                ]);

                $cityToLoad = City::find($request->cityId);
                return $allRelatedAreas = $cityToLoad->areas;
            }

        }
        
        $vendors = Vendor::with('treasureType')->paginate(6);
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
            'area_id'=>'required',
            'city_id'=>'required',
            'division_id'=>'required',
            'mobile'=>'required|unique:vendors,mobile|regex:/(01)[0-9]{9}/',
            'treasure_type_id'=>'required|numeric'
        ]);

        $newVendor = new Vendor();

        $newVendor->name = $request->name;
        $newVendor->address = $request->address;
        $newVendor->area_id = $request->area_id;
        $newVendor->city_id = $request->city_id;
        $newVendor->division_id = $request->division_id;

        $newVendor->logo_picture = $request->file('logo');

        $newVendor->mobile = Str::start($request->mobile, '88');
        $newVendor->treasure_type_id = $request->treasure_type_id;

        $newVendor->save();

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
            'area_id'=>'required',
            'city_id'=>'required',
            'division_id'=>'required',
            'mobile'=>'required|regex:/(01)[0-9]{9}/|unique:vendors,mobile,'.$vendorToUpdate->id,
            'treasure_type_id'=>'required|numeric'
        ]);

        $vendorToUpdate->name = $request->name;
        $vendorToUpdate->address = $request->address;
        $vendorToUpdate->area_id = $request->area_id;
        $vendorToUpdate->city_id = $request->city_id;

        $vendorToUpdate->logo_picture = $request->file('logo');

        $vendorToUpdate->division_id = $request->division_id;
        $vendorToUpdate->mobile = Str::start($request->mobile, '88');
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
