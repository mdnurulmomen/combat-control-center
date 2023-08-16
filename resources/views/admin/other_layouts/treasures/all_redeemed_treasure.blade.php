
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left"> Treasure Redemptions List </h3>
                </div>
            </div>

            <hr>

            <div class="row">  
                <!--- View Modal --->
                <div class="modal fade" id="viewModal" role="dialog">
                    <div class="modal-dialog  modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4> Treasure Redeemption Details </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">  
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="validationServerUsername">Player Name</label>
                                    </div>
                                        
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="validationServerUsername">Treasure Name</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Exchanged with </label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Eq. price</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Player Phone</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row mb-5">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Agent Phone</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%" id="redemptionsTable">

                        <thead class="thead-dark">
                            <tr>
                                <th>Player Name</th>
                                <th>Treasure Name</th>
                                <th>User Mobile</th>
                                <th>Collected on</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')

    <script>

        $(function() {

            var globalVariable = 0;

            $('#redemptionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.view_treasure_redeems') }}",
                columns: [
                    { 
                        data: 'player.user.username', 
                        name: 'player.user.username'
                    },
                    { data: 'treasure.name', name: 'treasure.name' },
                    { data: 'player_phone', name: 'player_phone' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable : false },
                ],
                initComplete: function(settings,json){
                    // console.log(json.data);
                    globalVariable =  json.data;
                }
            });


            $('#redemptionsTable').on( 'draw.dt', function () {

                $(".fa-eye").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    $( "#viewModal p:eq(0)" ).html( expectedObject.player.user.username );
                    $( "#viewModal p:eq(1)" ).html( expectedObject.treasure.name );
                    $( "#viewModal p:eq(2)" ).html( expectedObject.exchanging_type);
                    $( "#viewModal p:eq(3)" ).html( expectedObject.equivalent_price);
                    $( "#viewModal p:eq(4)" ).html( expectedObject.player_phone);
                    $( "#viewModal p:eq(5)" ).html( expectedObject.agent_phone);
                    

                    $('#viewModal').modal('toggle');
                });
            });
        });

    </script>

@endpush