
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

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%" id="numberTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Serial No.</th>
                                <th>Number</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                    {{-- 
                        <tbody>

                        @if($allBlackListNumbers->isEmpty())
                            <tr class="danger">
                                <td class="text-danger" colspan='5'>No Data Found</td>
                            </tr>
                        @endif

                        @foreach($allBlackListNumbers as $blackList)
                            <tr>
                                <td>{{ $blackList->id }}</td>
                                <td>{{ $blackList->mobile_number }}</td>
                                <td>
                                    <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$blackList->id}}" title="Delete">
                                        <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                    </button>
                                </td>
                            </tr>

                        @endforeach
                        </tbody> 
                                --}}
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
                    { data: 'action', name: 'action', orderable : false }
                ],
                drawCallback:function(){
                    var api = this.api();
                    var json = api.ajax.json();
                    globalVariable = json.data;
                }
            });

            $('#numberTable').on( 'draw.dt', function () {
                
                console.log(globalVariable);

                $(".fa-trash").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    var home = "{{ URL::to('/') }}";


                    $("#deleteModal form").attr("action", home + '/admin/black-list/' +  expectedObject.id );

                    $('#deleteModal').modal('toggle');
                });
            });
        });

    </script>

@endpush