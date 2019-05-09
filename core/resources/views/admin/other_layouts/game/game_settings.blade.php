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
                    <div class="form-group form-row mb-4">
                        <div class="col-md-6">
                            <label for="validationServer01">Game Version (minimum)</label>
                            <input type="text" name="game_version_required" class="form-control form-control-lg is-valid" value="{{ $settingsGame->game_version_required ?? 'No version is Set' }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="validationServer01">Game Version (current)</label>
                            <input type="text" name="game_version_optional" class="form-control form-control-lg is-valid" value="{{ $settingsGame->game_version_optional ?? 'No version is Set'  }}">
                        </div>
                    </div>

                    <div class="form-group form-row mb-4">

                        <div class="col-md-12">
                            <label for="validationServer01">Game Rate (Per Game)</label>
                            <input type="number" name="rate" class="form-control form-control-lg is-valid" value="{{ $settingsGame->game_rate ?? 'No Rate is Defined' }}" step="any" required>
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