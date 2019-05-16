<?php

namespace App\Http\Controllers\Web;

use App\Models\RewardType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RewardController extends Controller
{
   	public function showAllEnabledRewardTypes()
    {
        $rewardTypes = RewardType::paginate(6);
        return view('admin.other_layouts.rewards.all_reward_types_enabled', compact('rewardTypes'));
    }

    public function showAllDisabledRewardTypes()
    {
        $rewardTypes = RewardType::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.rewards.all_reward_types_disabled', compact('rewardTypes'));
    }

    public function submitCreateRewardTypeForm(Request $request)
    {
        $request->validate([
            'reward_type_name'=>'required|unique:reward_types,reward_type_name'
        ]);

        $newRewardType = new RewardType();
        $newRewardType->reward_type_name = ucfirst($request->reward_type_name);
        $newRewardType->save();

        return redirect()->back()->with('success', 'New Reward Type has been Created');
    }

    public function submitRewardTypeEditForm(Request $request, $rewardTypeId)
    {
        $rewardTypeToUpdate =  RewardType::find($rewardTypeId);

        $request->validate([
            'reward_type_name'=>'required|unique:reward_types,reward_type_name,'.$rewardTypeToUpdate->id
        ]);

        $rewardTypeToUpdate->reward_type_name = ucfirst($request->reward_type_name);
        $rewardTypeToUpdate->save();

        return redirect()->back()->with('success', 'Reward Type has been Updated');
    }


    public function rewardTypeDeleteMethod($rewardTypeId)
    {
        $rewardTypeToDelete = RewardType::find($rewardTypeId);
        $rewardTypeToDelete->relatedRewards()->delete(); 
        $rewardTypeToDelete->delete();

        return redirect()->back()->with('success', 'Reward Type is Deleted');
    }

    public function rewardTypeUndoMethod($rewardTypeId)
    {
        $rewardTypeToUndo = RewardType::onlyTrashed()->find($rewardTypeId);
        $rewardTypeToUndo->relatedRewards()->restore();
        $rewardTypeToUndo->restore();

        return redirect()->back()->with('success', 'Reward Type is Restored'); 
    }






    public function showAllEnabledDailyLoginRewards()
    {
        $allLoginRewards = DailyLoginReward::with('rewardType')->paginate(6);
        return view('admin.other_layouts.rewards.all_reward_types_enabled', compact('allLoginRewards'));
    }

    public function showAllDisabledDailyLoginRewards()
    {
        $allLoginRewards = DailyLoginReward::onlyTrashed()->paginate(6);
        return view('admin.other_layouts.rewards.all_reward_types_disabled', compact('allLoginRewards'));
    }

    public function submitDailyLoginRewardCreateForm(Request $request)
    {
        $request->validate([
            'reward_type_name'=>'required|unique:reward_types,reward_type_name'
        ]);

        $newReward = new DailyLoginReward();
        $newReward->reward_type_name = ucfirst($request->reward_type_name);
        $newReward->save();

        return redirect()->back()->with('success', 'New Reward Type has been Created');
    }

    public function submitDailyLoginRewardEditForm(Request $request, $rewardTypeId)
    {
        $rewardToUpdate =  DailyLoginReward::find($rewardTypeId);

        $request->validate([
            'reward_type_name'=>'required|unique:reward_types,reward_type_name,'.$rewardToUpdate->id
        ]);

        $rewardToUpdate->reward_type_name = ucfirst($request->reward_type_name);
        $rewardToUpdate->save();

        return redirect()->back()->with('success', 'Reward Type has been Updated');
    }


    public function deleteDailyLoginReward($rewardTypeId)
    {
        $rewardToDelete = DailyLoginReward::find($rewardTypeId);
        $rewardToDelete->relatedRewards()->delete(); 
        $rewardToDelete->delete();

        return redirect()->back()->with('success', 'Reward is Deleted');
    }

    public function restoreDailyLoginReward($rewardTypeId)
    {
        $rewardToUndo = DailyLoginReward::onlyTrashed()->find($rewardTypeId);
        $rewardToUndo->relatedRewards()->restore();
        $rewardToUndo->restore();

        return redirect()->back()->with('success', 'Reward is Restored'); 
    }
}
