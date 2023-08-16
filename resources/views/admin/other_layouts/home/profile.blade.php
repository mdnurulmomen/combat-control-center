@extends('admin.master_layout.app')
@section('contents')

    <div class="row user">
        <div class="col-md-12">
          <div class="profile">
                <div class="info">
                    <img src="{{ asset('assets/admin/images/profile/'.$profile->picture) }}" class="img-thumbnail" alt="No Image">
                    <h4>{{ $profile->full_name }}</h4>
                </div>
            
                <div class="col-md-9">
                    
                    <div class="tile user-settings mb-0">
                        <h4 class="line-head">Settings</h4>
                
                        <form method="post" action= "{{ route('admin.updated_profile_submit') }}" enctype="multipart/form-data">
                            @csrf
                            @Method('put')
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">First name</label>
                                    <input type="text" name="firstname" class="form-control form-control-lg is-valid"  placeholder="First Name" value="{{ $profile->firstname }}">

                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="validationServer02">Last name</label>
                                    <input type="text" name="lastname" class="form-control form-control-lg is-valid"  placeholder="Last Name" value="{{ $profile->lastname }}">
                                </div>
                            </div>
                          
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">Email</label>
                                    <input type="text" name="email" class="form-control form-control-lg is-valid"  placeholder="Email" value="{{ $profile->email }}"  data-validation="required email" data-validation-error-msg="Please input a valid email">

                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="validationServerUsername">Username</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@</span>
                                        </div>
                                        <input type="text" name="username" class="form-control form-control-lg is-valid" placeholder="Username" value="{{ $profile->username }}" aria-describedby="inputGroupPrepend3"  data-validation="alphanumeric length" data-validation-length="5-20" data-validation-allowing="-_" data-validation-error-msg="No space or special character in minimum 5 characters username" >
                                    </div>
                                </div>
                            </div>
                          
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="validationServer02">Picture</label>
                                    <input type="file" name="picture" class="form-control form-control-lg" accept="image/*" data-validation="mime size" data-validation-allowing="jpg,jpeg,png" data-validation-max-size="5M">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">Phone</label>
                                    <input type="tel" name="phone" class="form-control form-control-lg is-valid"  placeholder="Phone Number" value="{{ $profile->phone }}" data-validation="number length"  data-validation-optional="true" data-validation-length="max11" data-validation-error-msg="Please input correct phone number">

                                </div>
                            </div>
                  
                            <div class="form-row">
                                <div class="col-md-4 mb-4">
                                    <label for="validationServer02">Address</label>
                                    <input type="text" name="address" class="form-control form-control-lg is-valid"  placeholder="Address" value="{{ $profile->address }}">

                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="validationServer03">City</label>
                                    <input type="text" name="city" value="{{ $profile->city }}" class="form-control form-control-lg is-valid" placeholder="City">

                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="validationServer05">Country</label>
                                    <input type="text" name="country" value="{{ $profile->country }}" class="form-control form-control-lg is-valid" placeholder="Country Name">
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
    </div>
@stop