
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left"> Enabled Bundle Packs List </h3>
                    </div>

                    <div class="col-6">
                        <a href="{{route('admin.view_disabled_bundle_packs')}}" class="btn btn-outline-danger float-right" type="button">
                            Disabled Packs
                        </a>

                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal">
                            New Bundle Pack
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Bundle Pack Name</th>
                                    <th>Prices</th>
                                    <th>Offers</th>
                                    <th>Bundle Components</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                            @if($bundlePacks->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($bundlePacks as $bundlePack)
                                <tr>
                                    <td>{{ $bundlePack->name }}</td>

                                    <td>
                                        <p>{{ $bundlePack->price_taka }} (taka)</p>
                                        <p>{{ $bundlePack->price_gems }} (gems)</p>
                                        <p>{{ $bundlePack->price_coins }} (coins)</p>
                                    </td>
                                    
                                    <td>
                                        <p>{{ $bundlePack->discount_taka }}% (taka)</p>
                                        <p>{{ $bundlePack->discount_gems }}% (gems)</p>
                                        <p>{{ $bundlePack->discount_coins }}% (coins)</p>
                                    </td>
                                    
                                    <td>
                                        @foreach($bundlePack->bundleComponents as $component)

                                        <p>
                                            {{ $component->component_type }}
                                            ({{ $component->amount }})
                                        </p>

                                        @endforeach
                                    </td>
                                    
                                    <td>
                                        
                                        <a href="{{ route('admin.update_bundle_pack', $bundlePack->id) }}"  class="btn btn-outline-success" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                        </a>
                                    
                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$bundlePack->id}}" title="Delete">
                                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                        </button>

                                    {{--
                                        <a href="" class="btn btn-icon btn-pill btn-success" data-toggle="modal" data-target="#editModal{{$bundlePack->id}}" title="Edit">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                            --}}

                                    </td>
                                </tr>

                            {{--
                                <!--- Edit Modal --->
                                <div class="modal fade" id="editModal{{$bundlePack->id}}" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h3> Edit Bundle Pack </h3>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                
                                                <form method="post" action= "{{ route('admin.updated_bundle_pack_submit', $bundlePack->id) }}" enctype="multipart/form-data">

                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-row mb-4">
                                                        <div class="col-md-4">
                                                            <label for="validationServerUsername">Bundle Name</label>
                                                            <div class="input-group">
                                                                <input type="text" name="name" class="form-control form-control-lg is-invalid" value="{{ $bundlePack->name }}" aria-describedby="inputGroupPrepend3">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="validationServer01">Type</label>
                                                            <select class="form-control form-control-lg is-valid" name="type" readonly>
                                                                <option value="Bundle">Bundle Pack</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="validationServerUsername">Description</label>
                                                            <div class="input-group">
                                                                <input type="text" name="description" class="form-control form-control-lg is-valid" value="{{ $bundlePack->description }}" aria-describedby="inputGroupPrepend3">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @foreach($bundlePack->bundleComponents as $component)

                                                    <div class="form-row mb-4 newAdded">
                                                        <div class="col-md-6">
                                                            <label for="validationServer01">Bundle Component Type</label>
                                                            <select class="form-control form-control-lg is-invalid" name="elements[]" required="true">
                                                                <option selected="true" disabled="true" value="0">
                                                                    -- please select an option --
                                                                </option>
                                                                <option value="Coins Pack" @if($component->component_type=='Coins Pack') selected="true" @endif>
                                                                    Coins Pack
                                                                </option>
                                                                <option value="Gems Pack" @if($component->component_type=='Gems Pack') selected="true" @endif>
                                                                    Gems Pack
                                                                </option>

                                                                <option value="Megabyte" @if($component->component_type=='Megabyte') selected="true" @endif>
                                                                    Megabyte
                                                                </option>

                                                                @foreach(App\Models\BoostPack::all() as $boostPack)
                                                                    <option value="{{ $boostPack->name }}"  @if($boostPack->name == $component->component_type) selected="true" @endif>
                                                                        {{ $boostPack->name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="validationServerUsername">Amount</label>
                                                            <div class="input-group">
                                                                <input type="number" name="amount[]" class="form-control form-control-lg is-invalid" value="{{ $component->amount }}" aria-describedby="inputGroupPrepend3" required="true" min='1'>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @endforeach

                                                    <div id="addElement"></div>

                                                    <div class="form-row mb-4">
                                                        <div class="col-sm-9"> </div>

                                                        <div class="col-sm-3 text-right">
                                                            <i class="fa fa-plus-circle " style="font-size:30px;color:green;" id="addButton"></i>
                                                            <i class="fa fa-minus-circle" style="font-size:30px;color:red;" id="removeButton"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-row mb-4">
                                                        <div class="col-md-4">
                                                            <label for="validationServerUsername">Taka Discount</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ taka</span>
                                                                </div>
                                                                <input type="number" name="discount_taka" class="form-control form-control-lg is-invalid" value="{{ $bundlePack->discount_taka }}" step="any" required="true" min="0" max="100">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="validationServer01">
                                                                Gems Discount
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ gems</span>
                                                                </div>
                                                                <input type="number" name="discount_gems" class="form-control form-control-lg is-invalid"  value="{{ $bundlePack->discount_gems }}" step="any" required="true" min="0" max="100">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="validationServer01">Coins Discount</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ coins</span>
                                                                </div>
                                                                <input type="number" name="discount_coins" class="form-control form-control-lg is-invalid"  value="{{ $bundlePack->discount_coins }}" step="any" required="true" min="0" max="100">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="form-row mb-4">
                                                        <div class="col-md-4">
                                                            <label for="validationServerUsername">Price (taka)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ taka</span>
                                                                </div>
                                                                <input type="number" name="price_taka" class="form-control form-control-lg is-invalid" value="{{ $bundlePack->price_taka }}" aria-describedby="inputGroupPrepend3" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="validationServerUsername">Price (gems)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ gems</span>
                                                                </div>
                                                                <input type="number" name="price_gems" class="form-control form-control-lg is-invalid" value="{{ $bundlePack->price_gems }}" aria-describedby="inputGroupPrepend3" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="validationServer01">Price (coins)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ coins</span>
                                                                </div>
                                                                <input type="number" name="price_coins" class="form-control form-control-lg is-invalid"  value="{{ $bundlePack->price_coins }}" required="true">
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
                            --}}

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{$bundlePack->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.delete_bundle_pack', $bundlePack->id) }}">
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
                            {{ $bundlePacks->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <!--- Add Modal --->
            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Create Bundle Pack </h3>
                            <button type="button" class="close" data-dismiss="modal">
                                &times;
                            </button>
                        </div>

                        <div class="modal-body">
                            
                            <form method="post" action= "{{ route('admin.created_bundle_pack_submit') }}" enctype="multipart/form-data">

                                @csrf

                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServerUsername">Bundle Name</label>
                                        <div class="input-group">
                                            <input type="text" name="name" class="form-control form-control-lg is-invalid" placeholder="Unique Name(required)" aria-describedby="inputGroupPrepend3" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer01">Type</label>
                                        <select class="form-control form-control-lg is-valid" name="type" readonly>
                                            <option value="Bundle">Bundle Pack</option>
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
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServer01">Bundle Component Type</label>
                                        <select class="form-control form-control-lg is-invalid" name="elements[]" required="true">
                                            <option selected="true" disabled="true" value="0">
                                                -- please select an option --
                                            </option>
                                            <option value="Coins Pack">
                                                Coins Pack
                                            </option>
                                            <option value="Gems Pack">
                                                Gems Pack
                                            </option>
                                            <option value="Megabyte">
                                                Megabyte
                                            </option>
                                            
                                            @foreach(App\Models\BoostPack::all() as $boostPack)
                                            <option value="{{ $boostPack->name }}">
                                                {{ $boostPack->name }}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServerUsername">Amount</label>
                                        <div class="input-group">
                                            <input type="number" name="amount[]" class="form-control form-control-lg is-invalid" placeholder="Amount of Component" aria-describedby="inputGroupPrepend3" required="true" min='1'>
                                        </div>
                                    </div>
                                </div>

                                <div id="addElement"></div>

                                <div class="form-row">
                                    <div class="col-sm-9 mb-4"> </div>

                                    <div class="col-sm-3 text-right mb-4">
                                        <i class="fa fa-plus-circle " style="font-size:30px;color:green;" id="addButton"></i>
                                        <i class="fa fa-minus-circle" style="font-size:30px;color:red;" id="removeButton"></i>
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
                                        <label for="validationServerUsername">Price (gems)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ gems</span>
                                            </div>
                                            <input type="number" name="price_gems" class="form-control form-control-lg is-invalid" placeholder="(required)" aria-describedby="inputGroupPrepend3" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer01">Price (coins)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ coins</span>
                                            </div>
                                            <input type="number" name="price_coins" class="form-control form-control-lg is-invalid"  placeholder="(required)" required="true">
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

        <script> 

            $("#addButton").click(function(){
                var html = "<div class='form-row newAdded'>"+
                                    "<div class='col-md-6 mb-4'>"+
                                        "<label for='validationServer01'>Bundle Component Type</label>"+
                                        "<select class='form-control form-control-lg is-invalid' name='elements[]' required>"+
                                            "<option value='0' selected disabled>"+
                                                "--please select an option--"+
                                            "</option>"+
                                            "<option value='Coins Pack'>"+
                                                "Coins Pack"+
                                            "</option>"+
                                            "<option value='Gems Pack'>"+
                                                "Gems Pack"+
                                            "</option>"+

                                            "<option value='Megabyte'>"+
                                                "Megabyte"+
                                            "</option>"+

                                            "@foreach(App\Models\BoostPack::all() as $boostPack)"+
                                            "<option value='{{ $boostPack->name }}'>"+
                                                "{{ $boostPack->name }}"+
                                            "</option>"+
                                            "@endforeach"+

                                        "</select>"+
                                    "</div>"+
                                    "<div class='col-md-6 mb-4'>"+
                                        "<label for='validationServerUsername'>Amount</label>"+
                                        "<div class='input-group'>"+
                                            "<input type='number' name='amount[]' class='form-control form-control-lg is-invalid' placeholder='Amount of Component' aria-describedby='inputGroupPrepend3' required min='1'>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";

                $("#addElement").append(html);
            }); 

            $("#removeButton").click(function(){
                $(".newAdded:last").remove();
            });     
        </script>
@stop