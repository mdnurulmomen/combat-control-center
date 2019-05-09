
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left"> Treasure Redemptions List </h3>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">

                        <thead class="thead-dark">
                            <tr>
                                <th>Serial</th>
                                <th>Player Name</th>
                                <th>Treasure Name</th>
                                <th>User Mobile</th>
                                <th>Collected on</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                            @if($allRedeemedTreasures->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($allRedeemedTreasures as $redeemedTreasure)
                                
                                <tr>
                                    <td>{{ $redeemedTreasure->id }}</td>
                                    <td>{{ $redeemedTreasure->player->user->username ?? 'No Name'}}</td>
                                    <td>{{ $redeemedTreasure->treasure->name }}</td>
                                    <td>{{ $redeemedTreasure->player_phone ?? 'None'}}</td>
                                    <td>{{ $redeemedTreasure->updated_at }}</td>
                                </tr>

                            @endforeach
                        </tbody>
                        
                    </table>

                    <div class="float-right">
                        {{ $allRedeemedTreasures->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop