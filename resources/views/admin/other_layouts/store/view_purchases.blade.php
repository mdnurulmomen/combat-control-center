
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
                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%" id="purchaseTable">
                        
                        <thead class="thead-dark">
                            <tr>
                                <th>Serial</th>
                                <th>Item Id</th>
                                <th>Buyer Id</th>
                                <th>Gateway</th>
                                <th>Payment Id</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')

    <script>
        
        $( document ).ready(function() {
            
            var globalVariable = 0;

            $('#purchaseTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.view_purchase') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'item_id', name: 'item_id' },
                    { data: 'buyer_id', name: 'buyer_id' },
                    { data: 'gateway_name', name: 'gateway_name' },
                    { data: 'payment_id', name: 'payment_id'}
                ]
            });
        });

    </script>

@endpush