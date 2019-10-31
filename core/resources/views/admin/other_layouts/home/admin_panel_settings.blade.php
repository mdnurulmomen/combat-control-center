@extends('admin.master_layout.app')
@section('contents')
    <div class="content p-4">
        
        <div class="card mb-4">

            <div class="card-body">
                <h3> Admin Panel Settings </h3>
                <hr class="mb-4">
                <form method="post" action = "{{ route('admin.settings_admin_panel_submit') }}" enctype="multipart/form-data">

                    @csrf
                    @method('put')

                    <div class="form-group form-row">
                        
                        <div class="col-md-4 mb-4">
                            <label for="validationServer02">Admin Panel Favicon</label>
                            <div>
                                <img src="{{asset('assets/admin/images/settings/favicon.png')}}" class="float-center" alt="favicon" width="50">
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="validationServer02">Upload Favicon</label>

                            <input type="file" name="favicon" class="form-control form-control-lg is-valid" accept="image/*" data-validation="required mime size" data-validation-allowing="jpg, png" data-validation-max-size="5M">
                        </div>


                        {{--

                        <div class="col-md-6 mb-4">
                            <label for="validationServer02">Game Color</label>
                            <input type="text" name="color" value="{{ $color }}" class="form-control form-control-lg is-valid" onkeyup="backgroundColor()">
                        </div>
                            --}}
                            
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

    <script>
        /*
        function backgroundColor () {
            var inputSelected = document.getElementsByName("color")[0];
            inputSelected.style.backgroundColor = document.getElementsByName("color")[0].value;
        }
        */
    </script>
@stop