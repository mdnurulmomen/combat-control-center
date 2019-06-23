
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left">Disabled Coin Packs List </h3>
                    </div>
                    <div class="col-6">
                        <a  href="{{route('admin.view_enabled_coin_packs')}}"  class="btn btn-outline-success float-right" type="button">
                            Enabled Packs
                        </a>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>Coin Pack Name</th>
                                <th>Amount</th>
                                <th>Prices</th>
                                <th>Discounts</th>
                                <th class="actions">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($coins->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($coins as $coin)
                                <tr>
                                    <td>{{ $coin->name }}</td>
                                    <td>{{ $coin->amount }}</td>
                                    <td>
                                        <p>{{ $coin->price_taka }} taka</p>
                                        <p>{{ $coin->price_gems }} gems</p>
                                    </td>
                                    
                                    <td>
                                        <p>{{ $coin->discount_taka }}% (taka)</p>
                                        <p>{{ $coin->discount_gems }}% (gems)</p>
                                    </td>

                                    <td>    

                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#undoModal{{$coin->id}}" title="Undo">
                                            <i class="fa fa-fw fa-undo" style="transform: scale(1.5);"></i>
                                        </button>

                                    </td>
                                </tr>



                                <!-- Undo Modal -->
                                <div class="modal fade" id="undoModal{{$coin->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.undo_coin_pack', $coin->id) }}">
                                                
                                                @method('PATCH')
                                                @csrf
                                                
                                                <div class="modal-body">
                                                    <p>Are You Sure ??</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Yes</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                            </tbody>
                        </table>
                        
                        <div class="float-right">
                            {{ $coins->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
@stop