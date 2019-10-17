
@extends('admin.master_layout.app')
@section('contents')
    <div class="content p-4">
        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                <h3> Password Setting </h3>
            </div>
            <div class="card-body">
                <form method="post" action = "{{ route('admin.updated_password_submit') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label"> Current Password: </label>
                        <div class="col-sm-10">
                            <input type="password" name="currentPassword" class="form-control form-control-lg" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label"> New Password: </label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control form-control-lg" minlength=8  required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label"> Confirm Password: </label>
                        <div class="col-sm-10">
                            <input type="password" name="password_confirmation" class="form-control form-control-lg"  required>
                        </div>
                    </div>
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