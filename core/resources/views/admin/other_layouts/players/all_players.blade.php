
@extends('admin.master_layout.app')
@section('contents')
    <div class="card mb-4">
        <div class="card-body">

            <div class="row">
                <div class="col-12 table-responsive">
                    <h3 class="float-left"> Player List </h3>
                </div>
            </div>
            
            <hr>

            <div class="row">

                <!-- Modal -->
                <div class="modal fade" id="deleteModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Confirmation</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form method="POST" action="">

                                @method('DELETE')
                                @csrf
                                
                                <div class="modal-body">
                                    <p>Are You Sure ??</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Yes</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%" id="playerTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Serial</th>
                                <th>User Name</th>
                                <th>Level</th>
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
        
        $( document ).ready(function() {
            
            var globalVariable = 0;

            $('#playerTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.view_players') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user.username', name: 'user.username' },
                    { data: 'player_batch', name: 'player_batch' },
                    { data: 'action', name: 'action', orderable : false }
                ],
                drawCallback:function(){
                    var api = this.api();
                    var json = api.ajax.json();
                    globalVariable = json.data;
                    console.log(json.data);
                }
            });

            $('#playerTable').on( 'draw.dt', function () {

                /*
                $(".fa-eye").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    $( "#viewModal p:eq(0)" ).html( expectedObject.name );
                    $( "#viewModal p:eq(1)" ).html( expectedObject.description );

                    $( "#viewModal p:eq(2)" ).html( expectedObject.price_taka +' taka /<br/>'+ expectedObject.price_gems +' gems /<br/>'+ expectedObject.price_coins +' coins');
                    
                    $( "#viewModal span:eq(0)" ).html( Math.max(expectedObject.discount_taka, expectedObject.discount_gems, expectedObject.discount_coins) + ' %' );

                    if (expectedObject.discount_taka) {
                        $( "#viewModal span:eq(1)" ).html( 'taka,' );
                    }
                    else{
                        $( "#viewModal span:eq(1)" ).empty(); 
                    }

                    if (expectedObject.discount_gems) {
                        $( "#viewModal span:eq(2)" ).html( 'gems,' );
                    }
                    else{
                        $( "#viewModal span:eq(2)" ).empty(); 
                    }

                    if (expectedObject.discount_coins) {
                        $( "#viewModal span:eq(3)" ).html( 'coins' );
                    }
                    else{
                        $( "#viewModal span:eq(3)" ).empty(); 
                    }

                    $('#viewModal').modal('toggle');
                });
                */


                $(".fa-trash").click(function() {
                    // alert('delete');

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    var home = "{{ URL::to('/') }}";

                    $("#deleteModal form").attr("action", home + '/admin/player/' +  expectedObject.id );

                    $('#deleteModal').modal('toggle');
                });
            });
        });
    </script>

@endpush
