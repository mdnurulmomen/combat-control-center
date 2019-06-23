
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left"> Enabled Characters List </h3>
                    </div>

                    <div class="col-6">
                        <a href="{{route('admin.view_disabled_characters')}}" class="btn btn-outline-danger float-right" type="button">
                            Disabled Characters
                        </a>

                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal">
                            New Character
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>Character Name</th>
                                <th>Prices</th>
                                <th>Discounts</th>
                                <th class="actions">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($characters->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($characters as $character)
                                <tr>
                                    <td>{{ $character->name }}</td>

                                    <td>
                                        <p>{{ $character->price_taka }} taka</p>
                                        <p>{{ $character->price_gems }} gems</p>
                                        <p>{{ $character->price_coins }} coins</p>
                                    </td>
                                    
                                    <td>
                                        <p>{{ $character->discount_taka }}% (taka)</p>
                                        <p>{{ $character->discount_gems }}% (gems)</p>
                                        <p>{{ $character->discount_coins }}% (coins)</p>
                                    </td>

                                    <td>
                                        
                                        <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$character->id}}" title="Edit">
                                            <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                        </button>

                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$character->id}}" title="Delete">
                                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i> 
                                        </button>

                                    {{--
                                        <a href="{{ route('admin.update_character', $character->id) }}" class="btn btn-icon btn-pill btn-success" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                            --}}
                                    </td>
                                </tr>
         
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{$character->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.delete_character', $character->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">
                                                    <p>Are You Sure ??</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">
                                                        Yes
                                                    </button>
                                                    
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                                    

                                <!---Edit Modal -->
                                <div class="modal fade" id="editModal{{$character->id}}" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h3> Edit Character </h3>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                
                                                <form method="post" action = "{{ route('admin.updated_character_submit', $character->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @Method('put')
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Name</label>
                                                            <div class="input-group">
                                                                <input type="text" name="name" class="form-control form-control-lg is-invalid" value="{{ $character->name }}" aria-describedby="inputGroupPrepend3" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Type</label>
                                                            <select class="form-control form-control-lg is-valid" name="type">
                                                                <option value="character">Character</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Description</label>
                                                            <div class="input-group">
                                                                <input type="text" name="description" class="form-control form-control-lg is-valid" value="{{ $character->description }}" aria-describedby="inputGroupPrepend3">
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
                                                                <input type="number" name="price_taka" class="form-control form-control-lg is-invalid"  value="{{ $character->price_taka }}" required="true" step="any">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Price (gems)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ gems</span>
                                                                </div>
                                                                <input type="number" name="price_gems" class="form-control form-control-lg is-invalid"  value="{{ $character->price_gems }}" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Price (coins)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ coins</span>
                                                                </div>
                                                                <input type="number" name="price_coins" class="form-control form-control-lg is-invalid" value="{{ $character->price_coins }}" required="true">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row mb-4">
                                                        <div class="col-md-5">
                                                            <label for="validationServerUsername">Discount</label>
                                                            <div class="input-group">
                                                                <input step="any" type="number" name="discount" class="form-control form-control-lg is-invalid" value="{{max($character->discount_taka, $character->discount_gems, $character->discount_coins)}}" aria-describedby="inputGroupPrepend3" required="true" min="0" max="100">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-2 col-4">    
                                                            <div class="form-check form-check-inline mt-5">
                                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="taka" @if($character->discount_taka > 0) checked="true" @endif>
                                                                <label class="form-check-label" for="inlineCheckbox1">@ taka</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-4">
                                                            <div class="form-check form-check-inline mt-5">
                                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="gems" @if($character->discount_gems > 0) checked="true" @endif>
                                                                <label class="form-check-label" for="inlineCheckbox1">@ gems</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-4">
                                                            <div class="form-check form-check-inline mt-5">
                                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="coins" @if($character->discount_coins > 0) checked="true" @endif>
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

                            @endforeach
                            </tbody>
                        </table>
                        <div class="float-right">
                            {{ $characters->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Create Character </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            
                            <form method="post" action= "{{ route('admin.created_character_submit') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServerUsername">Name</label>
                                        <div class="input-group">
                                            <input type="text" name="name" class="form-control form-control-lg is-invalid" placeholder="Unique Name(required)" aria-describedby="inputGroupPrepend3" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer01">Type</label>
                                        <select class="form-control form-control-lg is-valid" name="type" readonly>
                                            <option value="character">Character</option>
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
                                            <input type="number" name="price_taka" class="form-control form-control-lg is-invalid" placeholder="(required)" aria-describedby="inputGroupPrepend3" required="true" step="any">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer01">Price (gems)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ gems</span>
                                            </div>
                                            <input type="number" name="price_gems" class="form-control form-control-lg is-invalid"  placeholder="(required)" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServerUsername">Price (coins)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ coins</span>
                                            </div>
                                            <input type="number" name="price_coins" class="form-control form-control-lg is-invalid" placeholder="(required)" aria-describedby="inputGroupPrepend3" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-4">
                                    <div class="col-md-5">
                                        <label for="validationServerUsername">Discount</label>
                                        <div class="input-group">
                                            <input step="any" type="number" name="discount" class="form-control form-control-lg is-invalid" placeholder="Discount Percentage" aria-describedby="inputGroupPrepend3" required="true" min="0" max="100">
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

        </div>

@stop