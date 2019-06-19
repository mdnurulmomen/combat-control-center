<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\SubscriptionPackage;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
   	public function showEnabledSubscriptionPackages()
    {
        $subscriptionPackages = SubscriptionPackage::with('subscriptionPackageType')->paginate(6);
        return view('admin.other_layouts.subscriptions.all_subscription_packages_enabled', compact('subscriptionPackages'));
    }

    public function showDisabledSubscriptionPackages()
    {
        $subscriptionPackages = SubscriptionPackage::onlyTrashed()->with('subscriptionPackageType')->paginate(6);
        return view('admin.other_layouts.subscriptions.all_subscription_packages_disabled', compact('subscriptionPackages'));
    }

    public function submitCreatedSubscriptionPackageForm(Request $request)
    {
        $request->validate([
            'subcription_package_type_id'=>'required',
            'offered_time'=>'required_without:offered_game'
        ]);

        $newSubscriptionPackage = new SubscriptionPackage();

        $newSubscriptionPackage->name = ucfirst($request->name) ?? 'No Name';
        $newSubscriptionPackage->subcription_package_type_id = $request->subcription_package_type_id;

        if ($request->subcription_package_type_id == 1)                         // if package type is hour 
            $newSubscriptionPackage->offered_time = $request->offered_time;

        else                                                                    // if package type is game 
            $newSubscriptionPackage->offered_game = $request->offered_game;

        $newSubscriptionPackage->save();

        return redirect()->back()->with('success', 'New Subscription Package has been Created');
    }

    public function submitSubscriptionPackageEditForm(Request $request, $subscriptionPackageId)
    {
        $request->validate([
            'subcription_package_type_id'=>'required',
            'offered_time'=>'required_without:offered_game'
        ]);

        $subscriptionPackageToUpdate = SubscriptionPackage::findOrFail($subscriptionPackageId);

        $subscriptionPackageToUpdate->name = ucfirst($request->name) ?? 'No Name';
        $subscriptionPackageToUpdate->subcription_package_type_id = $request->subcription_package_type_id;

        if ($request->subcription_package_type_id == 1) {                       // if package type is hour 

            $subscriptionPackageToUpdate->offered_time = $request->offered_time;
            $subscriptionPackageToUpdate->offered_game = 0;
        }

        else {                                                                  // if package type is game 

            $subscriptionPackageToUpdate->offered_game = $request->offered_game;
            $subscriptionPackageToUpdate->offered_time = 0;
        }
 

        $subscriptionPackageToUpdate->save();

        return redirect()->back()->with('success', 'Subscription Package has been Updated');
    }

    public function subscriptionPackageDeleteMethod($subscriptionPackageId)
    {
        $subscriptionPackageToDelete = SubscriptionPackage::find($subscriptionPackageId);
        $subscriptionPackageToDelete->delete();

        return redirect()->back()->with('success', 'Subscription Package is Deleted');
    }

    public function subscriptionPackageUndoMethod($subscriptionPackageId)
    {      
        $subscriptionPackageToUndo = SubscriptionPackage::withTrashed()->find($subscriptionPackageId);
        $subscriptionPackageToUndo->restore();

        return redirect()->back()->with('success', 'Subscription Package is Restored');
    }
}
