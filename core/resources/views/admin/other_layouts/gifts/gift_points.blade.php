@extends('admin.master_layout.app')
@section('contents')
    <div class="content p-4">
        
        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                <h3> Gifts Boost Packs </h3>
            </div>
            <div class="card-body">
                <form method="post" action = "{{ route('admin.setting_gift_points_submit') }}">

                    @csrf
                    @Method('put')

                    <div class="form-row">
                        <div class="col-md-6 mb-4">
                            <label for="validationServer01">Gift Coins</label>
                            <input type="number" name="gift_coins" class="form-control form-control-lg is-valid" value="{{ $allGiftPoints->gift_coins }}" required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="validationServer01">Gift Gems</label>
                            <input type="number" name="gift_gems" class="form-control form-control-lg is-valid" value="{{ $allGiftPoints->gift_gems }}" required>
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