
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left">Disabled Gems Packs List </h3>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>Gems Pack Name</th>
                                <th>Amount</th>
                                <th>Price(Taka)</th>
                                <th>Discount(Taka)</th>
                                <th class="actions">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($gems->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($gems as $gem)
                                <tr>
                                    <td>{{ $gem->name }}</td>
                                    <td>{{ $gem->amount }}</td>

                                    <td>
                                        <p>{{ $gem->price_taka }} taka</p>
                                    </td>
                                    
                                    <td>
                                        <p>{{ $gem->discount_taka }}%</p>
                                    </td>

                                    <td>   

                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#undoModal{{$gem->id}}" title="Undo">
                                            <i class="fa fa-fw fa-undo" style="transform: scale(1.5);"></i>
                                        </button>

                                    </td>
                                </tr>


                                <!--Undo Modal -->
                                <div class="modal fade" id="undoModal{{$gem->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.undo_gem_pack', $gem->id) }}">
                                                
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
                            {{ $gems->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Create Gems Pack </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            
                            <form method="post" action= "{{ route('admin.created_gem_pack_submit') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-row">
                                    <div class="col-md-3 mb-4">
                                        <label for="validationServerUsername">Name</label>
                                        <div class="input-group">
                                            <input type="text" name="name" class="form-control form-control-lg is-valid" placeholder="Name Gems Pack" aria-describedby="inputGroupPrepend3">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <label for="validationServer01">Type</label>
                                        <select class="form-control form-control-lg is-valid" name="type" readonly>
                                            <option value="Gems Pack">Gems Pack</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <label for="validationServerUsername">Amount</label>
                                        <div class="input-group">
                                            <input type="number" name="amount" class="form-control form-control-lg is-invalid" placeholder="Unique Amount(required)" aria-describedby="inputGroupPrepend3" required="true" min='1'>
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
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServerUsername">Price (taka)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ taka</span>
                                            </div>
                                            <input type="number" name="price_taka" class="form-control form-control-lg is-invalid" placeholder="(required)" aria-describedby="inputGroupPrepend3" required="true" step="any">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServer01">Discount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@ taka</span>
                                            </div>
                                            <input type="number" name="discount_taka" class="form-control form-control-lg is-invalid" placeholder="Discount Percentage" aria-describedby="inputGroupPrepend3" required="true" min="0" max="100" step="any">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
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
@stop