<!DOCTYPE html>
<html lang="en">

  <head>
    
    <meta name="description" content="This is a responsive admin panel built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="Admin Panel">
    <meta property="og:site_name" content="Treasure Hunt">
    <meta property="og:title" content="Treasure Hunt Admin Panel">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>Treasure Hunt</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/admin/images/settings/favicon.png') }}" type="image/gif" sizes="16x16">

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/main.css') }}">

    <!-- Font-icon css-->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/font-awesome.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('assets/admin/css/toastr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-toggle.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/datatable/jquery.dataTables.min.css') }}">

    @stack('extraStyleLink')

    <style type="text/css">

      @section('stylebar')
      @show

    </style>

  </head>


  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="{{route('admin.home')}}"><i class="fa fa-home" aria-hidden="true"></i></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        
        <li class="app-search">
          <input class="app-search__input text-center" type="text" value="💎 {{ App\Models\Earning::latest()->first()->total_gems_earning ?? 0}}" placeholder="Search" readonly="true">
        </li>

        <!-- User Menu-->
        <li class="dropdown">
          <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">
            <i class="fa fa-user fa-lg"></i>
          </a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li>
              <a class="dropdown-item" href="{{ route('admin.update_profile') }}">
                <i class="fa fa-user fa-lg"></i> Profile
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('admin.update_password') }}">
                <i class="fa fa-cog fa-lg"></i> Change Password
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('admin.logout') }}">
                <i class="fa fa-sign-out fa-lg"></i> Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset(\Illuminate\Support\Facades\Auth::guard('admin')->user()->profile_picture) }}" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">
            {{\Illuminate\Support\Facades\Auth::guard('admin')->user()->username}}
          </p>
          <p class="app-sidebar__user-designation">Admin</p>
        </div>
      </div>
      <ul class="app-menu">

        <li>
          <a class="app-menu__item @if(Route::currentRouteName()=='admin.home') active @endif" href="{{route('admin.home')}}">
            <i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span>
          </a>
        </li>

        @if(auth()->user()->can('analytic'))

        <li>
          <a class="app-menu__item @if(Request::is('admin/analytic*')) active @endif" href="{{route('admin.show_talktime_analytics')}}">
            <i class="app-menu__icon fa fa-bar-chart"></i>
            <span class="app-menu__label">Analytics</span>
          </a>
        </li>

        @endif

        @if(auth()->user()->can('setting'))

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/settings*') || Request::is('admin/gift*') || Request::is('admin/game/*') || Request::is('admin/rules/*')) active @endif" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-gear"></i>
            <span class="app-menu__label">Settings</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            
            <li>
              <a class="treeview-item @if(Route::currentRouteName()=='admin.settings_rules') active @endif" href="{{route('admin.settings_rules')}}" rel="noopener">
                <i class="icon fa fa-circle-o"></i> Rules Settings
              </a>
            </li>

            <li>
              <a class="treeview-item @if(Route::currentRouteName()=='admin.settings_game') active @endif" href="{{route('admin.settings_game')}}">
                <i class="icon fa fa-circle-o"></i> Game Settings
              </a>
            </li>

            <li>
              <a class="treeview-item @if(Route::currentRouteName()=='admin.settings_admin_panel') active @endif" href="{{route('admin.settings_admin_panel')}}">
                <i class="icon fa fa-circle-o"></i> Admin Panel Settings
              </a>
            </li>

            <li>
              <a class="treeview-item @if(Route::currentRouteName()=='admin.setting_gift_points') active @endif" href="{{route('admin.setting_gift_points')}}" rel="noopener">
                <i class="icon fa fa-circle-o"></i> Gift Points Settings
              </a>
            </li>
            
            <li>
              <a class="treeview-item @if(Route::currentRouteName()=='admin.settings_gift_treasure') active @endif" href="{{route('admin.settings_gift_treasure')}}">
                <i class="icon fa fa-circle-o"></i> Gift Treasure Settings
              </a>
            </li>


            <li>
              <a class="treeview-item @if(Route::currentRouteName()=='admin.setting_gift_weapons') active @endif" href="{{route('admin.setting_gift_weapons')}}" rel="noopener">
                <i class="icon fa fa-circle-o"></i> Gift Weapons Settings
              </a>
            </li>
            

            <li>
              <a class="treeview-item @if(Route::currentRouteName()=='admin.setting_gift_characters') active @endif" href="{{route('admin.setting_gift_characters')}}" rel="noopener">
                <i class="icon fa fa-circle-o"></i> Gift Characters Setting
              </a>
            </li>
            
            <li>
              <a class="treeview-item @if(Route::currentRouteName()=='admin.setting_gift_parachutes') active @endif" href="{{route('admin.setting_gift_parachutes')}}" rel="noopener">
                <i class="icon fa fa-circle-o"></i> Gift Parachutes Settings
              </a>
            </li>


            <li>
              <a class="treeview-item @if(Route::currentRouteName()=='admin.settings_gift_animations') active @endif" href="{{route('admin.settings_gift_animations')}}" rel="noopener">
                <i class="icon fa fa-circle-o"></i> Gift Animations Settings
              </a>
            </li>

            <li>
              <a class="treeview-item @if(Route::currentRouteName()=='admin.settings_gift_boost_packs') active @endif" href="{{route('admin.settings_gift_boost_packs')}}" rel="noopener">
                <i class="icon fa fa-circle-o"></i> Gift Boost Packs Settings
              </a>
            </li>

          </ul>
        </li>

        @endif

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/user*')) active @endif" href="{{route('admin.view_users')}}">
            <i class="app-menu__icon fa fa-user"></i>
            <span class="app-menu__label">Login Users</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/leaderboard')) active @endif" href="{{route('admin.view_leaderboard')}}">
            <i class="app-menu__icon fa fa-user-secret"></i>
            <span class="app-menu__label">Leaderboard</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/player*')) active @endif" href="{{route('admin.view_players')}}">
            <i class="app-menu__icon fa fa-users"></i>
            <span class="app-menu__label">Players</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/image*')) active @endif" href="{{route('admin.view_images')}}">
            <i class="app-menu__icon fa fa-picture-o"></i>
            <span class="app-menu__label">Ad Images</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/black*')) active @endif" href="{{route('admin.view_black_list')}}">
            <i class="app-menu__icon fa fa-ban"></i>
            <span class="app-menu__label">Black List</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/animation*')) active @endif" href="{{route('admin.view_enabled_animations')}}">
            <i class="app-menu__icon fa fa-circle-o-notch"></i>
            <span class="app-menu__label">Animations</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/boost-pack*')) active @endif" href="{{route('admin.view_enabled_boost_packs')}}">
            <i class="app-menu__icon fa fa-rocket"></i>
            <span class="app-menu__label">Boost Packs</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/bundle-pack*')) active @endif" href="{{route('admin.view_enabled_bundle_packs')}}">
            <i class="app-menu__icon fa fa-gift"></i>
            <span class="app-menu__label">Bundle Packs</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/character*')) active @endif"  href="{{route('admin.view_enabled_characters')}}">
            <i class="app-menu__icon fa fa-child"></i>
            <span class="app-menu__label">Characters</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/coin-packs*')) active @endif" href="{{route('admin.view_enabled_coin_packs')}}">
            <i class="app-menu__icon fa fa-circle"></i>
            <span class="app-menu__label">Coin Packs</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/gem-packs*')) active @endif" href="{{route('admin.view_enabled_gem_packs')}}">
            <i class="app-menu__icon fa fa-diamond"></i>
            <span class="app-menu__label">Gem Packs</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/message*')) active @endif" href="{{route('admin.view_messages')}}">
            <i class="app-menu__icon fa fa-envelope"></i>
            <span class="app-menu__label">Message</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item @if(Request::is('admin/mission*')) active @endif" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-play"></i>
            <span class="app-menu__label">Missions</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>

          <ul class="treeview-menu">
            
              <li>
                <a class="treeview-item @if(Route::currentRouteName()=='admin.view_enabled_mission_types') active @endif"  href="{{route('admin.view_enabled_mission_types')}}" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Mission Types
                </a>
              </li>

              <li>
                <a class="treeview-item @if(Route::currentRouteName()=='admin.view_enabled_missions') active @endif"  href="{{route('admin.view_enabled_missions')}}" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Missions
                </a>
              </li>

          </ul>
        </li>


        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/news*')) active @endif" href="{{route('admin.view_news')}}">
            <i class="app-menu__icon fa fa-newspaper-o"></i>
            <span class="app-menu__label">News</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/parachute*')) active @endif" href="{{route('admin.view_enabled_parachutes')}}">
            <i class="app-menu__icon fa fa-bullseye"></i>
            <span class="app-menu__label">Parachutes</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/purchase*')) active @endif" href="{{ route('admin.view_purchase') }}">
            <i class="app-menu__icon fa fa-shopping-cart"></i>
            <span class="app-menu__label">Purchase</span>
          </a>
        </li>        

        <li class="treeview">
          <a class="app-menu__item @if(Request::is('admin/daily-login-reward*') || Request::is('admin/reward-types*')) active @endif" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-trophy"></i>
            <span class="app-menu__label">Rewards</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>

          <ul class="treeview-menu">
            
              <li>
                <a class="treeview-item  @if(Request::is('admin/reward-types*')) active @endif"  href="{{route('admin.view_enabled_reward_types')}}" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Reward Types
                </a>
              </li>

              <li>
                <a class="treeview-item  @if(Request::is('admin/daily-login-reward*')) active @endif" href="{{route('admin.view_enabled_login_rewards')}}" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Rewards
                </a>
              </li>

          </ul>
          
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/store*')) active @endif" href="{{ route('admin.create_store') }}">
            <i class="app-menu__icon fa fa-indent"></i>
            <span class="app-menu__label">Store</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item @if(Request::is('admin/subscription*')) active @endif" href="{{route('admin.view_enabled_subscription_packages')}}">
            <i class="app-menu__icon fa fa-free-code-camp"></i>
            <span class="app-menu__label">Subscriptions</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item @if(Request::is('admin/treasure*')) active @endif" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-money"></i>
            <span class="app-menu__label">Treasure</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>

          <ul class="treeview-menu">
            
              <li>
                <a class="treeview-item @if(Route::currentRouteName()=='admin.view_enabled_treasure_types') active @endif"  href="{{route('admin.view_enabled_treasure_types')}}" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Treasure Types
                </a>
              </li>

              <li>
                <a class="treeview-item @if(Route::currentRouteName()=='admin.view_enabled_treasures') active @endif"  href="{{route('admin.view_enabled_treasures')}}" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Treasures Enabled
                </a>
              </li>

              <li>
                <a class="treeview-item @if(Route::currentRouteName()=='admin.view_treasure_gifted') active @endif" data-toggle="modal" href="#modalTreasureGifted" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Treasure Gifted
                </a>
              </li>

              <li>
                <a class="treeview-item @if(Route::currentRouteName()=='admin.view_treasure_redeems') active @endif" href="{{route('admin.view_treasure_redeems')}}" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Treasure Redeems
                </a>
              </li>

              <li>
                <a class="treeview-item @if(Route::currentRouteName()=='admin.show_treasure_requested') active @endif" href="{{route('admin.show_treasure_requested')}}" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Treasure Requests
                </a>
              </li>
          </ul>
        </li>

        <li class="treeview">
          <a class="app-menu__item @if(Request::is('admin/vendor*') || Request::is('admin/area*') || Request::is('admin/citie*')) active @endif" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-industry"></i>
            <span class="app-menu__label">Vendor</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>

          <ul class="treeview-menu">
              <li>
                <a class="treeview-item @if(Route::currentRouteName()=='admin.view_enabled_areas') active @endif"  href="{{route('admin.view_enabled_areas')}}" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Areas
                </a>
              </li>

              <li>
                <a class="treeview-item @if(Route::currentRouteName()=='admin.view_enabled_cities') active @endif"  href="{{route('admin.view_enabled_cities')}}" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Cities
                </a>
              </li>

              <li>
                <a class="treeview-item @if(Request::is('admin/vendor*')) active @endif" href="{{route('admin.view_enabled_vendors')}}" rel="noopener">
                  <i class="icon fa fa-circle-o"></i> Vendors
                </a>
              </li>
          </ul>
        </li>

        <li class="treeview">
          <a class="app-menu__item @if(Request::is('admin/weapon*')) active @endif"  href="{{route('admin.view_enabled_weapons')}}">
            <i class="app-menu__icon fa fa-star"></i>
            <span class="app-menu__label">Weapons</span>
          </a>
        </li>

        <li class="treeview">
          <a class="app-menu__item  @if(Request::is('admin/api*')) active @endif" href="{{ route('admin.view_api') }}">
            <i class="app-menu__icon fa fa-exchange"></i>
            <span class="app-menu__label">API List</span>
          </a>
        </li>
      </ul>

    </aside>
    
    <main class="app-content">  
        
      <!-- Modal -->
      <div class="modal fade" id="modalTreasureGifted" role="dialog">
          <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">

                  <div class="modal-header">
                      <h4 class="modal-title">Please Set Your Requirements </h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <form method="POST" action="{{route('admin.view_treasure_gifted')}}">

                      @csrf
                      @method('POST')
                      
                      <div class="modal-body">

                        <div class="form-row">
                          

                          <div class="col-md-6 mb-4">
                            <label for="validationServer01">Select Treasure</label>

                            <select class="form-control form-control-lg is-invalid" name="treasure_id" required="true">
                              
                              <option selected="true" disabled="true">
                                  -- please select an option --
                              </option>

                              @foreach(App\Models\Treasure::all() as $treasure)
                                <option selected="true" value="{{$treasure->id}}">
                                    {{$treasure->name}}
                                </option> 
                              @endforeach

                            </select>
                          </div>

                          <div class="col-md-6 mb-4">
                            <label for="validationServer01">Choose Date</label>
                            <input type="date" name="date" class="form-control form-control-lg is-invalid" required="true">
                          </div>

                        </div>

                      </div>
                      
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Show</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                  </form>

              </div>

          </div>
      </div>

      @yield('contents')
      
    </main>

    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('assets/admin/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    <script src="{{ asset('assets/admin/js/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/admin/js/bootstrap-toggle.min.js') }}"></script>

    <script src="{{ asset('assets/admin/datatable/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('assets/admin/datatable/dataTables.bootstrap.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            @if(session()->has('success'))
            toastr.success("{{ session('success') }}", "Success")
            @endif
            @if($errors->any())
            @foreach($errors->all() as $error)
            toastr.error("{{ $error }}", "Whoops")
            @endforeach
            @endif
        });
    </script>

    @stack('scripts')
    
  </body>

</html>