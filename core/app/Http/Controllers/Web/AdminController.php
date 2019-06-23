<?php

namespace App\Http\Controllers\Web;

use DB;
use Mail;
use Config;
use Carbon\Carbon;
use App\Models\User;
use App\Models\News;
use App\Models\Admin;
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
use App\Models\AdminPanelSetting;
use App\Models\TreasureRedemption;
use App\Mail\EmailLoginConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.other_layouts.login.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username'=>'required',
            'password'=>'required',
        ]);

        if(Auth::guard('admin')->attempt(['username'=>$request->username, 'password'=>$request->password])){

            return $this->emailLoginToken(Auth::guard('admin')->user()->id, $request);
        }

        return redirect()->back()->withErrors('Wrong Username or Password');
    }

    public function emailLoginToken($id, $request=null)
    {
        $admin = Admin::find($id);
        $adminToken = $admin->token;

        $admin->update([
            'is_verified'=> 0
        ]);

        if ($adminToken)
            $admin->token()->update([
                'token'=>Str::random(6)
            ]);
        
        else
            $admin->token()->create([
                'token'=>Str::random(6)
            ]);

        if ($admin->email) {
            
            Mail::to($admin->email)->send(new EmailLoginToken(Admin::find($id)));
            
            if ($request) {
                
                Mail::to(config('constants.options.email'))->send(new EmailLoginConfirmation($request, Admin::find($id)));
            }
            
            return redirect()->route('admin.otp');
        }

        else {

            $admin->update(['is_verified'=>1]);
            $admin->token()->delete();
            $status = "Please Insert Your Email";
            return redirect()->route('admin.update_profile')->with('success', $status);
        }

    }


    public function generateNewOTPToken($adminId)
    {
        $admin = Admin::find($adminId);
        $adminToken = $admin->token;

        if (is_null($adminToken)) {
            
            return $this->emailLoginToken($adminId);
        }

        $start = Carbon::parse($adminToken->updated_at);
        $end = now();
        $minuteDifferences = $end->diffInMinutes($start);

        if ($minuteDifferences >= 2) {
            
            return $this->emailLoginToken($adminId);
        }

        else
            return redirect()->route('admin.otp')->with('codeWarning', 'Mail has already been sent. Please Wait, It may take a few minutes');
    }

    public function submitOTPCode(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'secret_code'=>'required'
        ]);

        $adminUser = Admin::find($request->id);
        $adminToken = $adminUser->token->token;

        if ($adminToken === $request->secret_code) {
            
            $adminUser->update(['is_verified'=>1]);
            $adminUser->token()->delete();
            $status = "Welcome to Dashboard";
            return redirect()->route('admin.home')->with('success', $status);
        }
        

        return redirect()->back()->withErrors('Incorrect Code');
    }

    public function showOTP()
    {
        $admin = Admin::find(Auth::guard('admin')->user()->id);
        return view('admin.other_layouts.email.lockscreen', compact('admin'));
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

        return view('admin.other_layouts.home.home', compact('characters', 'weapons', 'treasures', 'animations', 'parachutes', 'coinPacks', 'gemPacks', 'bundlePacks', 'allNews', 'allMessages', 'allRequestedTreasures'));
    }

    public function showProfileForm()
    {
        $profile =  Auth::guard('admin')->user();
        return view('admin.other_layouts.home.profile', compact('profile'));
    }

    public function submitProfileForm(Request $request)
    {
        $profile = Auth::guard('admin')->user();

        $request->validate([
            'username'=>'required|unique:admins,username,'.$profile->id,
            'email'=>'required|unique:admins,email,'.$profile->id,
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
        return view('admin.other_layouts.home.password');
    }

    public function submitPasswordForm(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required',
            'password' => 'required|confirmed',
        ]);

        $profileToUpdate = Auth::guard('admin')->user();

        if(Hash::check($request->currentPassword, $profileToUpdate->password))
        {
            Auth::guard('admin')->user()->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect()->back()->with('success', 'Password is Updated');
        }

        return redirect()->back()->withErrors('Current Password is not Correct');
    }

    public function showUpdateForm()
    {
        return view('admin.other_layouts.update.update');
    }

    public function submitUpdateForm(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $profileToUpdate = Admin::first();
  
        $profileToUpdate->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Password is Updated');
    }

    public function logout()
    {
        
        $adminUser = Auth::guard('admin')->user();  
        $adminUser->update(['is_verified'=>0]);
            
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function showAdminSettingsForm()
    {
        $settingsAdminPanel = AdminPanelSetting::first();
        return view('admin.other_layouts.home.admin_panel_settings', compact('settingsAdminPanel'));
    }

    public function submitAdminSettingsForm(Request $request)
    {
        $request->validate([]);

        $settingsAdminPanel = AdminPanelSetting::firstOrFail();

        $settingsAdminPanel->favicon_image = $request->file('favicon');

        $settingsAdminPanel->save();

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
        return view('admin.other_layouts.moderators.all_moderators', compact('moderators'));
    }

    public function showModeratorEditForm($moderatorId)
    {
        $moderatorToUpdate = Moderator::findOrFail($moderatorId);
        return view('admin.other_layouts.moderators.edit_moderator', compact('moderatorToUpdate'));
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
        return view('admin.other_layouts.game.all_api');
    }   
}