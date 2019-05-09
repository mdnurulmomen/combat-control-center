
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
                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>Serial</th>
                                <th>User Name</th>
                                <th>Level</th>
                                <th>Total Kill</th>
                                <th>Total Treasure Won</th>
                                <th>Location</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($leaders as $leader)
                                <tr>
                                    <td>{{ $leader->id }}</td>
                                    <td>{{ $leader->username }}</td>
                                    <td>{{ $leader->level }}</td>
                                    <td>{{ $leader->total_kill }}</td>
                                    <td>{{ $leader->treasure_won }}</td>
                                    <td>{{ $leader->location ?? 'NA'}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="float-right">
                            {{ $leaders->onEachSide(3)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop