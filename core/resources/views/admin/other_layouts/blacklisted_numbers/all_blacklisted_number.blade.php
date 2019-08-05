
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">

            <div class="row">
                <div class="col-12">
                    <h3 class="float-left"> Black Listed Numbers </h3>
                </div>
            </div>

            <hr>

            <div class="row">
                
                @if(auth()->user()->hasAnyRole(['moderator', 'admin']))
                <!-- Modal -->
                <div class="modal fade" id="deleteModal" role="dialog">
                    <div class="modal-dialog">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Confirmation</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <form method="POST" action="">

                                @method('DELETE')
                                @csrf

                                <div class="modal-body">
                                    <p>You are about to enable the number for purchase.</p> 
                                                    
                                    <p class="text-muted">This action cannot be undone.</p>
                                    
                                    <h5>Do you want to proceed ?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Yes</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                
                @endif

            </div>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%" id="numberTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Serial No.</th>
                                <th>Number</th>
                                
                                @if(auth()->user()->hasAnyRole(['moderator', 'admin']))
                                    <th class="actions">Actions</th>
                                @endif
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

            $('#numberTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.view_black_list') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'mobile_number', name: 'mobile_number' },
                    
                    @if(auth()->user()->hasAnyRole(['moderator', 'admin']))
                        { data: 'action', name: 'action', orderable : false }
                    @endif
                ],
                drawCallback:function(){
                    var api = this.api();
                    var json = api.ajax.json();
                    globalVariable = json.data;
                }
            });

            $('#numberTable').on( 'draw.dt', function () {
                
                // console.log(globalVariable);

                @if(auth()->user()->hasAnyRole(['moderator', 'admin']))

                $(".fa-trash").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    var home = "{{ URL::to('/') }}";


                    $("#deleteModal form").attr("action", home + '/admin/black-list/' +  expectedObject.id );

                    $('#deleteModal').modal('toggle');
                });

                @endif
            });
        });

    </script>

@endpush