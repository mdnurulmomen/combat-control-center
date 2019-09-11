
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-12">
                    <h3 class="float-left"> Top Leaders </h3>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%" id="leaderTable">
                        
                        <thead class="thead-dark">
                            <tr>
                                <th>Serial</th>
                                <th>User Name</th>
                                <th>Level</th>
                                <th>Total Kill</th>
                                <th>Total Treasure Won</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    
    <script type="text/javascript">

        $('#leaderTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.view_leaderboard') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'username', name: 'username' },
                { data: 'level', name: 'level' },
                { data: 'total_kill', name: 'total_kill' },
                { data: 'treasure_won', name: 'treasure_won' },
            ],
            order: [[ 3, "desc" ]],

            drawCallback: function(){
                // var api = this.api();
                // var json = api.ajax.json();
                // console.log(json);
                // console.log(json.data);
            }
        });

    </script>

@endpush