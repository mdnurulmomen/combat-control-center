
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
                    <h3 class="float-left"> Enabled Characters List </h3>
                </div>

                <div class="col-6">

                    @if(auth()->user()->can('read'))
                    
                    <a href="{{route('admin.view_disabled_characters')}}" class="btn btn-outline-danger float-right btn-sm ml-1 mr-1" type="button">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Disabled Characters
                    </a>
                    
                    @endif

                    @if(auth()->user()->can('create'))
                    
                    <button type="button" class="btn btn-success float-right btn-sm" data-toggle="modal" data-target="#addModal">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        New Character
                    </button>
                    
                    @endif

                </div>

            </div>

            <hr>


            <div class="row">
                
                @if(auth()->user()->can('read'))
                <!--- View Modal --->
                <div class="modal fade" id="viewModal" role="dialog">
                    <div class="modal-dialog  modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4> Character Details </h4>
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

                @endif

                @if(auth()->user()->can('delete'))
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
                                    
                                    <p>You are about to delete.</p> 
                                    
                                    <p class="text-muted">This may hamper gift characters. Please update gift items laterly.</p>
                                    
                                    <h5>Do you want to proceed ?</h5>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Yes</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                @endif

                @if(auth()->user()->can('create'))

                <div class="modal fade" id="addModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3> Create Character </h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                
                                <form method="post" action= "{{ route('admin.created_character_submit') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-row">
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServerUsername">Name</label>
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-control form-control-lg is-valid" placeholder="Unique Name(required)" aria-describedby="inputGroupPrepend3" data-validation='required' data-validation-help='Name has to be unique' data-validation-error-msg='Character name is required and unique'>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Type</label>
                                            <select class="form-control form-control-lg is-valid" name="type" readonly>
                                                <option value="character">Character</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-4">
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
                                                <input type="text" name="price_taka" class="form-control form-control-lg is-valid" placeholder="(required)" aria-describedby="inputGroupPrepend3"  data-validation='required number' data-validation-allowing='float' data-validation-help='Minimun price 0 taka' data-validation-error-msg='Price taka is required'>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Price (gems)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ gems</span>
                                                </div>
                                                <input type="text" name="price_gems" class="form-control form-control-lg is-valid"  placeholder="(required)" data-validation='required number' data-validation-help='Minimun price 0 gem' data-validation-error-msg='Price gem is required and numeric only'>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServerUsername">Price (coins)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ coins</span>
                                                </div>
                                                <input type="text" name="price_coins" class="form-control form-control-lg is-valid" placeholder="(required)" aria-describedby="inputGroupPrepend3"  data-validation='required number' data-validation-help='Minimun price 0 coin' data-validation-error-msg='Price coin is required and numeric only'>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row mb-4">
                                        <div class="col-md-5">
                                            <label for="validationServerUsername">Discount</label>
                                            <div class="input-group">
                                                <input type="text" name="discount" class="form-control form-control-lg is-valid" placeholder="Discount Percentage" aria-describedby="inputGroupPrepend3"  data-validation='required number' data-validation-allowing='float range[0;100]' data-validation-error-msg='Discount field is required'>
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

                @endif

                @if(auth()->user()->can('update'))

                <div class="modal fade" id="editModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3> Update Character </h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                
                                <form method="post" action= "" enctype="multipart/form-data">

                                    @csrf
                                    @method('PUT')

                                    <div class="form-row">
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServerUsername">Name</label>
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-control form-control-lg is-valid" placeholder="Unique Name(required)" aria-describedby="inputGroupPrepend3" data-validation='required' data-validation-help='Name has to be unique' data-validation-error-msg='Character name is required and unique'>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Type</label>
                                            <select class="form-control form-control-lg is-valid" name="type" readonly>
                                                <option value="character">Character</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-4">
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
                                                <input type="text" name="price_taka" class="form-control form-control-lg is-valid" placeholder="(required)" aria-describedby="inputGroupPrepend3" data-validation='required number' data-validation-allowing='float' data-validation-help='Minimun price 0 taka' data-validation-error-msg='Price taka is required'>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServer01">Price (gems)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ gems</span>
                                                </div>
                                                <input type="text" name="price_gems" class="form-control form-control-lg is-valid"  placeholder="(required)" data-validation='required number' data-validation-help='Minimun price 0 gem' data-validation-error-msg='Price gem is required and numeric only'>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label for="validationServerUsername">Price (coins)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@ coins</span>
                                                </div>
                                                <input type="text" name="price_coins" class="form-control form-control-lg is-valid" placeholder="(required)" aria-describedby="inputGroupPrepend3" data-validation='required number' data-validation-help='Minimun price 0 coin' data-validation-error-msg='Price coin is required and numeric only'>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row mb-4">
                                        <div class="col-md-5">
                                            <label for="validationServerUsername">Discount</label>
                                            <div class="input-group">
                                                <input type="text" name="discount" class="form-control form-control-lg is-valid" placeholder="Discount Percentage" aria-describedby="inputGroupPrepend3" data-validation='required number' data-validation-allowing='float range[0;100]' data-validation-error-msg='Discount field is required'>
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

                @endif

            </div>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%" id="characterTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Character Name</th>
                                <th>Prices</th>
                                <th>Discounts</th>
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

    <script>
        
        $( document ).ready(function() {
            
            var globalVariable = 0;

            $('#characterTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.view_enabled_characters') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    {
                        data: function(data){
                            return data.price_taka + ' (taka) /<br/>' + data.price_coins + ' (coins) /<br/>' + data.price_gems + ' (gems)';
                        }, 
                        name: 'price_taka' 
                    },
                    { 
                        data: function(data){
                            return Math.max(data.discount_taka, data.price_coins, data.discount_gems);
                        }, 
                        name: 'discount_taka' 
                    },
                    { data: 'action', name: 'action', orderable : false }
                ],
                drawCallback:function(){
                    var api = this.api();
                    var json = api.ajax.json();
                    globalVariable = json.data;
                }
            });

            $('#characterTable').on( 'draw.dt', function () {

                @if(auth()->user()->can('read'))

                $(".fa-eye").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    // console.log(expectedObject);

                    $( "#viewModal p:eq(0)" ).html( expectedObject.name );
                    $( "#viewModal p:eq(1)" ).html( expectedObject.description );

                    $( "#viewModal p:eq(2)" ).html( expectedObject.price_taka +' taka /<br/>'+ expectedObject.price_gems +' gems /<br/>'+ expectedObject.price_coins +' coins');
                    
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

                @endif

                @if(auth()->user()->can('update'))

                $(".fa-edit").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    var home = "{{ URL::to('/') }}";

                    $("#editModal form").attr("action", home + '/admin/characters/' +  expectedObject.id );

                    $( "#editModal input[name*='name']" ).val( expectedObject.name );
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

                @endif

                @if(auth()->user()->can('delete'))

                $(".fa-trash").click(function() {

                    // alert('delete');

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    var home = "{{ URL::to('/') }}";

                    $("#deleteModal form").attr("action", home + '/admin/character/' +  expectedObject.id );

                    $('#deleteModal').modal('toggle');
                });

                @endif
                
            });
        });
    </script>

@endpush