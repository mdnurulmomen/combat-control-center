@extends('admin.master_layout.app')
@section('contents')

    <div class="card">
        <div class="card-header bg-white font-weight-bold">
            <h3 class="mb-4"> Admin Profile Setting </h3>
        </div>
        <legend class="text-center">
            <img src="{{ asset('assets/admin/images/profile/'.$profile->picture) }}" class="img-thumbnail" alt="No Image">
        </legend>
        <div class="card-body">
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
                        <input type="text" name="email" class="form-control form-control-lg is-valid"  placeholder="Email" value="{{ $profile->email }}">

                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="validationServerUsername">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="text" name="username" class="form-control form-control-lg is-invalid" placeholder="Username" value="{{ $profile->username }}" aria-describedby="inputGroupPrepend3">
                        </div>
                    </div>
                </div>
              
                <div class="form-row">
                    <div class="col-md-6 mb-4">
                        <label for="validationServer02">Picture</label>
                        <input type="file" name="picture" class="form-control form-control-lg" accept="image/*">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="validationServer01">Phone</label>
                        <input type="tel" name="phone" class="form-control form-control-lg is-valid"  placeholder="Phone Number" value="{{ $profile->phone }}">

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

@stop