
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left"> Ads List </h3>
                    </div>

                    <div class="col-6">
                        <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#addModal">
                            Create Ad
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Ad Order</th>
                                <th>Preview</th>
                                <th class="actions">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($images->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($images as $image)
                                <tr>
                                    <td>{{ $image->name }}</td>
                                    <td>{{ $image->order }}</td>
                                    <td><img src="{{ asset($image->preview) }}" width="60"></td>
                                    <td>
                                        <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$image->id}}" title="edit">
                                            <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                        </button>

                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$image->id}}" title="Delete">
                                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="editModal{{$image->id}}" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h3> Update Ad </h3>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    &times;
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <form method="POST" action = "{{ route('admin.updated_image_submit', $image->id) }}" enctype="multipart/form-data">
                                                    
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Name</label>
                                                            <input type="tel" name="name" class="form-control form-control-lg is-valid"  value="{{ $image->name }}">
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Order</label>
                                                            <input type="number" name="order" class="form-control form-control-lg is-valid"  value="{{ $image->order }}">
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer02">Ads Image</label>
                                                            <input type="file" name="preview" class="form-control is-invalid" accept="image/*">
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

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal{{$image->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <form method="POST" action="{{ route('admin.delete_image', $image->id) }}">
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

                            @endforeach
                            </tbody>
                        </table>
                        
                        <div class="float-right">
                            {{ $images->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Create Ad </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form method="POST" action = "{{ route('admin.created_image_submit') }}" enctype="multipart/form-data">
                                
                                @csrf

                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer01">Name</label>
                                        <input type="tel" name="name" class="form-control form-control-lg is-valid"  placeholder="Ad Name">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer01">Order</label>
                                        <input type="number" name="order" class="form-control form-control-lg is-valid"  placeholder="Order Ad">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer02">Ads Image</label>
                                        <input type="file" name="preview" class="form-control is-invalid" accept="image/*">
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