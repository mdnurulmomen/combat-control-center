
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left"> Enabled Treasures List </h3>
                </div>

                <div class="col-6">
                    <button type="button" class="btn btn-info float-right mr-3 ml-3" data-toggle="modal" data-target="#addType">
                        New Treasure Type
                    </button>

                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal">
                        New Treasure
                    </button>
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
                                <th class="actions">Actions</th>
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
                                <td>

                                    <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$treasure->id}}">
                                        <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                    </button>

                                    <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$treasure->id}}" title="Delete">
                                        <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                    </button>
                                        
                                </td>
                            </tr>

                        
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

                                                    <select class="form-control form-control-lg is-invalid" name="treasure_type_id" required="true">
                                                        
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
                                                        <input step="any" type="text" name="name" class="form-control form-control-lg is-valid"  value="{{ $treasure->name }}">
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
                                                <div class="col-md-4 mb-4">
                                                    <label for="validationServer01">Approximate Cost</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">@ taka</span>
                                                        </div>
                                                        <input type="number" name="equivalent_price" class="form-control form-control-lg is-invalid" value="{{ $treasure->equivalent_price }}" required="true">
                                                    </div>
                                                </div>

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
                                                        <input type="number" name="exchanging_gems" class="form-control form-control-lg is-valid" value="{{ $treasure->exchanging_gems }}"  aria-describedby="inputGroupPrepend3" step="any">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServerUsername">Collecting Point</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">@ place</span>
                                                        </div>
                                                        <input type="text" name="collecting_point" class="form-control form-control-lg is-valid" value="{{ $treasure->collecting_point }}" aria-describedby="inputGroupPrepend3">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServerUsername">Durability</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">@ days</span>
                                                        </div>
                                                        <input type="number" name="durability" class="form-control form-control-lg is-valid" value="{{ $treasure->durability }}"  aria-describedby="inputGroupPrepend3" step="any">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-12 mb-4">
                                                    <label for="validationServerUsername">Description</label>
                                                    <div class="input-group">
                                                        <textarea  class="form-control form-control-lg is-valid" name="description" rows="3" placeholder="A Short Description">{{ $treasure->description }}</textarea>
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
                                

                        @endforeach
                        </tbody>
                    </table>

                    <div class="float-right">
                        {{ $treasures->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>

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

                                    <select class="form-control form-control-lg is-invalid" name="treasure_type_id" required="true">
                                        
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
                                        <input step="any" type="text" name="name" class="form-control form-control-lg is-valid"  placeholder="Treasure Name">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="validationServer01">Treasure Amount</label>
                                    <div class="input-group">
                                        <input type="number" name="amount" class="form-control form-control-lg is-valid" placeholder="Amount of product" min="1">
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-4">
                                    <label for="validationServer01">Approximate Cost</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ taka</span>
                                        </div>
                                        <input type="number" name="equivalent_price" class="form-control form-control-lg is-invalid"  placeholder="Equivalent Cost" required="true">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="validationServerUsername">Exchanging Coins</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ coins</span>
                                        </div>
                                        <input type="number" name="exchanging_coins" class="form-control form-control-lg is-valid" placeholder="Exchanging Coins"aria-describedby="inputGroupPrepend3" min="1">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="validationServerUsername">Exchanging Gems</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ gems</span>
                                        </div>
                                        <input type="number" name="exchanging_gems" class="form-control form-control-lg is-valid" placeholder="Exchanging Gems" aria-describedby="inputGroupPrepend3" min="1">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="validationServerUsername">Collecting Point</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ place</span>
                                        </div>
                                        <input type="text" name="collecting_point" class="form-control form-control-lg is-valid" placeholder="Please Leave if Unspecific" aria-describedby="inputGroupPrepend3">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="validationServerUsername">Durability</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@ days</span>
                                        </div>
                                        <input type="number" name="durability" class="form-control form-control-lg is-valid" placeholder="Please Leave if Unlimited" aria-describedby="inputGroupPrepend3" step="any">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-4">
                                    <label for="validationServerUsername">Description</label>
                                    <div class="input-group">
                                        <textarea  class="form-control form-control-lg is-valid" name="description" rows="3" placeholder="A Short Description"></textarea>
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
                                        <input step="any" type="text" name="treasure_type_name" class="form-control form-control-lg is-invalid"  placeholder="Type Name" required="true">
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