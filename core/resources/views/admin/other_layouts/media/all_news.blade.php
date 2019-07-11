
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left"> News List </h3>
                    </div>

                    @if(auth()->user()->can('create'))

                    <div class="col-6"> 
                        <button type="button" class="btn btn-info float-right btn-sm" data-toggle="modal" data-target="#addModal" title="Add">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            Create News
                        </button>
                    </div>

                    @endif

                </div>

                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>News Serial</th>
                                    <th>News Body</th>

                                    @if(auth()->user()->can('update'))

                                    <th class="actions">Actions</th>

                                    @endif

                                </tr>
                            </thead>
                            <tbody>

                            @if($allNews->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($allNews as $news)
                                <tr>
                                    <td>{{ $news->id }}</td>
                                    <td>{{ $news->body }}</td>

                                    @if(auth()->user()->can('update'))

                                    <td>
                                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#editModal{{$news->id}}" title="Edit">
                                            <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                        </button>

                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$news->id}}" title="Delete">
                                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                        </button>
                                    </td>

                                    @endif

                                </tr>

                                @if(auth()->user()->can('update'))
                                <!-- Update Modal -->
                                <div class="modal fade" id="editModal{{$news->id}}" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h3> Update News </h3>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <form method="POST" action = "{{ route('admin.updated_news_submit', $news->id) }}" enctype="multipart/form-data">
                        
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-row mb-4">
                                                        <div class="col-md-12">
                                                            <label for="validationServer01">News</label>
                                                            <textarea name="body" class="form-control form-control-lg" rows="5" id="news"> {{ $news->body }} </textarea>
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

                                @if(auth()->user()->can('delete'))
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{$news->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <form method="POST" action="{{ route('admin.delete_news', $news->id) }}">
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

                                @endif

                            @endforeach

                            </tbody>
                        </table>

                        <div class="float-right">
                            {{ $allNews->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            @if(auth()->user()->can('create'))

            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Create News </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form method="POST" action = "{{ route('admin.created_news_submit') }}" enctype="multipart/form-data">
                
                                @csrf
                                
                                <div class="form-row mb-4">
                                    <div class="col-md-12">
                                        <label for="validationServer01">News</label>
                                        <textarea name="body" class="form-control form-control-lg" rows="5" id="news"></textarea>
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

        </div>
@stop