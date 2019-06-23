
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left"> Messages List </h3>
                    </div>

                    <div class="col-6">
                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal" title="Add">
                            Create Message
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>Title</th>
                                <th>Message</th>
                                <th class="actions">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($allMessages->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($allMessages as $message)
                                <tr>
                                    <td>{{ $message->title }}</td>
                                    <td>{{ $message->body }}</td>
                                    <td>
                                        <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$message->id}}" title="Edit">
                                            <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                        </button>

                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$message->id}}" title="Delete">
                                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                        </button>
                                    </td>
                                </tr>


                                <!-- Modal -->
                                <div class="modal fade" id="editModal{{$message->id}}" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h3> Update Message </h3>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <form method="POST" action = "{{ route('admin.updated_message_submit', $message->id) }}" enctype="multipart/form-data">
                        
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-row mb-4">
                                                        <div class="col-md-12">
                                                            <label for="validationServer01">Title</label>
                                                            <input type="text" name="title" class="form-control form-control-lg" value="{{ $message->title }}">
                                                        </div>
                                                    </div>

                                                    <div class="form-row mb-4">
                                                        <div class="col-md-12">
                                                            <label for="validationServer01">Message</label>
                                                            <textarea name="body" class="form-control form-control-lg" rows="5"> {{ $message->body }} </textarea>
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
                                <div class="modal fade" id="deleteModal{{$message->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    &times;
                                                </button>
                                            </div>

                                            <form method="POST" action="{{ route('admin.delete_message', $message->id) }}">
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
                            {{ $allMessages->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Create Message </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form method="POST" action = "{{ route('admin.created_message_submit') }}" enctype="multipart/form-data">
                
                                @csrf
                                
                                <div class="form-row mb-4">
                                    <div class="col-md-12">
                                        <label for="validationServer01">Title</label>
                                        <input type="text" name="title" class="form-control form-control-lg is-valid" placeholder="Message Title">
                                    </div>
                                </div>
                                <div class="form-row mb-4">
                                    <div class="col-md-12">
                                        <label for="validationServer01">Message</label>
                                        <textarea name="body" class="form-control form-control-lg is-invalid" rows="5"></textarea>
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