
@extends('admin.master_layout.app')

@section('stylebar')

  .widget-small:hover{
    -ms-transform: scale(1.10); /* IE 9 */
    -webkit-transform: scale(1.10); /* Safari 3-8 */
    transform: scale(1.10); 
  }

@endsection

@section('contents')

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
              <i class="icon fa fa-gift fa-3x"></i>
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
              <i class="icon fa fa-bullseye fa-3x"></i>
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
                    <a href="{{route('admin.show_treasure_requested')}}" class="badge badge-info ml-2"> <small>{{ $allRequestedTreasures->count() }}</small></a>
                  </h3>
                </td>

                <td class="float-right">
                  <h3 class="tile-title">
                    <a href="{{route('admin.show_treasure_requested')}}" class="btn btn-info btn-sm float-right" role="button">
                      <i class="fa fa-link"></i>
                      See Details
                    </a>
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
              <canvas class="embed-responsive-item" id="countPurchase"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Megabyte & Talktime</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="countMegabyteAndTalktime"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Earning</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="countEarning"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Physical Treasure</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="countPhysicalTreasure"></canvas>
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
    
@stop

@push('scripts')
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/chart.js') }}"></script> 
    <script type="text/javascript">

      @php

        $lastPurchase = optional(optional(App\Models\Purchase::latest()->first())->created_at);

        $lastYearNumber = $lastPurchase->year;
        $lastMonthNumber = $lastPurchase->month;

      @endphp

      var countPurchase = {

        labels: [

          @for($i=($lastMonthNumber-5); $i<=$lastMonthNumber; $i++)

            '{{ date("F", mktime(0, 0, 0, $i, 1)) }}',

          @endfor

        ],

        datasets: [

          {
            label: "Total Purchase Counter",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: 
            [

            @for($i=($lastMonthNumber-5); $i<=$lastMonthNumber; $i++)

              {{
                DB::table('purchases')->whereYear('created_at', $lastYearNumber)->whereMonth('created_at', $i)->count()
              }},

            @endfor

            ]
          }

        ]
      };


      var countMegabyteAndTalktime = {

        labels: [

          @for($i=($lastMonthNumber-5); $i<=$lastMonthNumber; $i++)

            '{{ date("F", mktime(0, 0, 0, $i, 1)) }}',

          @endfor

        ],

        datasets: [

          {
            label: "Megabyte Counter",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            
            data: 
            [

            @for($i=($lastMonthNumber-5); $i<=$lastMonthNumber; $i++)

              {{
                DB::table('treasure_redemptions')->where('exchanging_type', 'MB')->whereYear('created_at', $lastYearNumber)->whereMonth('created_at', $i)->count()
              }},

            @endfor

            ]
          },

          {
            label: "Talktime Counter",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            
            data: 
            [

            @for($i=($lastMonthNumber-5); $i<=$lastMonthNumber; $i++)

              {{
                DB::table('treasure_redemptions')->where('exchanging_type', 'like', '%alk%')->whereYear('created_at', $lastYearNumber)->whereMonth('created_at', $i)->count()
              }},

            @endfor

            ]
          },

        ]
      };

      var countPhysicalTreasure = [

        @for($i=($lastMonthNumber-5); $i<=$lastMonthNumber; $i++)

          {
            "value": 
                  {{ DB::table('treasure_redemptions')->where('exchanging_type', 'Burger')->whereYear('created_at', $lastYearNumber)->whereMonth('created_at', $i)->count() }},

            "color": "{{'#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6)}}",
            "highlight": "#5AD3D1",
            "label": '{{ date("F", mktime(0, 0, 0, $i, 1)) }}'
          },

        @endfor

      ];

      var countEarning = [

        @for($i=($lastMonthNumber-5); $i<=$lastMonthNumber; $i++)

          {
            "value": 
                  {{ (optional(App\Models\Earning::whereYear('created_at', $lastYearNumber)->whereMonth('created_at', $i)->latest()->first())->total_currency_earning ?? 0) - (optional(App\Models\Earning::whereYear('created_at', $lastYearNumber)->whereMonth('created_at', ($i-1))->latest()->first())->total_currency_earning ?? 0) }},

            "color": "{{'#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6)}}",
            "highlight": "#5AD3D1",
            "label": '{{ date("F", mktime(0, 0, 0, $i, 1)) }}'
          },

        @endfor

      ];

      var ctxl = $("#countPurchase").get(0).getContext("2d");
      var countPurchase = new Chart(ctxl).Line(countPurchase);

      var ctxb = $("#countMegabyteAndTalktime").get(0).getContext("2d");
      var countMegabyteAndTalktime = new Chart(ctxb).Bar(countMegabyteAndTalktime);

      var ctxp = $("#countPhysicalTreasure").get(0).getContext("2d");
      var countPhysicalTreasure = new Chart(ctxp).Pie(countPhysicalTreasure);

      var ctxd = $("#countEarning").get(0).getContext("2d");
      var countEarning = new Chart(ctxd).Doughnut(countEarning);

  </script>

  {{-- <script type="text/javascript">
    
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

  </script> --}}

@endpush