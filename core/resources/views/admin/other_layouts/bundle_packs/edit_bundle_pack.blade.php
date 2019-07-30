@extends('admin.master_layout.app')
@section('contents')

    <div class="card">
        <div class="card-body">
            
            @if(auth()->user()->can('update'))
            
            <!--- Add Modal --->
            
            <h3> Bundle Pack Editing </h3>

            <hr class="mb-4">            
        
            
            <form method="post" action= "{{ route('admin.updated_bundle_pack_submit', $bundlePackToUpdate->id) }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">
                    
                    <div class="col-md-6">

                        <h4>Bundle Introduction</h4>

                        <div class="tile">    
                            <div class="tile-body">    
                                <div class="form-row">
                                    <div class="col-md-12 mb-4">
                                        <label for="validationServerUsername">Bundle Name</label>
                                        <div class="input-group">
                                            <input type="text" name="name" class="form-control form-control-lg @if($errors->has('name')) is-invalid @endif" value="{{ $bundlePackToUpdate->name }}" aria-describedby="inputGroupPrepend3" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label for="validationServer01">Type</label>
                                        <select class="form-control form-control-lg is-valid" name="type" readonly>
                                            <option value="Bundle">Bundle Pack</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label for="validationServerUsername">Description</label>
                                        <div class="input-group">
                                            <input type="text" name="description" class="form-control form-control-lg is-valid" value="{{ $bundlePackToUpdate->description }}" aria-describedby="inputGroupPrepend3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4>Price Details</h4>
                        <div class="tile">
                            <div class="tile-body">
                                
                                <div class="form-row">
                                    <div class="col-md-12 mb-4">
                                        <label for="validationServerUsername">Price (taka)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ taka</span>
                                            </div>
                                            <input type="number" name="price_taka" class="form-control form-control-lg @if($errors->has('price_taka')) is-invalid @endif" value="{{ $bundlePackToUpdate->price_taka }}" aria-describedby="inputGroupPrepend3" required="true" step="any">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label for="validationServerUsername">Price (gems)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ gems</span>
                                            </div>
                                            <input type="number" name="price_gems" class="form-control form-control-lg @if($errors->has('price_gems')) is-invalid @endif" value="{{ $bundlePackToUpdate->price_gems }}" aria-describedby="inputGroupPrepend3" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label for="validationServer01">Price (coins)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ coins</span>
                                            </div>
                                            <input type="number" name="price_coins" class="form-control form-control-lg @if($errors->has('price_coins')) is-invalid @endif" value="{{ $bundlePackToUpdate->price_coins }}" required="true">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12">

                        <h4>Component Details</h4>

                        <div class="tile">
                            <div class="tile-body">
                                
                                @foreach($bundlePackToUpdate->bundleComponents as $component)
                                
                                <div class="form-row newAdded">
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServer01">Component Type</label>
                                        <select class="form-control form-control-lg @if($errors->has('elements')) is-invalid @endif" name="elements[]" required="true">
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
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServerUsername">Component Amount</label>
                                        <div class="input-group">
                                            <input type="number" name="amount[]" class="form-control form-control-lg @if($errors->has('amount')) is-invalid @endif" value="{{ $component->amount }}" aria-describedby="inputGroupPrepend3" required="true" min='1'>
                                        </div>
                                    </div>
                                </div>

                                @endforeach

                                <div id="addElement"></div>

                                <div class="form-row">
                                    <div class="col-sm-9 mb-4"> </div>

                                    <div class="col-sm-3 text-right mb-4">
                                        <i class="fa fa-plus-circle " style="font-size:30px;color:green;" id="addButton"></i>
                                        <i class="fa fa-minus-circle" style="font-size:30px;color:red;" id="removeButton"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-md-12">
                        <h4>Discount Details</h4>
                        <div class="tile">
                            <div class="tile-body">
                                
                                <div class="form-row mb-4">
                                    <div class="col-md-4 col-12">
                                        <label for="validationServerUsername">Discount</label>
                                        <div class="input-group">
                                            <input type="number" name="discount" class="form-control form-control-lg" value="{{max($bundlePackToUpdate->discount_taka, $bundlePackToUpdate->discount_gems, $bundlePackToUpdate->discount_coins)}}" aria-describedby="inputGroupPrepend3" required="true" min="0" max="100" step="any">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2 col-4">    
                                        <div class="form-check form-check-inline mt-5">
                                            <input name="discount_type[]" class="form-check-input" type="checkbox" value="taka" @if($bundlePackToUpdate->discount_taka > 0) checked="true" @endif>
                                            <label class="form-check-label" for="inlineCheckbox1">@ taka</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-4">
                                        <div class="form-check form-check-inline mt-5">
                                            <input name="discount_type[]" class="form-check-input" type="checkbox" value="gems" @if($bundlePackToUpdate->discount_gems > 0) checked="true" @endif>
                                            <label class="form-check-label" for="inlineCheckbox1">@ gems</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-4">
                                        <div class="form-check form-check-inline mt-5">
                                            <input name="discount_type[]" class="form-check-input" type="checkbox" value="coins" @if($bundlePackToUpdate->discount_coins > 0) checked="true" @endif>
                                            <label class="form-check-label" for="inlineCheckbox1">@ coins</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                                  

                <br>

                <div class="form-row">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-lg btn-block btn-primary">Update</button>
                    </div>
                </div>
            </form>    
                
            @endif

        </div>
    </div>

@stop
    
@push('scripts')

    <script>  

        $("#addButton").click(function(){
            var html = "<div class='form-row mb-4 newAdded'>"+
                                "<div class='col-md-6 mb-4'>"+
                                    "<label for='validationServer01'>Component Type</label>"+
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
                                    "<label for='validationServerUsername'>Component Amount</label>"+
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

@endpush