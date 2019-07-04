
@extends('admin.master_layout.app')

@push('extraStyleLink')
    <style type="text/css">
        .fa.fa-eye:hover, .fa.fa-edit:hover, .fa.fa-trash:hover{
            border-radius: 10%;
            background:#b4b4b4;
        }
    </style>
@endpush

@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left">Enabled Boost Packs List </h3>
                </div>
                <div class="col-6">
                    <a  href="{{route('admin.view_disabled_boost_packs')}}" class="btn btn-outline-danger float-right" type="button">
                        Disabled Packs
                    </a>

                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal">
                        New Boost Pack
                    </button>
                </div>
            </div>

            <hr>

            <div class="row">

                <!--- View Modal --->
                <div class="modal fade" id="viewModal" role="dialog">
                    <div class="modal-dialog  modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4> Boost-pack Details </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">  
                                <div class="form-row">
                                    <div class="col-md-5">
                                        <label for="validationServerUsername">Name</label>
                                    </div>
                                        
                                    <div class="col-md-7">
                                        <p></p>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-5">
                                        <label for="validationServerUsername">Description</label>
                                    </div>
                                    <div class="col-md-7">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-5">
                                        <label for="validationServerUsername">Amount</label>
                                    </div>
                                    <div class="col-md-7">
                                        <p></p>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-5">
                                        <label for="validationServer01">Price </label>
                                    </div>
                                    <div class="col-md-7">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row mb-4">
                                    <div class="col-md-5">
                                        <label for="validationServerUsername">Discount</label>
                                    </div>

                                    <div class="col-md-7">
                                        <div>
                                            <span></span>
                                        </div>   
                                        <div class="form-check form-check-inline">
                                            <span></span>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <span></span>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--- Edit Modal --->
                <div class="modal fade" id="editModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3> Edit boostPack </h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                
                                <form method="post" action = "" enctype="multipart/form-data">
                                    
                                    @csrf
                                    @method('put')

                                    <div class="form-row">
                                        <div class="col-md-3 mb-4">
                                            <label for="validationServerUsername">Name</label>
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-control form-control-lg is-invalid" value="" aria-describedby="inputGroupPrepend3" required="true">
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4">
                                            <label for="validationServer01">Type</label>
                                            <select class="form-control form-control-lg is-valid" name="type" readonly>
                                                <option value="Boost Pack">Boost Pack</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-4">
                                            <label for="validationServerUsername">Amount</label>
                                            <div class="input-group">
                                                <input type="number" name="amount" class="form-control form-control-lg is-invalid" value="" aria-describedby="inputGroupPrepend3" required="true" min='1' step="1.0">
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4">
                                            <label for="validationServerUsername">Description</label>
                                            <div class="input-group">
                                                <input type="text" name="description" class="form-control form-control-lg is-valid" value="" aria-describedby="inputGroupPrepend3">
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="form-row">
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Price (taka)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ taka</span>
                                                </div>
                                                <input type="number" name="price_taka" class="form-control form-control-lg is-invalid"  value="" required="true" step="any">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Price (gems)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ gems</span>
                                                </div>
                                                <input type="number" name="price_gems" class="form-control form-control-lg is-invalid"  value="" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Price (coins)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ coins</span>
                                                </div>
                                                <input type="number" name="price_coins" class="form-control form-control-lg is-invalid"  value="" required="true">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row mb-4">
                                        <div class="col-md-5">
                                            <label for="validationServerUsername">Discount</label>
                                            <div class="input-group">
                                                <input step="any" type="number" name="discount" class="form-control form-control-lg is-invalid" value="" aria-describedby="inputGroupPrepend3" required="true" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-2 col-4">    
                                            <div class="form-check form-check-inline mt-5">
                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="taka">
                                                <label class="form-check-label" for="inlineCheckbox1">@ taka</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-4">
                                            <div class="form-check form-check-inline mt-5">
                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="gems">
                                                <label class="form-check-label" for="inlineCheckbox1">@ gems</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-4">
                                            <div class="form-check form-check-inline mt-5">
                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="coins">
                                                <label class="form-check-label" for="inlineCheckbox1">@ coins</label>
                                            </div>
                                        </div>
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
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Confirmation</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form method="POST" action="">

                                @method('DELETE')
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

                <div class="modal fade" id="addModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3> Create Boost Pack </h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                
                                <form method="post" action= "{{ route('admin.created_boost_pack_submit') }}" enctype="multipart/form-data">
                                    
                                    @csrf

                                    <div class="form-row">
                                        <div class="col-md-3 mb-4">
                                            <label for="validationServerUsername">Name</label>
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-control form-control-lg is-invalid" placeholder="Unique Name(required)" aria-describedby="inputGroupPrepend3" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-4">
                                            <label for="validationServer01">Type</label>
                                            <select class="form-control form-control-lg is-valid" name="type" readonly>
                                                <option value="Boost Pack">Boost Pack</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-4">
                                            <label for="validationServerUsername">Amount</label>
                                            <div class="input-group">
                                                <input type="number" name="amount" class="form-control form-control-lg is-invalid" aria-describedby="inputGroupPrepend3" required="true" min='1' placeholder="Amount(required)">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-4">
                                            <label for="validationServerUsername">Description</label>
                                            <div class="input-group">
                                                <input type="text" name="description" class="form-control form-control-lg is-valid" placeholder="Short Description" aria-describedby="inputGroupPrepend3">
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="form-row">
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServerUsername">Price (taka)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ taka</span>
                                                </div>
                                                <input type="number" name="price_taka" class="form-control form-control-lg is-invalid" placeholder="(required)" aria-describedby="inputGroupPrepend3" required="true" step="any">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServerUsername">Price (gems)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ gems</span>
                                                </div>
                                                <input type="number" name="price_gems" class="form-control form-control-lg is-invalid" placeholder="(required)" aria-describedby="inputGroupPrepend3" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Price (coins)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ coins</span>
                                                </div>
                                                <input type="number" name="price_coins" class="form-control form-control-lg is-invalid"  placeholder="(required)" required="true">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row mb-4">
                                        <div class="col-md-5">
                                            <label for="validationServerUsername">Discount</label>
                                            <div class="input-group">
                                                <input type="number" name="discount" class="form-control form-control-lg is-invalid" placeholder="Discount Percentage" aria-describedby="inputGroupPrepend3" required="true" min="0" max="100" step="any">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-2 col-4">    
                                            <div class="form-check form-check-inline mt-5">
                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="taka">
                                                <label class="form-check-label" for="inlineCheckbox1">@ taka</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-4">
                                            <div class="form-check form-check-inline mt-5">
                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="gems">
                                                <label class="form-check-label" for="inlineCheckbox1">@ gems</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-4">
                                            <div class="form-check form-check-inline mt-5">
                                                <input name="discount_type[]" class="form-check-input" type="checkbox" value="coins">
                                                <label class="form-check-label" for="inlineCheckbox1">@ coins</label>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary">Create</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%" id="boostsTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Boost Pack Name</th>
                                <th>Amount</th>
                                <th>Prices</th>
                                <th>Offers</th>
                                <th class="actions">Actions</th>
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
       
        $( document ).ready(function() {

            var globalVariable = 0;

            $('#boostsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.view_enabled_boost_packs') }}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'amount', name: 'amount' },
                    { 
                        data: function(data){
                            return data.price_taka + 'taka /<br/>' + data.price_gems + 'gems /<br/>' + data.price_coins + 'coins';
                        }, 
                        name: 'price_taka' 
                    },
                    { 
                        data: function(data){
                            return Math.max(data.discount_taka, data.discount_gems, data.discount_coins);
                        }, 
                        name: 'discount_taka' 
                    },
                    { data: 'action', name: 'action', orderable: false }
                ],
                drawCallback: function( settings ) {
                    
                    var api = this.api();
                    // var data = api.rows( {page:'current'} ).data();
                    var jsonData = api.ajax.json();

                    globalVariable = jsonData.data;
                }
            });

            $('#boostsTable').on( 'draw.dt', function () {
                
                $(".fa-eye").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    $( "#viewModal p:eq(0)" ).html( expectedObject.name );
                    $( "#viewModal p:eq(1)" ).html( expectedObject.description );
                    $( "#viewModal p:eq(2)" ).html( expectedObject.amount );
                    $( "#viewModal p:eq(3)" ).html( expectedObject.price_taka +' taka /<br/>'+ expectedObject.price_gems +' gems /<br/>'+ expectedObject.price_coins +' coins');
                    
                    $( "#viewModal span:eq(0)" ).html( Math.max(expectedObject.discount_taka, expectedObject.discount_gems, expectedObject.discount_coins) + ' %' );

                    if (expectedObject.discount_taka) {
                        $( "#viewModal span:eq(1)" ).html( 'taka,' );
                    }
                    else{
                        $( "#viewModal span:eq(1)" ).empty(); 
                    }

                    if (expectedObject.discount_gems) {
                        $( "#viewModal span:eq(2)" ).html( 'gems,' );
                    }
                    else{
                        $( "#viewModal span:eq(2)" ).empty(); 
                    }

                    if (expectedObject.discount_coins) {
                        $( "#viewModal span:eq(3)" ).html( 'coins' );
                    }
                    else{
                        $( "#viewModal span:eq(3)" ).empty(); 
                    }

                    $('#viewModal').modal('toggle');
                });

                $(".fa-edit").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    var home = "{{ URL::to('/') }}";

                    $("#editModal form").attr("action", home + '/admin/boost-packs/' +  expectedObject.id );

                    $( "#editModal input[name*='name']" ).val( expectedObject.name );
                    $( "#editModal input[name*='amount']" ).val( expectedObject.amount );
                    $( "#editModal input[name*='description']" ).val( expectedObject.description );
                    $( "#editModal input[name*='price_taka']" ).val( expectedObject.price_taka );
                    $( "#editModal input[name*='price_gems']" ).val( expectedObject.price_gems );
                    $( "#editModal input[name*='price_coins']" ).val( expectedObject.price_coins );

                    $( "#editModal input[name='discount']" ).val( Math.max(expectedObject.discount_taka, expectedObject.discount_gems, expectedObject.discount_coins) );


                    if (expectedObject.discount_taka) {
                        
                        $("#editModal input[name='discount_type[]']:eq(0)").prop('checked', true);
                    }
                    else{
                        $("#editModal input[name='discount_type[]']:eq(0)").prop("checked", false);
                    }

                    if (expectedObject.discount_gems) {

                        $("#editModal input[name='discount_type[]']:eq(1)").prop('checked', true);
                    }
                    else{
                        $("#editModal input[name='discount_type[]']:eq(1)").prop("checked", false);
                    }

                    if (expectedObject.discount_coins) {

                        $("#editModal input:checkbox[name='discount_type[]']:eq(2)").prop('checked', true);
                    }
                    else{
                        $("#editModal input:checkbox[name='discount_type[]']:eq(2)").prop("checked", false);
                    }

                    $('#editModal').modal('toggle');
                });

                $(".fa-trash").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    var home = "{{ URL::to('/') }}";

                    $("#deleteModal form").attr("action", home + '/admin/boost-packs/' +  expectedObject.id );

                    $('#deleteModal').modal('toggle');
                });
            });  
        });

   </script>

@endpush