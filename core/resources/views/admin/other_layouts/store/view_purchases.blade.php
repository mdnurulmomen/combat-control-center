
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">
                
                <div class="row">
                    <div class="col-12">
                        <h3 class="float-left"> Purchases </h3>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>Serial</th>
                                <th>Item Id</th>
                                <th>buyer_id</th>
                                <th>gateway_name</th>
                                <th>payment_id</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($allPurchases->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($allPurchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->id }}</td>
                                    <td>{{ $purchase->item_id }}</td>
                                    <td>{{ $purchase->buyer_id }}</td>
                                    <td>{{ $purchase->gateway_name }}</td>
                                    <td>{{ $purchase->payment_id }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="float-right">
                            {{ $allPurchases->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop