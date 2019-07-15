
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">

                    <div class="col-6">
                        <h3 class="float-left">Enabled Vendors List </h3>
                    </div>


                    <div class="col-6">

                        @if(auth()->user()->can('read'))
                        
                        <a  href="{{route('admin.view_disabled_vendors')}}"  class="btn btn-outline-danger float-right btn-sm" type="button">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            Disabled Vendors
                        </a>

                        @endif

                        @if(auth()->user()->can('create'))

                        <button type="button" class="btn btn-info float-right btn-sm mr-1 ml-1 " data-toggle="modal" data-target="#addType">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                            New Treasure Type
                        </button>

                        <button type="button" class="btn btn-success float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            New Vendor
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
                                    
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Logo</th>
                                    <th>Mobile</th>

                                    @if(auth()->user()->can('update'))

                                    <th class="actions">Actions</th>

                                    @endif

                                </tr>
                            </thead>

                            <tbody>

                            @if($vendors->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($vendors as $vendor)

                                <tr>

                                    <td>{{ $vendor->name }}</td>
                                    <td>{{ $vendor->treasureType->treasure_type_name }}</td>

                                    <td>
                                        <img class="img-fluid" src="{{ asset($vendor->logo_picture) }}" alt="No Image">
                                    </td>
                                    
                                    <td>
                                        <p>{{ $vendor->mobile }}</p>
                                    </td>

                                    @if(auth()->user()->can('update'))

                                    <td>

                                       <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$vendor->id}}" title="Edit">
                                            <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                        </button> 

                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$vendor->id}}" title="Delete">
                                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                        </button>

                                    </td>

                                    @endif                                        

                                </tr>

                                @if(auth()->user()->can('update'))

                                <div class="modal fade" id="editModal{{$vendor->id}}" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h3> Edit Vendor </h3>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">

                                                <form method="post" action = "{{ route('admin.updated_vendor_submit', $vendor->id) }}" enctype="multipart/form-data">
                                                    
                                                    @csrf
                                                    @method('put')

                                                    <div class="row">      
                                                        <div class="col-md-6">
                                                            <h4 class="tile-title">Card Title</h4>
                                                            <div class="tile">
                                                                <div class="tile-body">
                                                                    
                                                                    <div class="form-row mb-4">
                                                                        <label for="validationServerUsername">Name</label>
                                                                        <div class="input-group">
                                                                            <input type="text" name="name" class="form-control  is-invalid" value="{{ $vendor->name }}" aria-describedby="inputGroupPrepend3" required="true">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row mb-4">
                                                                        <label for="validationServer01">Type</label>
                                                                        <select class="form-control  is-valid" name="treasure_type_id">

                                                                            @foreach(App\Models\TreasureType::all() as $treasureType)
                                                                            
                                                                            <option value="{{ $treasureType->id }}" @if($treasureType->id == $vendor->treasure_type_id) selected="true" @endif>{{ $treasureType->treasure_type_name }}</option>

                                                                            @endforeach

                                                                        </select>
                                                                    </div>

                                                                    <div class="form-row mb-4">
                                                                        <label for="validationServerUsername">Phone</label>
                                                                        <div class="input-group">
                                                                            <input type="tel" name="mobile" class="form-control  is-invalid" value="{{ $vendor->mobile }}" aria-describedby="inputGroupPrepend3" required="true">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row mb-4">
                                                                        <label for="validationServerUsername" class="col-12">Change Logo</label>

                                                                        <div class="col-6">
                                                                            <div class="input-group">
                                                                                <input type="file" name="logo" class="form-control  is-valid" aria-describedby="inputGroupPrepend3">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-6 text-center">
                                                                            <img src="{{ asset($vendor->logo_picture) }}" class="img-thumbnail" alt="Cinque Terre">
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <h4 class="tile-title">Card Title</h4>
                                                            <div class="tile">
                                                                <div class="tile-body">                         

                                                                    <div class="form-row mb-4">
                                                                        <label for="validationServerUsername">Address</label>
                                                                        <div class="input-group">
                                                                            <input type="text" name="address" class="form-control  is-invalid" value="{{ $vendor->address }}" aria-describedby="inputGroupPrepend3" required="true">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row mb-4">    
                                                                        <label for="validationServerUsername">Area</label>
                                                                        <div class="input-group">
                                                                            <input type="text" name="area" class="form-control  is-invalid" value="{{ $vendor->area }}" aria-describedby="inputGroupPrepend3" required="true">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row mb-4">
                                                                        <label for="validationServerUsername">City</label>
                                                                        <div class="input-group">
                                                                            <input type="text" name="city" class="form-control  is-invalid" value="{{ $vendor->city }}" aria-describedby="inputGroupPrepend3" required="true">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row mb-4">
                                                                        <label for="validationServerUsername">Division</label>
                                                                        <div class="input-group">
                                                                            <input type="text" name="division" class="form-control  is-invalid" value="{{ $vendor->division }}" aria-describedby="inputGroupPrepend3" required="true">
                                                                        </div>
                                                                    </div>
                                                                </div>
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

                                @endif

                                @if(auth()->user()->can('delete'))

                                <!--Delete Modal -->
                                <div class="modal fade" id="deleteModal{{$vendor->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.delete_vendor', $vendor->id) }}">

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

                                @endif

                            @endforeach
                            
                            </tbody>
                        </table>

                        <div class="float-right">
                            {{ $vendors->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            @if(auth()->user()->can('create'))

            <div class="modal fade" id="addType" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Add Treasure Type</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            
                            <form method="post" action= "{{ route('admin.created_treasure_type_submit') }}" enctype="multipart/form-data">
                                
                                @csrf

                                <div class="form-row">
                                    <div class="col-md-12 mb-4">
                                        <label for="validationServer01">Type Name</label>
                                        <div class="input-group">
                                            <input step="any" type="text" name="treasure_type_name" class="form-control  is-invalid"  placeholder="Type Name" required="true">
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
            

            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Create Vendor </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">

                            <form method="post" action= "{{ route('admin.created_vendor_submit') }}" enctype="multipart/form-data">
                                
                                @csrf

                                <div class="row">      
                                    <div class="col-md-6">
                                        <h4 class="tile-title">Card Title</h4>
                                        <div class="tile">
                                            <div class="tile-body">
                                                
                                                <div class="form-row mb-4">
                                                    <label for="validationServerUsername">Name</label>
                                                    <div class="input-group">
                                                        <input type="text" name="name" class="form-control  is-invalid" placeholder="Name" aria-describedby="inputGroupPrepend3" required="true">
                                                    </div>
                                                </div>

                                                <div class="form-row mb-4">
                                                    <label for="validationServer01">Type</label>
                                                    <select class="form-control  is-valid" name="treasure_type_id">

                                                        @foreach(App\Models\TreasureType::all() as $treasureType)

                                                        <option value="{{ $treasureType->id }}">
                                                            {{ $treasureType->treasure_type_name }}
                                                        </option>

                                                        @endforeach

                                                    </select>
                                                </div>

                                                <div class="form-row mb-4">
                                                    <label for="validationServerUsername">Phone</label>
                                                    <div class="input-group">
                                                        <input type="tel" name="mobile" class="form-control  is-invalid" placeholder="Phone" aria-describedby="inputGroupPrepend3" required="true">
                                                    </div>
                                                </div>

                                                <div class="form-row mb-4">
                                                    <label for="validationServerUsername">Logo</label>
                                                    <div class="input-group">
                                                        <input type="file" name="logo" class="form-control  is-invalid" aria-describedby="inputGroupPrepend3" required="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <h4 class="tile-title">Card Title</h4>
                                        <div class="tile">
                                            <div class="tile-body">                         

                                                <div class="form-row mb-4">
                                                    <label for="validationServerUsername">Address</label>
                                                    <div class="input-group">
                                                        <input type="text" name="address" class="form-control  is-invalid" placeholder="Address" aria-describedby="inputGroupPrepend3" required="true">
                                                    </div>
                                                </div>

                                                <div class="form-row mb-4">    
                                                    <label for="validationServerUsername">Area</label>
                                                    <div class="input-group">
                                                        <input type="text" name="area" class="form-control  is-invalid" placeholder="Area" aria-describedby="inputGroupPrepend3" required="true">
                                                    </div>
                                                </div>

                                                <div class="form-row mb-4">
                                                    <label for="validationServerUsername">City</label>
                                                    <div class="input-group">
                                                        <input type="text" name="city" class="form-control  is-invalid" placeholder="City" aria-describedby="inputGroupPrepend3" required="true">
                                                    </div>
                                                </div>

                                                <div class="form-row mb-4">
                                                    <label for="validationServerUsername">Division</label>
                                                    <div class="input-group">
                                                        <input type="text" name="division" class="form-control  is-invalid" placeholder="Division" aria-describedby="inputGroupPrepend3" required="true">
                                                    </div>
                                                </div>
                                            </div>
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

            @endif

        </div>

@stop