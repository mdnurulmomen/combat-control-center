
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left">Treasure '{{$allGiftedTreasures->first()->treasure->name ?? 'None'}}' on {{ date('d-M-y', strtotime($allGiftedTreasures->first()->open_time ?? '00-00-0000')) }}</h3>
                </div>

                <div class="col-6">
                    <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#modalTreasureGifted">
                        Show Another
                    </button>
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
                                <th>Aquired Date</th>
                                <th>Closing Date</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                            @if(!$allGiftedTreasures->isEmpty())
                            
                            @foreach($allGiftedTreasures as $giftedTreasure)
                                
                                <tr>
                                    <td>{{ $giftedTreasure->id }}</td>
                                    <td>{{ $giftedTreasure->player->user->username ?? 'No Name'}}</td>
                                    <td>{{ $giftedTreasure->treasure->name ?? 'None'}} </td>
                                    <td>{{ $giftedTreasure->open_time ?? 'None'}}</td>
                                    <td>{{ $giftedTreasure->close_time }}</td>
                                </tr>

                            @endforeach

                            @else
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No History Found</td>
                                </tr>

                            @endif

                        </tbody>
                        
                    </table>

                    <div class="float-right">
                        {{ $allGiftedTreasures->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop