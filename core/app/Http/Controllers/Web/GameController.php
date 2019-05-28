<?php

namespace App\Http\Controllers\Web;

use App\Models\GameSetting;
use App\Models\UserSetting;
use App\Models\PlayHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function showGameSettingsForm()
    {
        $settingsGame = GameSetting::first();
        return view('admin.other_layouts.game.game_settings', compact('settingsGame'));
    }

    public function submitGameSettingsForm(Request $request)
    {
        $request->validate([
            'game_version_required'=>'required',
            'rate'=>'required',
        ]);

        $settingsGame = GameSetting::firstOrFail();

        $settingsGame->game_version_required = $request->game_version_required;
        $settingsGame->game_version_optional = $request->game_version_optional;
        $settingsGame->game_rate = $request->rate;
        
        $request->maintainance_mode == 'on' ? $settingsGame->maintainance_mode = true : $settingsGame->maintainance_mode = false;
        $settingsGame->maintainance_start_time = $request->maintainance_start_time;
        $settingsGame->maintainance_end_time = $request->maintainance_end_time;
        
        $settingsGame->save();

        return redirect()->back()->with('success', 'Settings are Updated');
    }

    public function showRulesSettingsForm()
    {
        $settingsUser = UserSetting::firstOrFail();
        return view('admin.other_layouts.game.rules_settings', compact('settingsUser'));
    }

    public function submitRulesSettingsForm(Request $request)
    {
        $request->validate([]);

        $settingsUser = UserSetting::firstOrFail();

        $request->user_registration == 'on' ? $settingsUser->user_registration = 1 : $settingsUser->user_registration = 0;
        $request->email_verification == 'on' ? $settingsUser->email_verification = 1 : $settingsUser->email_verification = 0;
        $request->sms_verification == 'on' ? $settingsUser->sms_verification = 1 : $settingsUser->sms_verification = 0;

        $settingsUser->save();

        return redirect()->back()->with('success', 'Rules are Updated');
    }
}
