
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left"> Enabled Missions List </h3>
                </div>

                <div class="col-6">
                    <a  href="{{route('admin.view_disabled_missions')}}"  class="btn btn-outline-danger float-right" type="button">
                        Disabled Missions
                    </a>
                    <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#addType">
                        New Mission Type
                    </button>

                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal">
                        New Mission
                    </button>
                </div>

            </div>

            <hr>


            <div class="row">
                
                <!-- Delete Modal -->                       
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
                

                <div class="modal fade" id="editModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3> Edit Mission </h3>
                                <button type="button" class="close" data-dismiss="modal">
                                    &times;
                                </button>
                            </div>

                            <div class="modal-body">
                                
                                <form method="post" action= "" enctype="multipart/form-data">
                                    
                                    @csrf
                                    @method('PUT')

                                    <div class="form-row">
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Mission Type</label>

                                            <select class="form-control form-control-lg is-invalid" name="mission_type_id" required="true">
                                                
                                                @foreach(App\Models\MissionType::all() as $missionType)
                                                    <option value="{{ $missionType->id }}">
                                                        {{ $missionType->mission_type_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Mission Name</label>
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-control form-control-lg is-valid"  placeholder="Mission Name" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Mission Description</label>
                                            <div class="input-group">
                                                <input type="text" name="description" class="form-control form-control-lg is-valid" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-4">
                                            <label for="validationServer01">Play Time</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ times</span>
                                                </div>
                                                <input type="number" name="play_number" class="form-control form-control-lg is-valid"  placeholder="Number Games to Play" value="">

                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="validationServerUsername">Play Duration </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ hour</span>
                                                </div>
                                                <input type="number" name="play_time" class="form-control form-control-lg is-valid" placeholder="Play Duration"aria-describedby="inputGroupPrepend3" min="1" step="any" value="">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="col-md-12 mb-4">
                                            <label for="validationServerUsername">Damage Opponent</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ amount</span>
                                                </div>
                                                <input type="number" name="damage_opponent" class="form-control form-control-lg is-valid" placeholder="Damage to Opponent" aria-describedby="inputGroupPrepend3" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-4">
                                            <label for="validationServerUsername">Kill Opponent</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ player</span>
                                                </div>
                                                <input type="number" name="kill_opponent" class="form-control form-control-lg is-valid" placeholder="Kill Opponent Player" aria-describedby="inputGroupPrepend3" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label for="validationServerUsername">Kill Opponent</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ monster</span>
                                                </div>
                                                <input type="number" name="kill_monster" class="form-control form-control-lg is-valid" placeholder="Kill Opponent Monster" aria-describedby="inputGroupPrepend3" step="any" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-4">
                                            <label for="validationServerUsername">Travel Distance</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ meter</span>
                                                </div>
                                                <input type="number" name="travel_distance" class="form-control form-control-lg is-valid" placeholder="Distance to Travel"aria-describedby="inputGroupPrepend3" min="1" step="any" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-3 mb-4">
                                            <label for="validationServerUsername">Win First Position </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ times</span>
                                                </div>
                                                <input type="number" name="win_top_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-4">
                                            <label for="validationServerUsername">Win Among Two </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ times</span>
                                                </div>
                                                <input type="number" name="among_two_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-4">
                                            <label for="validationServerUsername">Win Among Three </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ times</span>
                                                </div>
                                                <input type="number" name="among_three_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-4">
                                            <label for="validationServerUsername">Win Among Five </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ times</span>
                                                </div>
                                                <input type="number" name="among_five_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>  

            </div>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%" id="missionsTable">

                        <thead class="thead-dark">
                            <tr>
                                <th>Mission Serial</th>
                                <th>Mission Name</th>
                                <th>Mission Type</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        
                    {{-- 
                        <tbody>

                        @if($missions->isEmpty())
                            <tr class="danger">
                                <td class="text-danger" colspan='5'>No Data Found</td>
                            </tr>
                        @endif
                        
                        @foreach($missions as $mission)
                        
                        
                            <tr>
                                <td>{{ $mission->id }}</td>
                                <td>{{ $mission->name }}</td>
                                <td>{{ $mission->mission_type_id }}</td>
                                <td>

                                    <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$mission->id}}">
                                        <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                    </button>

                                    <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$mission->id}}" title="Delete">
                                        <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                    </button>
                                        
                                </td>
                            </tr> 
                                
                        @endforeach

                        </tbody> 
                                --}}
                    </table>

                {{-- 
                    <div class="float-right">
                        {{ $missions->onEachSide(5)->links() }}
                    </div> 
                            --}}
                </div>
            </div>
        </div>

        <div class="modal fade" id="addModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3> Create Mission </h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        
                        <form method="post" action= "{{ route('admin.created_mission_submit') }}" enctype="multipart/form-data">
                            
                            @csrf

                            <div class="form-row">
                                <div class="col-md-4 mb-4">
                                    <label for="validationServer01">Mission Type</label>

                                    <select class="form-control form-control-lg is-invalid" name="mission_type_id" required="true">
                                        
                                        @foreach(App\Models\MissionType::all() as $missionType)
                                        <option value="{{ $missionType->id }}">
                                            {{ $missionType->mission_type_name }}
                                        </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="validationServer01">Mission Name</label>
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control form-control-lg is-valid"  placeholder="Mission Name">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="validationServer01">Mission Description</label>
                                    <div class="input-group">
                                        <input type="text" name="description" class="form-control form-control-lg is-valid" placeholder="Short Description">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">Play Time</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ times</span>
                                        </div>
                                        <input type="number" name="play_number" class="form-control form-control-lg is-valid"  placeholder="Number Games to Play">

                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="validationServerUsername">Play Duration </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ hour</span>
                                        </div>
                                        <input type="number" name="play_time" class="form-control form-control-lg is-valid" placeholder="Play Duration"aria-describedby="inputGroupPrepend3" min="1" step="any">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="col-md-12 mb-4">
                                    <label for="validationServerUsername">Damage Opponent</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ amount</span>
                                        </div>
                                        <input type="number" name="damage_opponent" class="form-control form-control-lg is-valid" placeholder="Damage to Opponent" aria-describedby="inputGroupPrepend3" min="1">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="validationServerUsername">Kill Opponent</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ player</span>
                                        </div>
                                        <input type="number" name="kill_opponent" class="form-control form-control-lg is-valid" placeholder="Kill Opponent Player" aria-describedby="inputGroupPrepend3">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="validationServerUsername">Kill Opponent</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ monster</span>
                                        </div>
                                        <input type="number" name="kill_monster" class="form-control form-control-lg is-valid" placeholder="Kill Opponent Monster" aria-describedby="inputGroupPrepend3" step="any">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-4">
                                    <label for="validationServerUsername">Travel Distance</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ meter</span>
                                        </div>
                                        <input type="number" name="travel_distance" class="form-control form-control-lg is-valid" placeholder="Distance to Travel"aria-describedby="inputGroupPrepend3" min="1" step="any">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-3 mb-4">
                                    <label for="validationServerUsername">Win First Position </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ times</span>
                                        </div>
                                        <input type="number" name="win_top_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <label for="validationServerUsername">Win Among Two </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ times</span>
                                        </div>
                                        <input type="number" name="among_two_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <label for="validationServerUsername">Win Among Three </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ times</span>
                                        </div>
                                        <input type="number" name="among_three_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <label for="validationServerUsername">Win Among Five </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ times</span>
                                        </div>
                                        <input type="number" name="among_five_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any">
                                    </div>
                                </div>
                            </div>


                            <br>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-lg btn-block btn-primary">Create</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addType" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3> Add Mission Type</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        
                        <form method="post" action= "{{ route('admin.created_mission_type_submit') }}" enctype="multipart/form-data">
                            
                            @csrf

                            <div class="form-row">
                                <div class="col-md-12 mb-4">
                                    <label for="validationServer01">Type Name</label>
                                    <div class="input-group">
                                        <input step="any" type="text" name="mission_type_name" class="form-control form-control-lg is-invalid"  placeholder="Type Name" required="true">
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-lg btn-block btn-primary">Create Type</button>
                                </div>
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
       
        $( document ).ready(function() {

            var globalVariable = 0;

            $('#missionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.view_enabled_missions') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'mission_type.mission_type_name', name: 'mission_type.mission_type_name', orderable : false, searchable : false },
                    { data: 'action', name: 'action', orderable: false }
                ],
                drawCallback: function( settings ) {
                    
                    var api = this.api();
                    
                    var jsonData = api.ajax.json();

                    globalVariable = jsonData.data;

                    // console.log(globalVariable);
                }
            });

            $('#missionsTable').on( 'draw.dt', function () {
                
                /*
                $(".fa-eye").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    $( "#viewModal p:eq(0)" ).html( expectedObject.name );
                    $( "#viewModal p:eq(1)" ).html( expectedObject.description );
                    $( "#viewModal p:eq(2)" ).html( expectedObject.amount );
                    $( "#viewModal p:eq(3)" ).html( expectedObject.price_taka +' taka /<br/>'+ expectedObject.price_gems +' gems /<br/>'+ expectedObject.price_coins +' coins');
                    
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

                $(".fa-edit").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    var home = "{{ URL::to('/') }}";

                    $("#editModal form").attr("action", home + '/admin/missions/' +  expectedObject.id );

                    $( "#editModal input[name*='name']" ).val( expectedObject.name );
                    $( "#editModal input[name*='description']" ).val( expectedObject.description );
                    $( "#editModal input[name*='play_number']" ).val( expectedObject.play_number );
                    $( "#editModal input[name*='play_time']" ).val( expectedObject.play_time );
                    $( "#editModal input[name*='damage_opponent']" ).val( expectedObject.damage_opponent );
                    $( "#editModal input[name*='kill_opponent']" ).val( expectedObject.kill_opponent );


                    $( "#editModal input[name*='kill_monster']" ).val( expectedObject.kill_monster );
                    $( "#editModal input[name*='travel_distance']" ).val( expectedObject.travel_distance );
                    $( "#editModal input[name*='win_top_time']" ).val( expectedObject.win_top_time );
                    $( "#editModal input[name*='among_two_time']" ).val( expectedObject.among_two_time );
                    $( "#editModal input[name*='among_three_time']" ).val( expectedObject.among_three_time );


                    $( "#editModal input[name*='among_five_time']" ).val( expectedObject.among_five_time );

                    $("#editModal select").val(expectedObject.mission_type_id);

                    $('#editModal').modal('toggle');
                });

                $(".fa-trash").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    var home = "{{ URL::to('/') }}";

                    $("#deleteModal form").attr("action", home + '/admin/missions/' +  expectedObject.id );

                    $('#deleteModal').modal('toggle');
                });
            });  
        });

   </script>

@endpush