
@extends('admin.master_layout.app')
    
@section('stylebar')    
    .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
    .toggle.ios .toggle-handle { border-radius: 20px; }

    @media print {
        .btn {
            display :  none;
        }

        th:last-child {
            display :  none;
        }

        td:last-child {
            display :  none;
        }

        @page { size: auto;  margin: 0mm; }

    }

@endsection

@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left"> Treasure Requests List </h3>
                </div>

                <div class="col-6">
                    <button type="button" class="btn btn-danger float-right print" onclick="window.print()">Print</button> 
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">

                      <thead class="thead-dark">
                          <tr>
                              <th>Player Name</th>
                              <th>Treasure Name</th>
                              <th>User Mobile</th>
                              <th>Price Tk.</th>
                              <th>Selection</th>
                          </tr>
                      </thead>
                      
                      <tbody>

                          @if($allRequestedTreasures->isEmpty())
                              <tr class="danger">
                                  <td class="text-danger" colspan='5'>No Data Found</td>
                              </tr>
                          @endif
                          
                          @foreach($allRequestedTreasures as $requestedTreasure)
                              
                              <tr>
                                  <td>{{ $requestedTreasure->player->user->username ?? 'No Name'}}</td>
                                  <td>{{ $requestedTreasure->treasure->name }}</td>
                                  <td>{{ $requestedTreasure->player_phone ?? 'NA'}}</td>
                                  <td>{{ $requestedTreasure->equivalent_price ?? '0 tk' }}</td>

                                  <td>

                                      <input type="checkbox" class="requestedTreasure" id="{{$requestedTreasure->id}}" data-playerPhone="{{$requestedTreasure->player_phone}}" data-rechargeAmount="{{$requestedTreasure->equivalent_price}}" data-toggle="toggle" data-on="Marked" data-off="Not Marked" data-onstyle="success" data-offstyle="danger" data-style="ios">

                                  </td>
                              </tr>

                          @endforeach

                          <tr>
                              <td colspan="5">
                                  <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#confirmRequestedNumbers">
                                    Send
                                  </button>
                              </td>
                          </tr>

                      </tbody>
                      
                    </table>


                  <div class="float-right">
                      {{ $allRequestedTreasures->onEachSide(5)->links() }}
                  </div>

                </div>
            </div>



          <!--confirmRequestedNumbers Modal -->
          <div class="modal fade" id="confirmRequestedNumbers" role="dialog">
              <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title">Confirmation</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <form method="POST" action="{{ route('admin.confirm_treasure_requested') }}">

                          @method('POST')
                          @csrf

                          <div class="modal-body">
                              
                              <span id="bodyForm"></span>

                          </div>

                          <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Confirmed</button>
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          </div>

                      </form>

                  </div>

              </div>
          </div> 


        </div>

    </div>

@stop

@push('scripts')
    
    <script type="text/javascript">

      /*$( "select.requestedTreasure" ).change(function() {

        var array = [];

        $( "select.requestedTreasure option:selected" ).each(function() {
          
          array.push($( this ).val());

        });

        alert(array);

      });*/


      $( ":checkbox.requestedTreasure" ).change( function(){

        /*if ($(this.checked)) {

          // alert($(this).serialize());
        }*/

        $('#bodyForm').empty();

        $("input[type=checkbox].requestedTreasure:checked").each(

          function(){

            var id = $(this).attr('id');
            var playerPhone = $(this).attr('data-playerPhone');
            var rechargeAmount = $(this).attr('data-rechargeAmount');
            
            // console.log(rechargeAmount);
            // array.push($( this ).val());

            var html =  "<div class='form-row'>"+

                            "<input type='hidden' name= id[] value="+id+">"
                            +
                            "<div class='col-md-6 mb-4'>"+
                                "<label for='validationServerUsername'>Number</label>"+
                                "<div class='input-group'>"+
                                    "<input type='text' name='player_phone[]' value="+playerPhone+" class='form-control form-control-lg is-invalid' aria-describedby='inputGroupPrepend3' readonly='true'>"+
                                "</div>"+
                            "</div>"
                            +
                            "<div class='col-md-6 mb-4'>"+
                                "<label for='validationServer01'>Recharge Amount</label>"+
                                "<div class='input-group'>"+
                                    "<input type='number' name='recharge_amount[]' value="+rechargeAmount+" class='form-control form-control-lg is-invalid' aria-describedby='inputGroupPrepend3' readonly='true'>"+
                                "</div>"+
                            "</div>"
                            +
                        "</div>";

            $("#bodyForm").append(html);

          }
        );

        

      });

    </script>

@endpush