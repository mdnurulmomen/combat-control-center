
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left"> Enabled Treasures List </h3>
                </div>

                <div class="col-6">

                    @if(auth()->user()->can('read'))

                    <a  href="{{route('admin.view_disabled_treasures')}}"  class="btn btn-outline-danger float-right btn-sm" type="button">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Disabled Treasures
                    </a>

                    @endif

                    @if(auth()->user()->can('create'))
                    
                    <button type="button" class="btn btn-info btn-sm float-right mr-1 ml-1 " data-toggle="modal" data-target="#addType">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        New Treasure Type
                    </button>

                    <button type="button" class="btn btn-success btn-sm float-right " data-toggle="modal" data-target="#addModal">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        New Treasure
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
                                <th>Treasure Serial</th>
                                <th>Treasure Name</th>
                                <th>Equivalent Cost</th>
                                
                                @if(auth()->user()->can('update'))

                                <th class="actions">Actions</th>

                                @endif

                            </tr>
                        </thead>
                        
                        <tbody>

                        @if($treasures->isEmpty())
                            <tr class="danger">
                                <td class="text-danger" colspan='5'>No Data Found</td>
                            </tr>
                        @endif
                        
                        @foreach($treasures as $treasure)
                            <tr>
                                <td>{{ $treasure->id }}</td>
                                <td>{{ $treasure->name }}</td>
                                <td>{{ $treasure->equivalent_price }}</td>

                                @if(auth()->user()->can('update'))

                                <td>

                                    <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$treasure->id}}">
                                        <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                    </button>

                                    <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$treasure->id}}" title="Delete">
                                        <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                    </button>
                                        
                                </td>

                                @endif

                            </tr>

                        @if(auth()->user()->can('delete'))
                        
                        <!-- Delete Modal -->                       
                        <div class="modal fade" id="deleteModal{{$treasure->id}}" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.delete_treasure', $treasure->id) }}">

                                        @method('DELETE')
                                        @csrf
                                        
                                        <div class="modal-body">
                                            <p>You are about to delete.</p> 
                                            <p class="text-muted">This may cause error to related player.</p>
                                            
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
                        
                        <div class="modal fade" id="editModal{{$treasure->id}}" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h3> Edit Treasure </h3>
                                        <button type="button" class="close" data-dismiss="modal">
                                            &times;
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        
                                        <form method="post" action= "{{ route('admin.updated_treasure_submit', $treasure->id) }}" enctype="multipart/form-data">
                                            
                                            @csrf
                                            @method('PUT')

                                            <div class="form-row">

                                                <div class="col-md-4 mb-4">
                                                    <label for="validationServer01">Treasure Type</label>

                                                    <select class="form-control form-control-lg is-valid" name="treasure_type_id" required="true">
                                                        @foreach(App\Models\TreasureType::all() as $treasureType)
                                                        <option value="{{ $treasureType->id }}" @if($treasure->treasure_type_id == $treasureType->id) selected="true" @endif>
                                                            {{ $treasureType->treasure_type_name }}
                                                        </option>
                                                        @endforeach

                                                    </select>

                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="validationServer01">Treasure Name </label>
                                                    <div class="input-group">
                                                        <input step="any" type="text" name="name" class="form-control form-control-lg is-valid"  value="{{ $treasure->name }}" required="true">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="validationServer01">Treasure Amount </label>
                                                    <div class="input-group">
                                                        <input step="any" type="text" name="amount" class="form-control form-control-lg is-valid"  value="{{ $treasure->amount }}" min="1">
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Approximate Cost</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">@ taka</span>
                                                        </div>
                                                        <input type="number" name="equivalent_price" class="form-control form-control-lg is-valid" value="{{ $treasure->equivalent_price }}" required="true" step="any">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServerUsername">Durability</label>
                                                    <div class="input-group">
                                                        <input type="number" name="durability" class="form-control form-control-lg is-valid" value="{{ $treasure->durability ?? -1 }}"  aria-describedby="inputGroupPrepend3" step="any" placeholder="-1">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">@ days</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">

                                                <div class="col-md-4 mb-4">
                                                    <label for="validationServerUsername">Exchanging Coins</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">@ coins</span>
                                                        </div>
                                                        <input type="text" name="exchanging_coins" class="form-control form-control-lg is-valid" value="{{ $treasure->exchanging_coins }}" aria-describedby="inputGroupPrepend3">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="validationServerUsername">Exchanging Gems</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">@ gems</span>
                                                        </div>
                                                        <input type="number" name="exchanging_gems" class="form-control form-control-lg is-valid" value="{{ $treasure->exchanging_gems }}"  aria-describedby="inputGroupPrepend3" min="0">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="validationServerUsername">Exchanging MB</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">@ megabyte</span>
                                                        </div>
                                                        <input type="number" name="exchanging_megabyte" class="form-control form-control-lg is-valid" value="{{ $treasure->exchanging_megabyte }}"  aria-describedby="inputGroupPrepend3" step="1">
                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-6 mb-4">
                                                    <label for="validationServerUsername">Collecting Point</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">@ place</span>
                                                        </div>
                                                        <input type="text" name="collecting_point" class="form-control form-control-lg is-valid" value="{{ $treasure->collecting_point }}" aria-describedby="inputGroupPrepend3">
                                                    </div>
                                                </div> --}}
                                                
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-12 mb-4">
                                                    <label for="validationServerUsername">Description</label>
                                                    <div class="input-group">
                                                        <textarea  class="form-control form-control-lg is-valid" name="description" rows="3" placeholder="A Short Description" required="true">{{ $treasure->description }}</textarea>
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

                        @endforeach

                        </tbody>
                    </table>

                    <div class="float-right">
                        {{ $treasures->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->can('create'))

        <div class="modal fade" id="addModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3> Create Treasure </h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        
                        <form method="post" action= "{{ route('admin.created_treasure_submit') }}" enctype="multipart/form-data">
                            
                            @csrf

                            <div class="form-row">

                                <div class="col-md-4 mb-4">
                                    <label for="validationServer01">Treasure Type</label>

                                    <select class="form-control form-control-lg is-valid" name="treasure_type_id" data-validation='required' data-validation-error-msg='Please select treasure type'>
                                        
                                        <option selected="true" disabled="true">
                                            --Please select treasure type--
                                        </option>

                                        @foreach(App\Models\TreasureType::all() as $treasureType)
                                        <option value="{{ $treasureType->id }}">
                                            {{ $treasureType->treasure_type_name }}
                                        </option>
                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="validationServer01">Treasure Name</label>
                                    <div class="input-group">
                                        <input step="any" type="text" name="name" class="form-control form-control-lg is-valid"  placeholder="Treasure Name" data-validation= 'required' data-validation-error-msg='Treasure name is required'>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="validationServer01">Treasure Amount</label>
                                    <div class="input-group">
                                        <input type="text" name="amount" class="form-control form-control-lg is-valid" placeholder="Amount of product" data-validation='number' data-validation-optional="true" data-validation-allowing='range[1;10]' data-validation-help='Numbers of treasure (min 1,max 10)' data-validation-error-msg='Numeric only'>
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">Approximate Cost</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ taka</span>
                                        </div>
                                        <input type="text" name="equivalent_price" class="form-control form-control-lg is-valid"  placeholder="Taka" data-validation='number required' data-validation-allowing='float' data-validation-help='Cost of treasure' data-validation-error-msg='Amount taka should only be numeric'>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="validationServerUsername">Durability</label>
                                    <div class="input-group">
                                        <input type="text" name="durability" class="form-control form-control-lg is-valid" placeholder="Please Leave if Unlimited" aria-describedby="inputGroupPrepend3" data-validation='number' data-validation-optional="true" data-validation-allowing='float range[1;100]' data-validation-error-msg='Number of days should only be numeric'>
                                        <div class="input-group-append">
                                            <span class="input-group-text">@ days</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="col-md-4 mb-4">
                                    <label for="validationServerUsername">Exchanging Coins</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ coins</span>
                                        </div>
                                        <input type="text" name="exchanging_coins" class="form-control form-control-lg is-valid" placeholder="Coins"aria-describedby="inputGroupPrepend3" data-validation='number' data-validation-optional="true" data-validation-allowing='range[1;1000000]' data-validation-help='Coins Cost of treasure' data-validation-error-msg='Coin amount should only be numeric'>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <label for="validationServerUsername">Exchanging Gems</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ gems</span>
                                        </div>
                                        <input type="text" name="exchanging_gems" class="form-control form-control-lg is-valid" placeholder="Gems" aria-describedby="inputGroupPrepend3" data-validation='number' data-validation-optional="true" data-validation-allowing='range[1;1000000]' data-validation-help='Gems Cost of treasure' data-validation-error-msg='Gems should only be numeric'>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="validationServerUsername">Exchanging MB</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ megabyte</span>
                                        </div>
                                        <input type="text" name="exchanging_megabyte" class="form-control form-control-lg is-valid" placeholder="MB"  aria-describedby="inputGroupPrepend3" data-validation='number' data-validation-optional="true" data-validation-allowing='float' data-validation-help='Amount Megabyte for treasure' data-validation-error-msg='Megabyte should only be numeric'>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 mb-4">
                                    <label for="validationServerUsername">Collecting Point</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ place</span>
                                        </div>
                                        <input type="text" name="collecting_point" class="form-control form-control-lg is-valid" placeholder="Please Leave if Unspecific" aria-describedby="inputGroupPrepend3">
                                    </div>
                                </div> --}}
                                
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-4">
                                    <label for="validationServerUsername">Description</label>
                                    <div class="input-group">
                                        <textarea  class="form-control form-control-lg is-valid" name="description" rows="3" placeholder="A Short Description" data-validation="required" data-validation-error-msg='A short description is required'></textarea>
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
                                        <input type="text" name="treasure_type_name" class="form-control form-control-lg is-valid"  placeholder="Type Name" data-validation='required alphanumeric' data-validation-help='Name has to be unique' data-validation-error-msg='Treasure Type Name is required'>
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

        @endif

    </div>
@stop