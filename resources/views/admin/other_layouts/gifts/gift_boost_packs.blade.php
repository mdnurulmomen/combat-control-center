@extends('admin.master_layout.app')
@section('contents')
    <div class="content p-4">
        
        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                <h3> Gifts Boost Packs </h3>
            </div>
            <div class="card-body">
                <form method="post" action = "{{ route('admin.settings_gift_boost_packs_submit') }}">

                    @csrf
                    @Method('put')

                    <div class="form-row">
                        <div class="col-md-3 mb-4">
                            <label for="validationServer01">Gift Melee Boost</label>
                            <input type="text" name="gift_melee_boost" class="form-control form-control-lg is-valid" value="{{ $allGiftBoostPacks->gift_melee_boost }}" data-validation="number required" data-validation-allowing="range[0;10000000]" data-validation-help="Hints : Range 0 to 10000000." data-validation-error-msg="Only numeric value is allowed">
                        </div>

                        <div class="col-md-3 mb-4">
                            <label for="validationServer01">Gift Light Boost</label>
                            <input type="text" name="gift_light_boost" class="form-control form-control-lg is-valid" value="{{ $allGiftBoostPacks->gift_light_boost }}" data-validation="number required" data-validation-allowing="range[0;10000000]" data-validation-help="Hints : Range 0 to 10000000." data-validation-error-msg="Only numeric value is allowed">
                        </div>


                        <div class="col-md-3 mb-4">
                            <label for="validationServer01">Gift Heavy Boost</label>
                            <input type="text" name="gift_heavy_boost" class="form-control form-control-lg is-valid" value="{{ $allGiftBoostPacks->gift_heavy_boost }}" data-validation="number required" data-validation-allowing="range[0;10000000]" data-validation-help="Hints : Range 0 to 10000000." data-validation-error-msg="Only numeric value is allowed">
                        </div>
                        

                        <div class="col-md-3 mb-4">
                            <label for="validationServer01">Gift Ammo Boost</label>
                            <input type="text" name="gift_ammo_boost" class="form-control form-control-lg is-valid" value="{{ $allGiftBoostPacks->gift_ammo_boost }}" data-validation="number required" data-validation-allowing="range[0;10000000]" data-validation-help="Hints : Range 0 to 10000000." data-validation-error-msg="Only numeric value is allowed">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-3 mb-4">
                            <label for="validationServer01">Gift Armor Boost</label>
                            <input type="text" name="gift_armor_boost" class="form-control form-control-lg is-valid" value="{{ $allGiftBoostPacks->gift_armor_boost }}" data-validation="number required" data-validation-allowing="range[0;10000000]" data-validation-help="Hints : Range 0 to 10000000." data-validation-error-msg="Only numeric value is allowed">
                        </div>

                        <div class="col-md-3 mb-4">
                            <label for="validationServer01">Gift Range Boost</label>
                            <input type="text" name="gift_range_boost" class="form-control form-control-lg is-valid" value="{{ $allGiftBoostPacks->gift_range_boost }}" data-validation="number required" data-validation-allowing="range[0;10000000]" data-validation-help="Hints : Range 0 to 10000000." data-validation-error-msg="Only numeric value is allowed">
                        </div>


                        <div class="col-md-3 mb-4">
                            <label for="validationServer01">Gift Speed Boost</label>
                            <input type="text" name="gift_speed_boost" class="form-control form-control-lg is-valid" value="{{ $allGiftBoostPacks->gift_speed_boost }}" data-validation="number required" data-validation-allowing="range[0;10000000]" data-validation-help="Hints : Range 0 to 10000000." data-validation-error-msg="Only numeric value is allowed">
                        </div>
                        
                        <div class="col-md-3 mb-4">
                            <label for="validationServer01">Gift Xp Multiplier</label>
                            <input type="text" name="gift_multiplier_boost" class="form-control form-control-lg is-valid" value="{{ $allGiftBoostPacks->gift_multiplier_boost }}" data-validation="number required" data-validation-allowing="range[0;10000000]" data-validation-help="Hints : Range 0 to 10000000." data-validation-error-msg="Only numeric value is allowed">
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
@stop