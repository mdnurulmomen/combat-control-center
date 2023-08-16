@extends('admin.master_layout.app')

@section('contents')
    <div class="content p-4">
        
        <div class="card mb-4">
            
            <div class="card-body">
                
                <h3> General Settings </h3>

                <hr class="mb-4">

                <form method="post" action = "{{ route('admin.settings_game_submit') }}">
                    
                    @csrf
                    @Method('put')

                    <div class="row">                
                        <div class="col-md-12">
                            <h4 class="tile-title">Game Details</h4>
                            <div class="tile">
                                <div class="tile-body">
                                    <div class="form-row mb-4">
                                        <div class="col-md-4">
                                            <label for="validationServer01">Game Version (minimum)</label>
                                            <input type="text" name="game_version_required" class="form-control form-control-lg  is-valid" value="{{ $settingsGame->game_version_required ?? 'No version is Set' }}" step=".001" data-validation="required number"  data-validation-allowing="float" data-validation-error-msg="Version number is required" >
                                        </div>

                                        <div class="col-md-4">
                                            <label for="validationServer01">Game Version (current)</label>
                                            <input type="text" name="game_version_optional" class="form-control form-control-lg is-valid" value="{{ $settingsGame->game_version_optional ?? 'No version is Set'  }}" step=".001" data-validation="number"  data-validation-allowing="float" data-validation-optional="true" data-validation-error-msg="Only numberic value is allowed">
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="validationServer01">Game Rate <span class="text-danger">(Gems Per Game)</span></label>
                                            <input type="text" name="rate" class="form-control form-control-lg is-valid" value="{{ $settingsGame->game_rate ?? 'No Rate is Defined' }}" step="any" data-validation="required number"  data-validation-allowing="float" data-validation-error-msg="Price of every game play is required" >
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-12">
                            
                            <h4 >Maintainance Details</h4>

                            <div class="tile">
                                <div class="tile-body">
                                        
                                    <div class="form-group form-row mb-4">
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Game Maintainance Mode </label>

                                            <input type="checkbox" name="maintainance_mode"  id="maintainance_mode" @if($settingsGame->maintainance_mode) checked @endif data-toggle="toggle" data-on="Maintainance On" data-off="Maintainance Off" data-onstyle="danger" data-offstyle="success" data-size="normal">
                                        </div>

                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01"> Maintainance Start Time </label>

                                            <div class='input-group date' id='datetimepicker1' data-target-input='nearest'>
                                                <input type='text' name="maintainance_start_time" class="form-control form-control-lg is-valid maintainance_date datetimepicker-input" @if($settingsGame->maintainance_mode) value="{{ optional($settingsGame->maintainance_start_time)->format('m-d-Y H:i:s') }}" @else disabled="true" @endif data-target="#datetimepicker1"/>
                                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01"> Maintainance End Time </label>

                                            <div class='input-group date' id='datetimepicker2' data-target-input='nearest'>
                                                <input type='text' name="maintainance_end_time" class="form-control form-control-lg is-valid maintainance_date datetimepicker-input" @if($settingsGame->maintainance_mode) value="{{ optional($settingsGame->maintainance_end_time)->format('m-d-Y H:i:s') }}" @else disabled="true" @endif data-target="#datetimepicker2"/>
                                                <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>   
                                    </div>

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
    

@push('scripts')

    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/admin/js/bootstrap-datetimepicker.js') }}"></script> --}} 

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>

    <script type="text/javascript">

        $(function () {
            $('#datetimepicker1').datetimepicker();
            
            $('#datetimepicker2').datetimepicker();
        
            $('#maintainance_mode').change(function() {
                $(this).prop("checked") == true ? enable_date() : disable_date(); 
            })

            function enable_date() {
                $("input.maintainance_date").prop('disabled', false);
            };

            function disable_date() {
                $("input.maintainance_date").prop('disabled', true);
                $('input.maintainance_date').val("");
            };
        });

    </script>

@endpush
