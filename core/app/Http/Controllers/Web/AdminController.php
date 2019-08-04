<?php

namespace App\Http\Controllers\Web;

use DB;
use Mail;
use Config;
use DataTables;
use Carbon\Carbon;
// use App\Models\User;
use App\Models\News;
use App\Models\Admin;
use App\Models\Leader;
use App\Models\Weapon;
use App\Models\Earning;
// use App\Models\Earning;
use App\Models\GemPack;
use App\Models\Message;
use App\Models\Purchase;
use App\Models\CoinPack;
use App\Models\Treasure;
use App\Models\Character;
use App\Models\Animation;
use App\Models\BoostPack;
use App\Models\Parachute;
use App\Models\BundlePack;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EmailLoginToken;
use App\Models\AdminPanelSetting;
use Spatie\Permission\Models\Role;
use App\Models\TreasureRedemption;
use App\Mail\EmailLoginConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Spatie\Permission\Models\Permission;


class AdminController extends Controller
{
    public function index()
    {
        return redirect('/admin');
    }

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

        if(Auth::guard('admin')->attempt(['username'=>$request->username, 'password'=>$request->password, 'active'=>'1' ])){

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

        $allRequestedTreasures = TreasureRedemption::where('status', 0)->orderBy('created_at', 'desc')->paginate(8);

        return view('admin.other_layouts.home.home', compact('characters', 'weapons', 'treasures', 'animations', 'parachutes', 'coinPacks', 'gemPacks', 'bundlePacks', 'allNews', 'allMessages', 'allRequestedTreasures'));
    }

    public function showTalktimeAnalytics(Request $request)
    {   
        if ($request->ajax()) {

            if ($request->talkTimeStartDate && $request->talkTimeEndDate) {

                $allTreasureRedemptions = TreasureRedemption::where('exchanging_type', 'like', '%alk%')->whereDate('updated_at', '>=', $request->talkTimeStartDate)->whereDate('updated_at', '<=', $request->talkTimeEndDate)->get();
            
            }

            else if ($request->talkTimeStartDate) {

                $allTreasureRedemptions = TreasureRedemption::where('exchanging_type', 'like', '%alk%')->whereDate('updated_at', '>=', $request->talkTimeStartDate)->get();
            
            }

            else if ($request->talkTimeEndDate) {

                $allTreasureRedemptions = TreasureRedemption::where('exchanging_type', 'like', '%alk%')->whereDate('updated_at', '<=', $request->talkTimeEndDate)->get();
            
            }

            return ['totalNumber'=>$allTreasureRedemptions->count(), 'totalCost'=>$allTreasureRedemptions->sum('equivalent_price')];

        }

        $allTreasureRedemptions = TreasureRedemption::where('exchanging_type', 'like', '%alk%')->get();
        $updatedEarning = Earning::latest()->first();

        return view('admin.other_layouts.analytics.all_analytics', compact('allTreasureRedemptions', 'updatedEarning'));
    }

    public function showEarningAnalytics(Request $request)
    {
        if ($request->ajax()) {

            if ($request->earningStartDate && $request->earningEndDate) {

                $allExpectedEarnings = Earning::whereDate('updated_at', '>=', $request->earningStartDate)->whereDate('updated_at', '<=', $request->earningEndDate)->get();

                $previousEarning = (optional(Earning::find(optional($allExpectedEarnings->first())->id - 1))->total_currency_earning ?? 0);
            
            }

            else if ($request->earningStartDate) {

                $allExpectedEarnings = Earning::whereDate('updated_at', '>=', $request->earningStartDate)->get();

                $previousEarning = Earning::find($allExpectedEarnings->first()->id - 1)->total_currency_earning ?? 0;
            
            }

            else if ($request->earningEndDate) {

                $allExpectedEarnings = Earning::whereDate('updated_at', '<=', $request->earningEndDate)->get();

                $previousEarning = Earning::find($allExpectedEarnings->first()->id - 1)->total_currency_earning ?? 0;
            
            }
            

            $totalEarning = (optional($allExpectedEarnings->last())->total_currency_earning ?? 0) - $previousEarning;

            return ['totalEarning'=>$totalEarning ?? 0];

        }
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

    public function submitCreateUserForm(Request $request)
    {
        if (auth()->user()->can('setting')) {

            $request->validate([
                'username'=>'required|unique:users,username',
                'email'=>'nullable|unique:users,email',
                'picture'=>'nullable|image',
                'role'=>'required',
                'active'=>'required',
                'picture'=>'nullable|image',
                'phone'=>'nullable|numeric',
            ]);

            $profile = new Admin();

            $profile->firstname = $request->firstname;
            $profile->lastname =  $request->lastname;
            $profile->username = $request->username;
            $profile->password = Hash::make($request->password);
            $profile->email = $request->email;
            $profile->phone = $request->phone;

            $profile->active = $request->active;
            $profile->assignRole($request->role);        

            $profile->profile_picture = $request->file('picture');

            $profile->address = $request->address;
            $profile->city = $request->city;
            $profile->country = $request->country;

            $profile->save();

            return redirect()->back()->with('success', 'New User is Created');

        }

        return redirect()->back()->withErrors('Sorry, You dont have enough permission');
    }

    public function showAllUsers(Request $request)
    {
        if ($request->ajax()) {

            return  DataTables::of(Admin::query())

                    ->setRowId(function ($user) {
                        return $user->id;
                    })

                    ->setRowClass(function ($user) {
                        return $user->id % 2 == 0 ? 'alert-success' : 'alert-warning';
                    })

                    ->setRowAttr([
                        'align' => 'center',
                    ])

                    ->addColumn('action', function(Admin $user) {

                        $button = '';

                        if(auth()->user()->can('read')){
                            
                            $button = "<i class='fa fa-fw fa-eye tooltip-test' style='transform: scale(1.5);' data-toggle='modal' data-target='#viewModal' title='View'></i>";

                            $button .= "&nbsp;&nbsp;&nbsp;";
                        }

                        if(auth()->user()->can('setting')){
                            
                            $button .= "<i class='fa fa-fw fa-edit text-success tooltip-test' style='transform: scale(1.5);' data-toggle='modal' data-target='#editModal' title='Edit'></i>";

                            $button .= "&nbsp;&nbsp;&nbsp;";
                            
                            $button .= "<i class='fa fa-fw fa-trash text-danger tooltip-test' data-toggle='modal' data-target='#deleteModal' title='Delete' style='transform: scale(1.5);' ></i>";
                        }

                        return $button;
                    })

                    ->addColumn('role', function(Admin $user) {

                        return $user->getRoleNames()->first();

                    })   

                    ->make(true);
        }

        return view('admin.other_layouts.users.all_users');
        
        /*
        $users = Admin::paginate(15);
        return view('admin.other_layouts.users.all_users', compact('users'));
        */
    }

    public function showUserEditForm($userId)
    {
        $userToUpdate = Admin::findOrFail($userId);
        return view('admin.other_layouts.users.edit_user', compact('userToUpdate'));
    }

    public function submitUserEditForm(Request $request, $userId)
    {
        if (auth()->user()->can('setting')) {
            
            $userToUpdate = Admin::findOrFail($userId);

            $request->validate([
                'username'=>'required|unique:users,username,'.$userToUpdate->id,
                'email'=>'nullable|email|unique:users,email,'.$userToUpdate->id,
                'role'=>'required',
                'active'=>'required',
                'picture'=>'nullable|image',
                'phone'=>'nullable|numeric',
            ]);

            $userToUpdate->firstname = $request->firstname;
            $userToUpdate->lastname =  $request->lastname;
            $userToUpdate->username = $request->username;
            $userToUpdate->email = $request->email;
            $userToUpdate->phone = $request->phone;

            $userToUpdate->active = $request->active;
            $userToUpdate->syncRoles($request->role);            

            $userToUpdate->profile_picture = $request->file('picture');

            $userToUpdate->address = $request->address;
            $userToUpdate->city = $request->city;
            $userToUpdate->country = $request->country;

            $userToUpdate->save();

            return redirect()->back()->with(compact('userToUpdate'))->with('success', 'Profile is Updated');
        }

        return redirect()->back()->withErrors('Sorry, You dont have enough permission');
    }

    public function userDeleteMethod($userId)
    {
        if (auth()->user()->can('setting')) {
            Admin::destroy($userId);
            return redirect()->back()->with('success', 'Profile is Deleted');
        }

        return redirect()->back()->withErrors('Sorry, You dont have enough permission');
    }

    public function showAllApi()
    {
        return view('admin.other_layouts.game.all_api');
    }   
}