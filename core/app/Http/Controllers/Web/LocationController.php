<?php

namespace App\Http\Controllers\Web;

use App\Models\City;
use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
   	public function showEnabledCities()
    {
        $cities = City::paginate(6);
        return view('admin.other_layouts.locations.all_cities_enabled', compact('cities'));
    }

    public function showDisabledCities()
    {
        $cities = City::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.locations.all_cities_disabled', compact('cities'));
    }

    public function submitCreateCityForm(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'division'=>'required',
        ]);

        $newCity = new City();
        $newCity->name = $request->name;
        $newCity->division_id = $request->division;
        $newCity->save();

        return redirect()->back()->with('success', 'New City has been Created');
    }

    public function submitCityEditForm(Request $request, $cityId)
    {
        $cityToUpdate =  City::find($cityId);

        $request->validate([
            'name'=>'required',
            'division'=>'required'
        ]);

        $cityToUpdate->name = ucfirst($request->name);
        $cityToUpdate->division_id = $request->division;
        $cityToUpdate->save();

        return redirect()->back()->with('success', 'City has been Updated');
    }


    public function cityDeleteMethod($cityId)
    {
        $cityToDelete = City::find($cityId);
        // $cityToDelete->relatedTreasures()->delete(); 
        $cityToDelete->delete();

        return redirect()->back()->with('success', 'City has been Deleted');
    }

    public function cityUndoMethod($cityId)
    {
        $cityToUndo = City::withTrashed()->find($cityId);
        // $cityToUndo->relatedTreasures()->restore();
        $cityToUndo->restore();

        return redirect()->back()->with('success', 'City has been Restored'); 
    }

    public function showEnabledAreas()
    {
        $areas = Area::paginate(6);
        return view('admin.other_layouts.locations.all_areas_enabled', compact('areas'));
    }

    public function showDisabledAreas()
    {
        $areas = Area::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.locations.all_areas_disabled', compact('areas'));
    }

    public function submitCreateAreaForm(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'city'=>'required',
        ]);

        $newCity = new Area();
        $newCity->name = $request->name;
        $newCity->city_id = $request->city;
        $newCity->save();

        return redirect()->back()->with('success', 'New Area has been Created');
    }

    public function submitAreaEditForm(Request $request, $areaId)
    {
        $cityToUpdate =  Area::find($areaId);

        $request->validate([
            'name'=>'required',
            'city'=>'required',
        ]);

        $cityToUpdate->name = ucfirst($request->name);
        $cityToUpdate->city_id = $request->city;
        $cityToUpdate->save();

        return redirect()->back()->with('success', 'Area has been Updated');
    }


    public function areaDeleteMethod($areaId)
    {
        $cityToDelete = Area::find($areaId);
        // $cityToDelete->relatedTreasures()->delete(); 
        $cityToDelete->delete();

        return redirect()->back()->with('success', 'Area has been Deleted');
    }

    public function areaUndoMethod($areaId)
    {
        $cityToUndo = Area::withTrashed()->find($areaId);
        // $cityToUndo->relatedTreasures()->restore();
        $cityToUndo->restore();

        return redirect()->back()->with('success', 'Area has been Restored'); 
    }
}
