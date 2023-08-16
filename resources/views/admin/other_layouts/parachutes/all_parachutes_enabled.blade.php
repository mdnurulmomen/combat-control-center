
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left"> Enabled Parachutes List </h3>
                    </div>


                    <div class="col-6">
                        
                        @if(auth()->user()->can('read'))
                        
                        <a  href="{{route('admin.view_disabled_parachutes')}}"  class="btn btn-outline-danger float-right btn-sm ml-1 mr-1" type="button">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            Disabled Parachutes
                        </a>

                        @endif

                        @if(auth()->user()->can('create'))
                        
                        <button type="button" class="btn btn-success float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            New Parachute
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
                                <th>Parachute Name</th>
                                <th>Prices</th>
                                <th>Discounts</th>
                                
                                @if(auth()->user()->can('update'))

                                <th class="actions">Actions</th>

                                @endif

                            </tr>
                            </thead>
                            <tbody>

                            @if($parachutes->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($parachutes as $parachute)
                                <tr>
                                    <td>{{ $parachute->name }}</td>

                                    <td>
                                        <p>{{ $parachute->price_taka }} taka</p>
                                        <p>{{ $parachute->price_gems }} gems</p>
                                        <p>{{ $parachute->price_coins }} coins</p>
                                    </td>
                                    
                                    <td>
                                        <p>{{ $parachute->discount_taka }}% (taka)</p>
                                        <p>{{ $parachute->discount_gems }}% (gems)</p>
                                        <p>{{ $parachute->discount_coins }}% (coins)</p>
                                    </td>

                                    @if(auth()->user()->can('update'))

                                    <td>
                                        
                                        <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$parachute->id}}" title="Edit">
                                            <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                        </button>

                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$parachute->id}}" title="Delete">
                                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                        </button>

                                    </td>

                                    @endif

                                </tr>

                                @if(auth()->user()->can('update'))
                                <!--- Edit Modal --->
                                <div class="modal fade" id="editModal{{$parachute->id}}" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h3> Edit Parachute </h3>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                
                                                <form method="post" action = "{{ route('admin.updated_parachute_submit', $parachute->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @Method('put')
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Name</label>
                                                            <div class="input-group">
                                                                <input type="text" name="name" class="form-control form-control-lg is-valid" value="{{ $parachute->name }}" aria-describedby="inputGroupPrepend3" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Type</label>
                                                            <select class="form-control form-control-lg is-valid" name="type">
                                                                <option value="parachute">Parachute</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Description</label>
                                                            <div class="input-group">
                                                                <input type="text" name="description" class="form-control form-control-lg is-valid" value="{{ $parachute->description }}" aria-describedby="inputGroupPrepend3">
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Price (taka)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ taka</span>
                                                                </div>
                                                                <input type="number" name="price_taka" class="form-control form-control-lg is-valid"  value="{{ $parachute->price_taka }}" required="true" step="any">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Price (gems)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ gems</span>
                                                                </div>
                                                                <input type="number" name="price_gems" class="form-control form-control-lg is-valid"  value="{{ $parachute->price_gems }}" required="true" step="1.0">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Price (coins)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ coins</span>
                                                                </div>
                                                                <input type="number" name="price_coins" class="form-control form-control-lg is-valid" value="{{ $parachute->price_coins }}" required="true" step="1.0">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row mb-4">
                                                        <div class="col-md-5">
                                                            <label for="validationServerUsername">Discount</label>
                                                            <div class="input-group">
                                                                <input type="number" name="discount" class="form-control form-control-lg is-valid" value="{{max($parachute->discount_taka, $parachute->discount_gems, $parachute->discount_coins)}}" aria-describedby="inputGroupPrepend3" required="true" min="0" max="100" step="any">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-2 col-4">    
                                                            <div class="form-check form-check-inline mt-5">
                                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="taka" @if($parachute->discount_taka > 0) checked="true" @endif>
                                                                <label class="form-check-label" for="inlineCheckbox1">@ taka</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-4">
                                                            <div class="form-check form-check-inline mt-5">
                                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="gems" @if($parachute->discount_gems > 0) checked="true" @endif>
                                                                <label class="form-check-label" for="inlineCheckbox1">@ gems</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-4">
                                                            <div class="form-check form-check-inline mt-5">
                                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="coins" @if($parachute->discount_coins > 0) checked="true" @endif>
                                                                <label class="form-check-label" for="inlineCheckbox1">@ coins</label>
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
                                <div class="modal fade" id="deleteModal{{$parachute->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.delete_parachute', $parachute->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <div class="modal-body">
                                                    <p>You are about to delete.</p> 
                                                    <p class="text-muted">This may hamper gift parachutes. Please update gift items then.</p>
                                                    
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
                            {{ $parachutes->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            @if(auth()->user()->can('create'))

            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Create Parachute </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            
                            <form method="post" action= "{{ route('admin.created_parachute_submit') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServerUsername">Name</label>
                                        <div class="input-group">
                                            <input type="text" name="name" class="form-control form-control-lg is-valid" placeholder="Unique Name(required)" aria-describedby="inputGroupPrepend3" data-validation='required' data-validation-help='Name has to be unique' data-validation-error-msg='Parachute name is required and unique'>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer01">Type</label>
                                        <select class="form-control form-control-lg is-valid" name="type" readonly>
                                            <option value="parachute">Parachute</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServerUsername">Description</label>
                                        <div class="input-group">
                                            <input type="text" name="description" class="form-control form-control-lg is-valid" placeholder="Short Description" aria-describedby="inputGroupPrepend3">
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServerUsername">Price (taka)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ taka</span>
                                            </div>
                                            <input type="text" name="price_taka" class="form-control form-control-lg is-valid" placeholder="(required)" aria-describedby="inputGroupPrepend3" data-validation='required number' data-validation-allowing='float' data-validation-help='Minimun price 0 taka' data-validation-error-msg='Price taka is required'>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer01">Price (gems)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ gems</span>
                                            </div>
                                            <input type="text" name="price_gems" class="form-control form-control-lg is-valid"  placeholder="(required)" data-validation='required number' data-validation-help='Minimun price 0 gem' data-validation-error-msg='Price gem is required and numeric only'>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServerUsername">Price (coins)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ coins</span>
                                            </div>
                                            <input type="text" name="price_coins" class="form-control form-control-lg is-valid" placeholder="(required)" aria-describedby="inputGroupPrepend3" data-validation='required number' data-validation-help='Minimun price 0 coin' data-validation-error-msg='Price coin is required and numeric only'>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-4">
                                    <div class="col-md-5">
                                        <label for="validationServerUsername">Discount</label>
                                        <div class="input-group">
                                            <input type="text" name="discount" class="form-control form-control-lg is-valid" value="Discount Percentage" aria-describedby="inputGroupPrepend3" data-validation='required number' data-validation-allowing='float range[0;100]' data-validation-error-msg='Discount field is required' placeholder="Discount Percentage">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2 col-4">    
                                        <div class="form-check form-check-inline mt-5">
                                            <input name="discount_type[]" class="form-check-input" type="checkbox" value="taka">
                                            <label class="form-check-label" for="inlineCheckbox1">@ taka</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-4">
                                        <div class="form-check form-check-inline mt-5">
                                            <input name="discount_type[]" class="form-check-input" type="checkbox" value="gems">
                                            <label class="form-check-label" for="inlineCheckbox1">@ gems</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-4">
                                        <div class="form-check form-check-inline mt-5">
                                            <input name="discount_type[]" class="form-check-input" type="checkbox" value="coins">
                                            <label class="form-check-label" for="inlineCheckbox1">@ coins</label>
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