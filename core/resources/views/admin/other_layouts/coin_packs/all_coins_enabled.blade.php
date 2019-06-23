
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left">Enabled Coin Packs List </h3>
                    </div>

                    <div class="col-6">
                        <a href="{{route('admin.view_disabled_coin_packs')}}" class="btn btn-outline-danger float-right" type="button">
                            Disabled Packs
                        </a>

                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal">
                            New Coins Pack
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>Coin Pack Name</th>
                                <th>Amount</th>
                                <th>Prices</th>
                                <th>Discounts</th>
                                <th class="actions">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($coins->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($coins as $coin)
                                <tr>
                                    <td>{{ $coin->name }}</td>
                                    <td>{{ $coin->amount }}</td>
                                    <td>
                                        <p>{{ $coin->price_taka }} taka</p>
                                        <p>{{ $coin->price_gems }} gems</p>
                                    </td>
                                    
                                    <td>
                                        <p>{{ $coin->discount_taka }}% (taka)</p>
                                        <p>{{ $coin->discount_gems }}% (gems)</p>
                                    </td>

                                    <td>
                                    {{--
                                        <a href="{{ route('admin.update_coin_pack', $coin->id) }}" class="btn btn-icon btn-pill btn-success" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                            --}}
                                            
                                        <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$coin->id}}" title="Edit">
                                            <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                        </button>    

                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$coin->id}}" title="Delete">
                                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                        </button>

                                    </td>
                                </tr>


                                <!--- Edit Modal --->
                                <div class="modal fade" id="editModal{{$coin->id}}" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h3> Edit Coin Pack </h3>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                
                                                <form method="post" action = "{{ route('admin.updated_coin_pack_submit', $coin->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @Method('put')
                                                    <div class="form-row">
                                                        <div class="col-md-3 mb-4">
                                                            <label for="validationServerUsername">Name</label>
                                                            <div class="input-group">
                                                                <input type="text" name="name" class="form-control form-control-lg is-valid" value="{{ $coin->name }}" aria-describedby="inputGroupPrepend3">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-4">
                                                            <label for="validationServer01">Type</label>
                                                            <select class="form-control form-control-lg is-valid" name="type">
                                                                <option value="Coins Pack">Coins Pack</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-4">
                                                            <label for="validationServerUsername">Amount</label>
                                                            <div class="input-group">
                                                                <input type="number" name="amount" class="form-control form-control-lg is-invalid" value="{{ $coin->amount }}" aria-describedby="inputGroupPrepend3" required="true" min='1'>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-4">
                                                            <label for="validationServerUsername">Description</label>
                                                            <div class="input-group">
                                                                <input type="text" name="description" class="form-control form-control-lg is-valid" value="{{ $coin->description }}" aria-describedby="inputGroupPrepend3">
                                                            </div>
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServer01">Price (taka)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ taka</span>
                                                                </div>
                                                                <input type="number" name="price_taka" class="form-control form-control-lg is-invalid"  value="{{ $coin->price_taka }}" required="true" step="any">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServer01">Price (gems)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ gems</span>
                                                                </div>
                                                                <input type="number" name="price_gems" class="form-control form-control-lg is-invalid"  value="{{ $coin->price_gems }}" required="true">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row mb-4">
                                                        <div class="col-md-5">
                                                            <label for="validationServerUsername">Discount</label>
                                                            <div class="input-group">
                                                                <input step="any" type="number" name="discount" class="form-control form-control-lg is-invalid" value="{{max($coin->discount_taka, $coin->discount_gems, $coin->discount_coins)}}" aria-describedby="inputGroupPrepend3" required="true" min="0" max="100">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1 col-2"></div>
                                                        <div class="col-md-2 col-4">    
                                                            <div class="form-check form-check-inline mt-5">
                                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="taka" @if($coin->discount_taka > 0) checked="true" @endif>
                                                                <label class="form-check-label" for="inlineCheckbox1">@ taka</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-4">
                                                            <div class="form-check form-check-inline mt-5">
                                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="gems" @if($coin->discount_gems > 0) checked="true" @endif>
                                                                <label class="form-check-label" for="inlineCheckbox1">@ gems</label>
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

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{$coin->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.delete_coin_pack', $coin->id) }}">
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

                            @endforeach
                            </tbody>
                        </table>
                        
                        <div class="float-right">
                            {{ $coins->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Create Coin Pack </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            
                            <form method="post" action= "{{ route('admin.created_coin_pack_submit') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-row">
                                    <div class="col-md-3 mb-4">
                                        <label for="validationServerUsername">Name</label>
                                        <div class="input-group">
                                            <input type="text" name="name" class="form-control form-control-lg is-valid" placeholder="Name of Coin Pack" aria-describedby="inputGroupPrepend3">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <label for="validationServer01">Type</label>
                                        <select class="form-control form-control-lg is-valid" name="type" readonly>
                                            <option value="Coins Pack">Coins Pack</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <label for="validationServerUsername">Amount</label>
                                        <div class="input-group">
                                            <input type="number" name="amount" class="form-control form-control-lg is-invalid" placeholder="Unique Amount(required)" aria-describedby="inputGroupPrepend3" required="true" min='1'>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <label for="validationServerUsername">Description</label>
                                        <div class="input-group">
                                            <input type="text" name="description" class="form-control form-control-lg is-valid" placeholder="Short Description" aria-describedby="inputGroupPrepend3">
                                        </div>
                                    </div>
                                </div>
                              
                                <div class="form-row">
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServerUsername">Price (taka)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ taka</span>
                                            </div>
                                            <input type="number" name="price_taka" class="form-control form-control-lg is-invalid" placeholder="(required)" aria-describedby="inputGroupPrepend3" required="true" step="any">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServer01">Price (gems)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ gems</span>
                                            </div>
                                            <input type="number" name="price_gems" class="form-control form-control-lg is-invalid"  placeholder="(required)" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-4">
                                    <div class="col-md-5">
                                        <label for="validationServerUsername">Discount</label>
                                        <div class="input-group">
                                            <input type="number" name="discount" class="form-control form-control-lg is-invalid" placeholder="Discount Percentage" aria-describedby="inputGroupPrepend3" required="true" min="0" max="100" step="any">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-2"></div>
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

        </div>
@stop