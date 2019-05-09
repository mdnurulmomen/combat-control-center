
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left">Disabled Bundle Packs List </h3>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Bundle Pack Name</th>
                                    <th>Prices</th>
                                    <th>Offers</th>
                                    <th>Bundle Components</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                            @if($bundlePacks->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($bundlePacks as $bundlePack)
                                <tr>
                                    <td>{{ $bundlePack->name }}</td>

                                    <td>
                                        <p>{{ $bundlePack->price_taka }} (taka)</p>
                                        <p>{{ $bundlePack->price_gems }} (gems)</p>
                                        <p>{{ $bundlePack->price_coins }} (coins)</p>
                                    </td>
                                    
                                    <td>
                                        <p>{{ $bundlePack->discount_taka }}% (taka)</p>
                                        <p>{{ $bundlePack->discount_gems }}% (gems)</p>
                                        <p>{{ $bundlePack->discount_coins }}% (coins)</p>
                                    </td>
                                    
                                    <td>
                                        @foreach($bundlePack->bundleComponents()->withTrashed()->get() as $component)

                                        <p>
                                            {{ $component->component_type }}
                                            ({{ $component->amount }})
                                        </p>

                                        @endforeach
                                    </td>
                                    
                                    <td>
                                    
                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#undoModal{{$bundlePack->id}}" title="Undo">
                                            <i class="fa fa-fw fa-undo" style="transform: scale(1.5);"></i>
                                        </button>

                                    </td>
                                </tr>

                                <!-- Undo Modal -->
                                <div class="modal fade" id="undoModal{{$bundlePack->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.undo_bundle_pack', $bundlePack->id) }}">
                                                
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
                            {{ $bundlePacks->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

@stop