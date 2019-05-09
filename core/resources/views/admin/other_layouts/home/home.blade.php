
@extends('admin.master_layout.app')
@section('contents')

      <div class="row mb-4 text-center">

        <div class="col-sm-4">
          <div class="card bg-success text-white h-100">
              <div class="card-body">
                  <h6 class="text-uppercase">Earned</h6>
                  <h1 class="count">{{ $totalEarned }}</h1>
              </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="card bg-info text-white h-100">
              <div class="card-body">
                  <h6 class="text-uppercase">Players</h6>
                  <h1 class="count">{{ $totalPlayers }}</h1>
              </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="card bg-warning text-white h-100">
              <div class="card-body">
                  <h6 class="text-uppercase">Bots</h6>
                  <h1 class="count">{{ $totalBots }}</h1>
              </div>
          </div>
        </div>


      </div>

      <div class="row">
        
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.view_enabled_characters') }}">
              <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-child fa-3x"></i>
                <div class="info text-center">
                  <h5>Characters</h5>
                  <p><b>{{ $characters->count() }}</b></p>
                </div>
              </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
          <a href="{{ route('admin.view_enabled_weapons') }}">
            <div class="widget-small warning coloured-icon">
              <i class="icon fa fa-star fa-3x"></i>
              <div class="info text-center">
                <h5>Weapons</h5>
                <p><b>{{ $weapons->count() }}</b></p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-3">
          <a href="{{ route('admin.view_enabled_animations') }}">
            <div class="widget-small danger coloured-icon">
              <i class="icon fa fa-circle-o-notch fa-3x"></i>
              <div class="info text-center">
                <h5>Animations</h5>
                <p><b>{{ $animations->count() }}</b></p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-3">
          <a href="{{ route('admin.view_enabled_bundle_packs') }}">
            <div class="widget-small info coloured-icon">
              <i class="icon fa fa-files-o fa-3x"></i>
              <div class="info text-center">
                <h5>Bundles</h5>
                <p><b>{{ $bundlePacks->count() }}</b></p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-3">
          <a href="{{ route('admin.view_enabled_parachutes') }}">
            <div class="widget-small danger coloured-icon">
              <i class="icon fa fa-spinner fa-3x"></i>
              <div class="info text-center">
                <h5>Parachute</h5>
                <p><b>{{ $parachutes->count() }}</b></p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-3">
          <a href="{{ route('admin.view_enabled_coin_packs') }}">
            <div class="widget-small primary coloured-icon">
              <i class="icon fa fa-circle fa-3x"></i>
              <div class="info text-center">
                <h5>Coin Packs</h5>
                <p><b>{{ $coinPacks->count() }}</b></p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-3">
          <a href="{{ route('admin.view_enabled_gem_packs') }}">
            <div class="widget-small info coloured-icon">
              <i class="icon fa fa-diamond fa-3x"></i>
              <div class="info text-center">
                <h5>Gem Packs</h5>
                <p><b>{{ $gemPacks->count() }}</b></p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-3">
          <a href="{{ route('admin.view_enabled_treasures') }}">
            <div class="widget-small warning coloured-icon">
              <i class="icon fa fa-money fa-3x"></i>
              <div class="info text-center">
                <h5>Treasures</h5>
                <p><b>{{ $treasures->count() }}</b></p>
              </div>
            </div>
          </a>
        </div>
      </div>


      <div class="row">
        
          <div class="col-12">
            <table class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">

              <tr>
                <td>
                  <h3 class="tile-title">
                    Treasure Request
                    <a href="{{route('admin.show_treasure_requested')}}" class="badge badge-primary"> <small>{{ $allRequestedTreasures->count() }}</small></a>
                  </h3>
                </td>

                <td class="float-right">

                  <h3 class="tile-title">
                    <a href="{{route('admin.show_treasure_requested')}}" class="btn btn-info float-right" role="button">See Details</a>
                  </h3>

                </td>
              </tr>

            </table>
          </div>

      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Purchases</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Megabyte</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">News</h3>

            @foreach($allNews as $news)
              
              <p>{{$news->body}}</p>
              
            @endforeach
              
          </div>
        </div>


        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Messages</h3>

            <ul>
              @foreach($allMessages as $message)
              <li>
                <p>{{$message->title}}</p>
              </li>
              @endforeach
            </ul>
           
          </div>
        </div>

      </div>


      <!-- Page specific javascripts-->
      <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/chart.js') }}"></script> 
      <script type="text/javascript">

        @php

          $lastYearName = App\Models\Purchase::orderBy('id', 'DESC')->first()->created_at->year;

        @endphp

        var data = {

          labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],

          datasets: [
            /*
            // For Megabyte Purchase
            {
              label: "My First dataset",
              fillColor: "rgba(220,220,220,0.2)",
              strokeColor: "rgba(220,220,220,1)",
              pointColor: "rgba(220,220,220,1)",
              pointStrokeColor: "#fff",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: [65, 59, 80, 81, 56]
            },
            */

            {
              label: "My Second dataset",
              fillColor: "rgba(151,187,205,0.2)",
              strokeColor: "rgba(151,187,205,1)",
              pointColor: "rgba(151,187,205,1)",
              pointStrokeColor: "#fff",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(151,187,205,1)",
              data: 
              [

              @for($i=1; $i<13; $i++)

                {{
                  DB::table('purchases')->whereYear('created_at', $lastYearName)->whereMonth('created_at', $i)->count()
                }},

              @endfor

              ]
            }

          ]
        };

        var pdata = [
          {
            "value": 300,
            "color": "{{'#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6)}}",
            "highlight": "#5AD3D1",
            "label": "Complete"
          },

          {
            "value": 200,
            "color": "{{'#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6)}}",
            "highlight": "#5AD3D1",
            "label": "Complete"
          },

          {
            "value": 50,
            "color":"{{'#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6)}}",
            "highlight": "#FF5A5E",
            "label": "In-Progress"
          }
        ];

        var ctxl = $("#lineChartDemo").get(0).getContext("2d");
        var lineChart = new Chart(ctxl).Line(data);

        var ctxp = $("#pieChartDemo").get(0).getContext("2d");
        var pieChart = new Chart(ctxp).Pie(pdata);

    </script>

    <script type="text/javascript">
      
      $(document).ready(function() {

        var counters = $(".count");
        var countersQuantity = counters.length;
        var counter = [];

        for (i = 0; i < countersQuantity; i++) {
          counter[i] = parseInt(counters[i].innerHTML);
        }

        var count = function(start, value, id) {
          var localStart = start;
          setInterval(function() {
            if (localStart < value) {
              localStart++;
              counters[id].innerHTML = localStart;
            }
          }, 0);
        }

        for (j = 0; j < countersQuantity; j++) {
          count(0, counter[j], j);
        }

      });

    </script>
    
@stop