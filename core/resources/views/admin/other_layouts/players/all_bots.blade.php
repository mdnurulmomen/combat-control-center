
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left"> Bots List </h3>
                    </div>    
                        
                    <div class="col-6">
                        <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#addModal">
                            Create Bot
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>Bot Serial</th>
                                <th>Bot User Name</th>
                                <th>Bot Level</th>
                                <th class="actions">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($bots->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($bots as $bot)
                                <tr>
                                    <td>{{ $bot->id }}</td>
                                    <td>{{ $bot->username }}</td>
                                    <td>{{ $bot->player->playerStatistics->player_level }}</td>
                                    <td>
                                    
                                    {{--
                                        <a href="{{ route('admin.update_bot', $bot->id) }}" class="btn btn-icon btn-pill btn-success" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                            --}}
                                        
                                        <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$bot->id}}" title="Edit">
                                            <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                        </button>   

                                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$bot->id}}" title="Delete">
                                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                        </button>

                                    </td>
                                </tr>

                                <!--Edit Modal -->
                                <div class="modal fade" id="editModal{{$bot->id}}" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h3> Edit Bot </h3>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                
                                                <form method="post" action = "{{ route('admin.updated_bot_submit', $bot->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @Method('put')
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Email</label>
                                                            <input type="text" name="email" value="{{ $bot->email }}" class="form-control form-control-lg is-valid"  placeholder="Email must be Unique">
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Username</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@</span>
                                                                </div>
                                                                <input type="text" name="username" value="{{ $bot->username }}" class="form-control form-control-lg is-invalid" placeholder="Username"  aria-describedby="inputGroupPrepend3" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="exampleFormControlSelect1">User Type</label>
                                                            <select class="form-control form-control-lg is-valid" name="type">
                                                                <option value="bot">Bot</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServer02">Location</label>
                                                            <input type="text" name="location" value="{{ $bot->location }}" class="form-control form-control-lg is-valid"  placeholder="Address">
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServer01">Phone</label>
                                                            <input type="tel" name="phone" value="{{ $bot->phone }}" class="form-control form-control-lg is-valid"  placeholder="Phone Number">
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

                                <!--Delete Modal -->
                                <div class="modal fade" id="deleteModal{{$bot->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.delete_bot', $bot->id) }}">
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
                            {{ $bots->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Create Bot </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            
                            <form method="POST" action = "{{ route('admin.created_bot_submit') }}" enctype="multipart/form-data">
                                @csrf
                                <br>
                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer01">Email</label>
                                        <input type="text" name="email" class="form-control form-control-lg is-valid"  placeholder="Email must be Unique">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServerUsername">Username</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@</span>
                                            </div>
                                            <input type="text" name="username" class="form-control form-control-lg is-valid" placeholder="Username"  aria-describedby="inputGroupPrepend3">

                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="exampleFormControlSelect1">User Type</label>
                                        <select class="form-control form-control-lg is-invalid" name="type" readonly>
                                            <option value="bot">Bot</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServer02">Location</label>
                                        <input type="text" name="location" class="form-control form-control-lg is-valid"  placeholder="Address">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServer01">Phone</label>
                                        <input type="tel" name="phone" class="form-control form-control-lg is-valid"  placeholder="Phone Number">
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