@extends('admin.master_layout.app')
@section('contents')
    <div class="content p-4">
        <div class="card mb-4">
            <div class="card-body">
                <h3> Rules Settings </h3>
                <hr class="mb-4">
                <form method="post" action = "{{ route('admin.settings_rules_submit') }}" enctype="multipart/form-data">
                    @csrf
                    @Method('put')

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="validationServer02">User Registration :</label>
                            <input type="checkbox" name="user_registration" @if($settingsUser->user_registration==1) checked @endif  data-toggle="toggle" data-on="Allowed" data-off="Not Allowed" data-onstyle="success" data-offstyle="danger">
                        </div>
                        <div class="col-md-4">
                            <label for="validationServer02">Email Verification :</label>
                            <input type="checkbox" name="email_verification" @if($settingsUser->email_verification==1) checked @endif  data-toggle="toggle" data-on="Allowed" data-off="Not Allowed" data-onstyle="success" data-offstyle="danger">
                        </div>
                        <div class="col-md-4">
                            <label for="validationServer02">SMS Verification :</label>
                            <input type="checkbox" name="sms_verification" @if($settingsUser->sms_verification==1) checked @endif data-toggle="toggle" data-on="Allowed" data-off="Not Allowed" data-onstyle="success" data-offstyle="danger">
                        </div>
                    </div>
                  
                    <br>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-block btn-primary">Update</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop