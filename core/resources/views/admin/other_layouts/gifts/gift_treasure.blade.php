@extends('admin.master_layout.app')
@section('contents')
    <div class="content p-4">
        
        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                <h3> Gift Treasure </h3>
            </div>
            <div class="card-body">
                <form method="post" action = "{{ route('admin.settings_gift_treasure_submit') }}">

                    @csrf
                    @Method('put')

                    <div class="form-row">

                        <div class="col-md-6 mb-4">
                          <label for="validationServer01">Treasure Name</label>
                          <select class="form-control form-control-lg" name="treasure_id">
                              @foreach($allTreasures as $treasure)

                                <option value="{{$treasure->id}}" @if($treasure->id == $giftTreasure->treasure_id) selected="true" @endif>
                                  {{$treasure->name}}
                                </option>

                              @endforeach
                          </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="validationServerUsername">Required Percentage</label>
                            <div class="input-group">
                                <input type="number" name="required_percentage" class="form-control form-control-lg is-valid" value="{{ $giftTreasure->required_percentage }}" aria-describedby="inputGroupPrepend3" min="100" step="any">

                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
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
@stop