
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left">Enabled Areas List </h3>
                </div>


                <div class="col-6">

                    @if(auth()->user()->can('read'))

                    <a  href="{{route('admin.view_disabled_areas')}}"  class="btn btn-outline-danger float-right btn-sm mr-1 ml-1" type="button">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Deleted Areas
                    </a>

                    @endif

                    @if(auth()->user()->can('create'))

                    <button type="button" class="btn btn-success float-right btn-sm" data-toggle="modal" data-target="#addArea">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Area
                    </button>

                    @endif

                </div>

            </div>

            <hr>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">

                        <thead class="thead-dark">
                            <tr>
                                <th>Area Name</th>
                                <th>City</th>

                                @if(auth()->user()->can('update'))

                                <th class="actions">Actions</th>

                                @endif

                            </tr>
                        </thead>
                        
                        <tbody>

                        @if($areas->isEmpty())
                            <tr class="danger">
                                <td class="text-danger" colspan='5'>No Data Found</td>
                            </tr>
                        @endif

                        @foreach($areas as $area)

                            <tr>
                                <td>{{ $area->name }}</td>
                                <td>{{ $area->city->name }}</td>

                                @if(auth()->user()->can('update'))

                                <td>

                                    <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editArea{{$area->id}}">
                                        <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                    </button>

                                    <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteArea{{$area->id}}" title="Delete">
                                        <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                    </button>
                                        
                                </td>

                                @endif

                            </tr>

                        @if(auth()->user()->can('delete'))

                        <!-- Delete Modal -->                       
                        <div class="modal fade" id="deleteArea{{$area->id}}" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.delete_area', $area->id) }}">

                                        @csrf
                                        @method('DELETE')
                                        
                                        <div class="modal-body">
                                            <p>You are about to delete.</p> 
                                            
                                            <p class="text-muted">This item will be removed to recycle bin.</p>
                                            
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
                        
                        @if(auth()->user()->can('update'))

                        <!-- Edit Modal -->  
                        <div class="modal fade" id="editArea{{$area->id}}" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h3> Edit Area</h3>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        
                                        <form method="post" action= "{{ route('admin.updated_area_submit', $area->id) }}" enctype="multipart/form-data">
                                            
                                            @csrf
                                            @method('put')

                                            <div class="form-row">

                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">City</label>

                                                    <select class="form-control is-invalid" name="city" required="true">
                                                        
                                                        @foreach(App\Models\City::all() as $city)

                                                        <option value="{{ $city->id }}" @if($city->id==$area->city_id) selected="true" @endif>
                                                            {{ $city->name }}
                                                        </option>

                                                        @endforeach
                                                        
                                                    </select>

                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Area Name</label>
                                                    <div class="input-group">
                                                        <input step="any" type="text" name="name" class="form-control  is-invalid" value="{{ $area->name }}" required="true">
                                                    </div>
                                                </div>
                                            </div>

                                            <br>

                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-lg btn-block btn-primary">Update Area</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div> 
                        
                        @endif       

                        @endforeach

                        </tbody>
                    </table>

                    <div class="float-right">
                        {{ $areas->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->can('create'))

        <div class="modal fade" id="addArea" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3> Add Area</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        
                        <form method="post" action= "{{ route('admin.created_area_submit') }}" enctype="multipart/form-data">
                            
                            @csrf

                            <div class="form-row">

                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">City</label>

                                    <select class="form-control is-invalid" name="city" required="true">
                                        
                                        @foreach(App\Models\City::all() as $city)

                                        <option value="{{ $city->id }}">
                                            {{ $city->name }}
                                        </option>

                                        @endforeach
                                        
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">Area Name</label>
                                    <div class="input-group">
                                        <input step="any" type="text" name="name" class="form-control  is-invalid"  placeholder="Area Name" required="true">
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-lg btn-block btn-primary">Create Area</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        @endif

    </div>
@stop