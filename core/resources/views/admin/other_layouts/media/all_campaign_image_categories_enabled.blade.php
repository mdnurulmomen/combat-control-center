
@extends('admin.master_layout.app')

@section('contents')

    <div class="card mb-4">
        <div class="card-body">

            <div class="row">
                <div class="col-6">
                    <h3 class="float-left"> Campaign Categories List </h3>
                </div>


                <div class="col-6">
                    @if(auth()->user()->can('read'))
                        <a  href="{{route('admin.view_disabled_campaign_image_categories')}}"  class="btn btn-outline-danger float-right btn-sm ml-1 mr-1" type="button">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            Disabled Image Categories
                        </a>
                    @endif

                    @if(auth()->user()->can('create'))
                        <button type="button" class="btn btn-info float-right btn-sm" data-toggle="modal" data-target="#addModal" title="Add">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            New Campaign Category
                        </button>
                    @endif
                </div>


            </div>

            <hr>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Dimensions</th>

                                @if(auth()->user()->can('update'))

                                <th class="actions">Actions</th>

                                @endif

                            </tr>
                        </thead>
                        <tbody>

                        @if($campaignImageCategories->isEmpty())
                            <tr class="danger">
                                <td class="text-danger" colspan='5'>No Data Found</td>
                            </tr>
                        @endif
                        
                        @foreach($campaignImageCategories as $campaignImageCategory)
                            <tr>
                                <td>{{ $campaignImageCategory->id }}</td>
                                <td>{{ $campaignImageCategory->name }}</td>
                                <td>{{ $campaignImageCategory->width_size .'*'. $campaignImageCategory->height_size }}</td>

                                @if(auth()->user()->can('update'))

                                <td>
                                    <button class="btn btn-outline-success" data-toggle="modal" data-target="#editModal{{$campaignImageCategory->id}}" title="Edit">
                                        <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                    </button>

                                    <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$campaignImageCategory->id}}" title="Delete">
                                        <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                    </button>
                                </td>

                                @endif

                            </tr>

                            @if(auth()->user()->can('update'))
                            
                            <!-- Update Modal -->
                            <div class="modal fade" id="editModal{{$campaignImageCategory->id}}" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h3> Update Image Category </h3>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <form method="POST" action = "{{ route('admin.updated_campaign_image_category_submit', $campaignImageCategory->id) }}" enctype="multipart/form-data">
                                
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="form-row mb-4">
                                                    <div class="col-md-12">
                                                        <label for="validationServer01">Name</label>
                                                        <input class="form-control is-valid" type="text" name="name" placeholder="Enter Category name" data-validation="required" data-validation-help="Name has to be unique" data-validation-error-msg="Name is not in proper form" value="{{$campaignImageCategory->name}}" required="true">
                                                    </div>
                                                </div>

                                                <div class="form-row mb-4">
                                                    <div class="col-md-6">
                                                        <label for="validationServer01">Width Size</label>
                                                        <input class="form-control is-valid" type="number" name="width" placeholder="Enter Image Width" data-validation="required number" data-validation-allowing="range[50;2000]"  data-validation-help="Width Range 50 to 2000" data-validation-error-msg="Width isn't within range" value="{{$campaignImageCategory->width_size}}" required="true" min="50">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="validationServer01">Height Size</label>
                                                        <input class="form-control is-valid" type="number" name="height" placeholder="Enter Image Height" data-validation="required number" data-validation-allowing="range[50;2000]"  data-validation-help="Height Range 50 to 2000" data-validation-error-msg="Height isn't within range" value="{{$campaignImageCategory->height_size}}" required="true" min="50">
                                                    </div>
                                                </div>
                                                
                                                <br>
                                                
                                                <div class="form-row">
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
                            <div class="modal fade" id="deleteModal{{$campaignImageCategory->id}}" role="dialog">
                                <div class="modal-dialog">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Confirmation</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <form method="POST" action="{{ route('admin.delete_campaign_image_category', $campaignImageCategory->id) }}">

                                            @method('DELETE')
                                            @csrf

                                            <div class="modal-body">
                                                <p>You are about to delete.</p> 
                                                
                                                <p class="text-muted">This action cannot be undone.</p>
                                                
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

                        @endforeach

                        </tbody>
                    </table>

                    <div class="float-right">
                        {{ $campaignImageCategories->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->can('create'))

        <div class="modal fade" id="addModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3> Create Image Category </h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action = "{{ route('admin.created_campaign_image_category_submit') }}" enctype="multipart/form-data">
            
                            @csrf
                            
                            <div class="form-row mb-4">
                                <div class="col-md-12">
                                    <label for="validationServer01">Name</label>
                                    <input class="form-control is-valid" type="text" name="name" placeholder="Enter Category name" data-validation="required"  data-validation-help="Name has to be unique" data-validation-error-msg="Name is not in proper form">
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <div class="col-md-6">
                                    <label for="validationServer01">Width Size</label>
                                    <input class="form-control is-valid" type="text" name="width" placeholder="Enter Image Width" data-validation="required number" data-validation-allowing="range[50;2000]"  data-validation-help="Width Range 50 to 2000" data-validation-error-msg="Width isn't within range">
                                </div>
                                <div class="col-md-6">
                                    <label for="validationServer01">Height Size</label>
                                    <input class="form-control is-valid" type="text" name="height" placeholder="Enter Image Height" data-validation="required number" data-validation-allowing="range[50;2000]"  data-validation-help="Height Range 50 to 2000" data-validation-error-msg="Height isn't within range">
                                </div>
                            </div>
                            
                            <br>
                            
                            <div class="form-row">
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