@extends('admin.master_layout.app')
@section('contents')
    <div class="content p-4">
        
        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                <h3> Gift Animations </h3>
            </div>
            <div class="card-body">
                <form method="post" action = "{{ route('admin.settings_gift_animations_submit') }}">

                    @csrf
                    @Method('put')

                    <div class="form-row mt-2 p-2 pt-3 mb-5 text-center text-white bg-dark">
                       <div class="col-md-2 col-2 mb-4">
                           <h5>Animation Serial</h5>
                       </div> 

                       <div class="col-md-4 col-4 mb-4">
                           <h5>Animation Name</h5>
                       </div> 

                       <div class="col-md-6 col-6 mb-4">
                           <h5>Select For Gift</h5>
                       </div> 

                    </div>

                    <div class="form-row mb-4 text-center">

                        @foreach($allAnimations as $key => $animation)

                        <div class="col-md-2 col-2 mb-4">{{$key + 1}}</div>

                        <div class="col-md-4 col-4 mb-4">
                            <label for="validationServer01">{{ $animation->name }}</label>
                        </div>

                        <div class="col-md-6 col-6 mb-4">
                            <select class="form-control form-control-lg" id="selector" name="gift_animation_index[]">
                                <option value="-1" selected>Not Selected</option>
                                <option value="{{$key}}" @if(in_array($key, $giftAnimations)) selected="true" @endif>Selected</option>
                            </select>
                        </div>

                        @endforeach
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