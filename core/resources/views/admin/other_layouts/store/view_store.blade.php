
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            <h3> Store </h3>
            <hr class="mb-4">
            
            <div class="row">
                
                <div class="col-sm-3 col-4 mb-4">
                    <a href="{{ route('admin.view_enabled_characters') }}"  class="btn btn-sm btn-info btn-block">
                        Characters
                    </a>
                </div>

                <div class="col-sm-3 col-4 mb-4">
                    <a href="{{ route('admin.view_enabled_animations') }}"  class="btn btn-sm btn-success btn-block">
                        Animations
                    </a> 
                </div>

                <div class="col-sm-3 col-4 mb-4">
                    <a href="{{ route('admin.view_enabled_coin_packs') }}"  class="btn btn-sm btn-warning btn-block">
                        Coin Packs
                    </a>
                </div>

                <div class="col-sm-3 col-4 mb-4">
                    <a href="{{ route('admin.view_enabled_parachutes') }}"  class="btn btn-sm btn-info btn-block">
                        Parachutes
                    </a> 
                </div>
                
            </div>

            <div class="row">
                <div class="col-sm-3 col-4 mb-4">
                    <a href="{{ route('admin.view_enabled_gem_packs') }}" class="btn btn-sm btn-success btn-block">
                        Gem Packs
                    </a> 
                </div>

                <div class="col-sm-3 col-4 mb-4">
                    <a href="{{ route('admin.view_enabled_boost_packs') }}"  class="btn btn-sm btn-warning btn-block">
                        Boost Pack
                    </a> 
                </div>

                <div class="col-sm-3 col-4 mb-4">
                    <a href="{{ route('admin.view_enabled_weapons') }}"  class="btn btn-sm btn-danger btn-block">
                        Weapons
                    </a>
                </div>
                
                <div class="col-sm-3 col-4 mb-4">
                    <a href="{{ route('admin.view_enabled_bundle_packs') }}"  class="btn btn-sm btn-dark btn-block">
                        Bundle Packs
                    </a> 
                </div>

                
            </div>
            

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Item Id</th>
                                <th>Type</th>
                                <th>Discount</th>
                                <th>Original Prices</th>
                                <th>Offered Prices</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                        @if($storeAll->isEmpty())
                            <tr class="danger">
                                <td class="text-danger" colspan='5'>No Data Found</td>
                            </tr>
                        @endif

                        @foreach($storeAll as $store)
                            <tr>
                                <td>{{ $store->id }}</td>
                                <td>{{ $store->type }}</td>
                                <td>{{ $store->discount }}%</td>
                                <td>
                                    <p>{{ $store->origin_price_taka }} (taka)</p>
                                    <p>{{ $store->origin_price_gems ?? 0}} (gems)</p>
                                    <p>{{ $store->origin_price_coins ??0}} (coins)</p>
                                </td>
                                
                                <td>
                                    <p>{{ $store->offered_price_taka }} (taka)</p>
                                    <p>{{ $store->offered_price_gems ?? 0}} (gems)</p>
                                    <p>{{ $store->offered_price_coins ?? 0}} (coins)</p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="float-right">
                        {{ $storeAll->links() }}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@stop