
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">

            <div class="row">

                <div class="col-4">
                    <h3 class="float-left">Enabled Vendors List </h3>
                </div>


                <div class="col-8">

                    @if(auth()->user()->can('read'))
                    
                    <a  href="{{route('admin.view_disabled_vendors')}}"  class="btn btn-outline-danger float-right btn-sm" type="button">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Deleted Vendors
                    </a>

                    @endif

                    @if(auth()->user()->can('create'))

                    <button type="button" class="btn btn-info float-right btn-sm mr-1 ml-1 " data-toggle="modal" data-target="#addCity">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                        City
                    </button>

                    <button type="button" class="btn btn-warning float-right btn-sm " data-toggle="modal" data-target="#addArea">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                        Area
                    </button>

                    <button type="button" class="btn btn-success float-right btn-sm mr-1 ml-1 " data-toggle="modal" data-target="#addType">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                        Treasure Type
                    </button>

                    <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addVendor">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Vendor
                    </button>

                    @endif

                </div>

            </div>
                
            <hr>

            <div class="row">

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

                                            <select class="form-control form-control-lg is-valid" name="city" data-validation='required' data-validation-error-msg='City name is required'>
                                                
                                                <option disabled="true" selected="true">--Please Select City--</option>

                                                @foreach(App\Models\City::all() as $city)

                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                
                                                @endforeach

                                            </select>

                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="validationServer01">Area Name</label>
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-control form-control-lg  is-valid"  placeholder="Area Name" data-validation='required' data-validation-error-msg='Area name is required' data-validation-help='Area name vendor belongs'>
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

                <div class="modal fade" id="addCity" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3> Add City</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                
                                <form method="post" action= "{{ route('admin.created_city_submit') }}" enctype="multipart/form-data">
                                    
                                    @csrf

                                    <div class="form-row">

                                        <div class="col-md-6 mb-4">
                                            <label for="validationServer01">Division</label>

                                            <select class="form-control form-control-lg is-valid" name="division"  data-validation='required' data-validation-error-msg='Division name is required'>
                                                
                                                <option disabled="true" selected="true">
                                                    --Please Select Division--
                                                </option>

                                                @foreach(App\Models\Division::all() as $division)

                                                <option value="{{ $division->id }}">
                                                    {{ $division->name }}
                                                </option>

                                                @endforeach
                                                
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="validationServer01">City Name</label>
                                            <div class="input-group">
                                                <input step="any" type="text" name="name" class="form-control form-control-lg  is-valid"  placeholder="City Name"  data-validation='required' data-validation-error-msg='City name is required' data-validation-help='City name vendor belongs'>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary">Create City</button>
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
                                                <input step="any" type="text" name="treasure_type_name" class="form-control form-control-lg  is-valid"  placeholder="Type Name"  data-validation='required' data-validation-error-msg='Type name is required' data-validation-help='Name has to be unique'>
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
                

                <div class="modal fade" id="addVendor" role="dialog">
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
                                            <h4 class="tile-title">Identification Details</h4>
                                            <div class="tile">
                                                <div class="tile-body">
                                                    
                                                    <div class="form-row mb-4">
                                                        <label for="validationServerUsername">Name</label>
                                                        <div class="input-group">
                                                            <input type="text" name="name" class="form-control form-control-lg  is-valid" placeholder="Name" aria-describedby="inputGroupPrepend3"  data-validation='required' data-validation-error-msg='Vendor name is required'>
                                                        </div>
                                                    </div>

                                                    <div class="form-row mb-4">
                                                        <label for="validationServer01">Type</label>
                                                        <select class="form-control form-control-lg  is-valid" name="treasure_type_id" data-validation='required' data-validation-error-msg='Please select Treasure Type'>

                                                            <option disabled="true" selected="true">
                                                                --Please Select Treasure Type--
                                                            </option>

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
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">88</span>
                                                            </div>
                                                            <input type="tel" name="mobile" class="form-control form-control-lg  is-valid" placeholder="Phone" aria-describedby="inputGroupPrepend3" data-validation="number required length" data-validation-length="max11" data-validation-error-msg="Please input a correct mobile number" data-validation-help="Phone number has to be unique (max 11 digits).">
                                                        </div>

                                                    </div>

                                                    <div class="form-row mb-4">
                                                        <label for="validationServerUsername">Logo</label>
                                                        <div class="input-group">
                                                            <input type="file" name="logo" class="form-control form-control-lg  is-valid" aria-describedby="inputGroupPrepend3"  data-validation='required mime size' data-validation-allowing='jpg, png' data-validation-max-size="5M" data-validation-help='Should be image file'>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <h4 class="tile-title">Location Details</h4>
                                            <div class="tile">
                                                <div class="tile-body">                         

                                                    <div class="form-row mb-4">
                                                        <label for="validationServerUsername">Division</label>

                                                        <select class="form-control form-control-lg is-valid" name="division_id" id="division" data-validation='required' data-validation-error-msg='Division name is required'>

                                                            <option value="null" selected="true" disabled="true">
                                                                --- Please Select Division ---
                                                            </option>

                                                            @foreach(App\Models\Division::all() as $division)

                                                                <option value="{{ $division->id }}">
                                                                    {{ $division->name }}
                                                                </option>

                                                            @endforeach

                                                        </select>

                                                    </div>

                                                    <div class="form-row mb-4">
                                                        <label for="validationServerUsername">City</label>

                                                        <select class="form-control form-control-lg is-valid" name="city_id" id="city" data-validation='required' data-validation-error-msg='City name is required'>
                                                            
                                                            <option value=""></option>

                                                        </select>

                                                    </div>

                                                    <div class="form-row mb-4">    
                                                        <label for="validationServerUsername">Area</label>

                                                        <select class="form-control form-control-lg is-valid" name="area_id" id="area" data-validation='required' data-validation-error-msg='Area name is required'>
                                                            
                                                            <option value=""></option>

                                                        </select>
                                                    </div>

                                                    <div class="form-row mb-4">
                                                        <label for="validationServerUsername">Address</label>

                                                        <input type="text" name="address" class="form-control form-control-lg  is-valid" placeholder="Address Details" aria-describedby="inputGroupPrepend3" data-validation='required' data-validation-error-msg='Vendor address is required'>
                                                            
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
                                    <p>{{ ltrim($vendor->mobile, '88') }}</p>
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
                                                        <h4 class="tile-title">Identification Details</h4>
                                                        <div class="tile">
                                                            <div class="tile-body">
                                                                
                                                                <div class="form-row mb-4">
                                                                    <label for="validationServerUsername">Name</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="name" class="form-control form-control-lg  is-valid" value="{{ $vendor->name }}" aria-describedby="inputGroupPrepend3" required="true">
                                                                    </div>
                                                                </div>

                                                                <div class="form-row mb-4">
                                                                    <label for="validationServer01">Type</label>
                                                                    <select class="form-control form-control-lg  is-valid" name="treasure_type_id">

                                                                        @foreach(App\Models\TreasureType::all() as $treasureType)
                                                                        
                                                                        <option value="{{ $treasureType->id }}" @if($treasureType->id == $vendor->treasure_type_id) selected="true" @endif>{{ $treasureType->treasure_type_name }}</option>

                                                                        @endforeach

                                                                    </select>
                                                                </div>

                                                                <div class="form-row mb-4">
                                                                    <label for="validationServerUsername">Phone</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">88</span>
                                                                        </div>
                                                                        <input type="tel" name="mobile" class="form-control form-control-lg  is-valid" value="{{ ltrim($vendor->mobile, '88') }}" aria-describedby="inputGroupPrepend3" required="true">
                                                                    </div>
                                                                </div>

                                                                <div class="form-row mb-4">
                                                                    <label for="validationServerUsername" class="col-12">Change Logo</label>

                                                                    <div class="col-6">
                                                                        <div class="input-group">
                                                                            <input type="file" name="logo" class="form-control form-control-lg  is-valid" aria-describedby="inputGroupPrepend3">
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
                                                        <h4 class="tile-title">Location Details</h4>

                                                        <div class="tile">
                                                            <div class="tile-body">                         

                                                                <div class="form-row mb-4">
                                                                    <label for="validationServerUsername">Division</label>

                                                                    <select class="form-control form-control-lg is-valid" name="division_id" id="division" required="true">

                                                                        <option value="null" disabled="true">
                                                                            --- Please Select Division ---
                                                                        </option>

                                                                        @foreach(App\Models\Division::all() as $division)

                                                                            <option value="{{ $division->id }}" @if($vendor->division_id == $division->id) selected="true" @endif>
                                                                                {{ $division->name }}
                                                                            </option>

                                                                        @endforeach

                                                                    </select>

                                                                </div>

                                                                <div class="form-row mb-4">
                                                                    <label for="validationServerUsername">City</label>

                                                                    <select class="form-control form-control-lg is-valid" name="city_id" id="city" required="true">
                                                                        
                                                                        <option value="{{ $vendor->city_id }}">{{ $vendor->city->name }}</option>

                                                                    </select>

                                                                </div>

                                                                <div class="form-row mb-4">    
                                                                    <label for="validationServerUsername">Area</label>

                                                                    <select class="form-control form-control-lg is-valid" name="area_id" id="area" required="true">
                                                                        
                                                                        <option value="{{ $vendor->area_id }}">{{ $vendor->area->name }}</option>

                                                                    </select>
                                                                </div>

                                                                <div class="form-row mb-4">
                                                                    <label for="validationServerUsername">Address</label>

                                                                    <input type="text" name="address" class="form-control form-control-lg  is-valid" value="{{ $vendor->address }}" aria-describedby="inputGroupPrepend3" required="true">
                                                                        
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

                        @endforeach
                        
                        </tbody>
                    </table>

                    <div class="float-right">
                        {{ $vendors->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop


@push('scripts')

    <script type="text/javascript">

        $("select[name*='division_id']").change(function() {


            var divisionId = $(this).val();     //get option value from division
   
            $.ajax({

                url : '{{ route( 'admin.view_enabled_vendors' ) }}',

                data: {
                    "_token": "{{ csrf_token() }}",
                    "divisionId": divisionId
                },

                type: 'get',

                dataType: 'json',

                success: function( result )
                {
                    $("select[name*='city_id']").html("");
                    $("select[name*='area_id']").html("");
                    $("input[name*='address']").val('');

                    $("select[name*='city_id']").append("<option selected='true' disabled='true'>--Please Select City--</option>");

                    $.each( result, function(objectArraykey, value) {

                        $("select[name*='city_id']").append("<option value='" + this.id + "'>" + this.name + "</option>");

                    });

                },

                error: function()
                {
                    //handle errors
                    alert("You've selected wrong option");
                }
            });
        });


        $("select[name*='city_id']").change(function() {

            var cityId = $(this).val();     //get option value from division
   
            $.ajax({

                url : '{{ route( 'admin.view_enabled_vendors' ) }}',

                data: {
                    "_token": "{{ csrf_token() }}",
                    "cityId": cityId
                },

                type: 'get',

                dataType: 'json',

                success: function( result )
                {
                    $("select[name*='area_id']").html("");
                    $("input[name*='address']").val('');

                    $("select[name*='area_id']").append("<option selected='true' disabled='true'>--Please Select Area--</option>");

                    $.each( result, function(objectArraykey, value) {

                        $("select[name*='area_id']").append("<option value='" + this.id + "'>" + this.name + "</option>");

                    });
                    
                    // console.log(result);
                },
                
                error: function()
                {
                    //handle errors
                    alert("You've selected wrong option");
                }
            });
        });
        
    </script>

@endpush