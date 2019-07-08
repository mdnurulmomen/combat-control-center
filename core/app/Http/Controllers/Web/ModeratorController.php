<?php

namespace App\Http\Controllers\Web;

use DB;
use Mail;
use Config;
use Carbon\Carbon;
use App\Models\User;
use App\Models\News;
use App\Models\Moderator;
use App\Models\Leader;
use App\Models\Weapon;
use App\Models\Earning;
use App\Models\GemPack;
use App\Models\Message;
use App\Models\CoinPack;
use App\Models\Treasure;
use App\Models\Character;
use App\Models\Animation;
use App\Models\Moderator;
use App\Models\BoostPack;
use App\Models\Parachute;
use App\Models\BundlePack;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EmailLoginToken;
use App\Models\ModeratorPanelSetting;
use App\Models\TreasureRedemption;
use App\Mail\EmailLoginConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ModeratorController extends Controller
{
   	public function showLoginForm()
    {
        return view('moderator.other_layouts.login.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username'=>'required',
            'password'=>'required',
        ]);

        if(Auth::guard('moderator')->attempt(['username'=>$request->username, 'password'=>$request->password, 'active'=>true])){

            return $this->emailLoginToken(Auth::guard('moderator')->user()->id, $request);
        }

        return redirect()->back()->withErrors('Wrong Username or Password');
    }

    public function emailLoginToken($id, $request=null)
    {
        $moderator = Moderator::find($id);
        $moderatorToken = $moderator->token;

        $moderator->update([
            'is_verified'=> 0
        ]);

        if ($moderatorToken)
            $moderator->token()->update([
                'token'=>Str::random(6)
            ]);
        
        else
            $moderator->token()->create([
                'token'=>Str::random(6)
            ]);

        if ($moderator->email) {
            
            Mail::to($moderator->email)->send(new EmailLoginToken(Moderator::find($id)));
            
            if ($request) {
                
                Mail::to(config('constants.options.email'))->send(new EmailLoginConfirmation($request, Moderator::find($id)));
            }
            
            return redirect()->route('moderator.otp');
        }

        else {

            $moderator->update(['is_verified'=>1]);
            $moderator->token()->delete();
            $status = "Please Insert Your Email";
            return redirect()->route('moderator.update_profile')->with('success', $status);
        }

    }


    public function generateNewOTPToken($moderatorId)
    {
        $moderator = Moderator::find($moderatorId);
        $moderatorToken = $moderator->token;

        if (is_null($moderatorToken)) {
            
            return $this->emailLoginToken($moderatorId);
        }

        $start = Carbon::parse($moderatorToken->updated_at);
        $end = now();
        $minuteDifferences = $end->diffInMinutes($start);

        if ($minuteDifferences >= 2) {
            
            return $this->emailLoginToken($moderatorId);
        }

        else
            return redirect()->route('moderator.otp')->with('codeWarning', 'Mail has already been sent. Please Wait, It may take a few minutes');
    }

    public function submitOTPCode(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'secret_code'=>'required'
        ]);

        $moderatorUser = Moderator::find($request->id);
        $moderatorToken = $moderatorUser->token->token;

        if ($moderatorToken === $request->secret_code) {
            
            $moderatorUser->update(['is_verified'=>1]);
            $moderatorUser->token()->delete();
            $status = "Welcome to Dashboard";
            return redirect()->route('moderator.home')->with('success', $status);
        }
        

        return redirect()->back()->withErrors('Incorrect Code');
    }

    public function showOTP()
    {
        $moderator = Moderator::find(Auth::guard('moderator')->user()->id);
        return view('moderator.other_layouts.email.lockscreen', compact('moderator'));
    }

    public function homeMethod()
    {
        $allNews = News::all();
        $weapons = Weapon::all();
        $gemPacks = GemPack::all();
        $coinPacks = CoinPack::all();
        $treasures = Treasure::all();
        $allMessages = Message::all();
        $characters = Character::all();
        $animations = Animation::all();
        $parachutes = Parachute::all();
        $bundlePacks = BundlePack::all();

        // $totalBots = User::where('type', 'bot')->count();
        // $totalPlayers = User::where('type', 'player')->count();
        // $totalEarned = optional(Earning::orderBy('total_earning', 'DESC')->first())->total_earning;

        $allRequestedTreasures = TreasureRedemption::where('status', 0)->orderBy('created_at', 'desc')->paginate(8);

        return view('moderator.other_layouts.home.home', compact('characters', 'weapons', 'treasures', 'animations', 'parachutes', 'coinPacks', 'gemPacks', 'bundlePacks', 'allNews', 'allMessages', 'allRequestedTreasures'));
    }

    public function showProfileForm()
    {
        $profile =  Auth::guard('moderator')->user();
        return view('moderator.other_layouts.home.profile', compact('profile'));
    }

    public function submitProfileForm(Request $request)
    {
        $profile = Auth::guard('moderator')->user();

        $request->validate([
            'username'=>'required|unique:moderators,username,'.$profile->id,
            'email'=>'required|unique:moderators,email,'.$profile->id,
            'picture'=>'image',
        ]);

        $profile->firstname = $request->firstname;
        $profile->lastname =  $request->lastname;
        $profile->username = $request->username;
        $profile->email = $request->email;
        $profile->phone = $request->phone;

        $profile->profile_picture = $request->file('picture');

        $profile->address = $request->address;
        $profile->city = $request->city;
        $profile->country = $request->country;

        $profile->save();

        return redirect()->back()->with(compact('profile'))->with('success', 'Profile Successfully Updated');
    }

    public function showPasswordForm()
    {
        return view('moderator.other_layouts.home.password');
    }

    public function submitPasswordForm(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required',
            'password' => 'required|confirmed',
        ]);

        $profileToUpdate = Auth::guard('moderator')->user();

        if(Hash::check($request->currentPassword, $profileToUpdate->password))
        {
            Auth::guard('moderator')->user()->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect()->back()->with('success', 'Password is Updated');
        }

        return redirect()->back()->withErrors('Current Password is not Correct');
    }

    public function showUpdateForm()
    {
        return view('moderator.other_layouts.update.update');
    }

    public function submitUpdateForm(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $profileToUpdate = Moderator::first();
  
        $profileToUpdate->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Password is Updated');
    }

    public function logout()
    {
        
        $moderatorUser = Auth::guard('moderator')->user();  
        $moderatorUser->update(['is_verified'=>0]);
            
        Auth::guard('moderator')->logout();
        return redirect()->route('moderator.login');
    }

    public function showModeratorSettingsForm()
    {
        $settingsModeratorPanel = ModeratorPanelSetting::first();
        return view('moderator.other_layouts.home.moderator_panel_settings', compact('settingsModeratorPanel'));
    }

    public function submitModeratorSettingsForm(Request $request)
    {
        $request->validate([]);

        $settingsModeratorPanel = ModeratorPanelSetting::firstOrFail();

        $settingsModeratorPanel->favicon_image = $request->file('favicon');

        $settingsModeratorPanel->save();

        return redirect()->back()->with('success', 'Settings are Updated');
    }

    public function submitCreateModeratorForm(Request $request)
    {
        $request->validate([
            'username'=>'required|unique:moderators,username',
            'email'=>'nullable|unique:moderators,email',
            'picture'=>'nullable|image'
        ]);

        $profile = new Moderator();

        $profile->firstname = $request->firstname;
        $profile->lastname =  $request->lastname;
        $profile->username = $request->username;
        $profile->password = Hash::make($request->password);
        $profile->email = $request->email;
        $profile->phone = $request->phone;

        $profile->profile_picture = $request->file('picture');

        $profile->address = $request->address;
        $profile->city = $request->city;
        $profile->country = $request->country;

        $profile->save();

        return redirect()->back()->with('success', 'New Moderator is Created');
    }

    public function showAllModerators()
    {
        $moderators = Moderator::paginate(15);
        return view('moderator.other_layouts.moderators.all_moderators', compact('moderators'));
    }

    public function showModeratorEditForm($moderatorId)
    {
        $moderatorToUpdate = Moderator::findOrFail($moderatorId);
        return view('moderator.other_layouts.moderators.edit_moderator', compact('moderatorToUpdate'));
    }

    public function submitModeratorEditForm(Request $request, $moderatorId)
    {
        $moderatorToUpdate = Moderator::findOrFail($moderatorId);

        $request->validate([
            'username'=>'required|unique:moderators,username,'.$moderatorToUpdate->id,
            'email'=>'nullable|email|unique:moderators,email,'.$moderatorToUpdate->id,
            'picture'=>'nullable|image',
            'phone'=>'nullable|numeric',
        ]);

        $moderatorToUpdate->firstname = $request->firstname;
        $moderatorToUpdate->lastname =  $request->lastname;
        $moderatorToUpdate->username = $request->username;
        $moderatorToUpdate->email = $request->email;
        $moderatorToUpdate->phone = $request->phone;

        $moderatorToUpdate->profile_picture = $request->file('picture');

        $moderatorToUpdate->address = $request->address;
        $moderatorToUpdate->city = $request->city;
        $moderatorToUpdate->country = $request->country;

        $moderatorToUpdate->save();

        return redirect()->back()->with(compact('moderatorToUpdate'))->with('success', 'Profile is Updated');
    }

    public function moderatorDeleteMethod($moderatorId)
    {
        Moderator::destroy($moderatorId);
        return redirect()->back()->with('success', 'Profile is Deleted');
    }

    public function showAllApi()
    {
        return view('moderator.other_layouts.game.all_api');
    }
}
