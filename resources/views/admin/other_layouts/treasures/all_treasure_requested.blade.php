
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

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%" id="treaserRequestsTable">

                      <thead class="thead-dark">
                          <tr>
                              <th>Player Name</th>
                              <th>Treasure Name</th>
                              <th>User Mobile</th>
                              <th>Price Tk.</th>
                              <th>Selection</th>
                          </tr>
                      </thead>
                      
                  
                    </table>

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

      $(function() {

        $('#treaserRequestsTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('admin.show_treasure_requested') }}",
          columns: [
              { data: 'player.user.username', name: 'player.user.username' },
              { data: 'treasure.name', name: 'treasure.name' },
              { data: 'player_phone', name: 'player_phone' },
              { data: 'equivalent_price', name: 'equivalent_price' },
              { data: 'selection', name: 'selection', orderable : false, searchable : false }
          ]
        });

        $('#treaserRequestsTable').on( 'draw.dt', function () {

          $('#treaserRequestsTable .requestedTreasure').bootstrapToggle({
            size: 'small'
          });
              
          $('#treaserRequestsTable  > tbody:last-child').append(
            "<tr><td colspan='5'>"+
              "<button type='button' class='btn btn-info float-right' data-toggle='modal' data-target='#confirmRequestedNumbers'>Send</button>"+
            "</td></tr>");


          $( ":checkbox.requestedTreasure" ).change( function(){

            $('#bodyForm').empty();

            $("input[type=checkbox].requestedTreasure:checked").each(

              function(){

                var id = $(this).attr('id');
                var playerPhone = $(this).attr('data-playerPhone');
                var rechargeAmount = $(this).attr('data-rechargeAmount');

                var html =  "<div class='form-row'>"+

                                "<input type='hidden' name= 'id[]' value="+id+">"
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
        });
      });



    </script>

@endpush