
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <h3 class="float-left"> Moderators List </h3>
                    </div>

                    <div class="col-6">    
                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal">
                            Create Moderator
                        </button>
                    </div>
                </div>


                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Full Name</th>
                                    <th>Username </th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            @if($moderators->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($moderators as $moderator)
                                <tr>
                                    <td>{{$moderator->firstname}} {{$moderator->lastname}}</td>
                                    <td>{{ $moderator->username }}</td>
                                    <td>{{ $moderator->email }}</td>
                                    <td>{{ $moderator->phone }}</td>
                                    <td>
                                    {{--
                                        <a href="{{ route('admin.update_moderator', $moderator->id) }}" class="btn btn-icon btn-pill btn-success" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                            --}}

                                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#editModal{{$moderator->id}}" title="Edit">
                                            <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                        </button>    

                                        <button class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal{{$moderator->id}}" title="Delete">
                                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                        </button>
                                    </td>
                                </tr>


                                <!--- Edit Modal --->
                                <div class="modal fade" id="editModal{{$moderator->id}}" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h3> Edit Moderator </h3>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                
                                                <form method="post" action= "{{ route('admin.updated_moderator_submit', $moderator->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @Method('put')
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServer01">First name</label>
                                                            <input type="text" name="firstname" class="form-control form-control-lg is-valid"  placeholder="First Name" value="{{ $moderator->firstname }}">

                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServer02">Last name</label>
                                                            <input type="text" name="lastname" class="form-control form-control-lg is-valid"  placeholder="Last Name" value="{{ $moderator->lastname }}">
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServer01">Email</label>
                                                            <input type="text" name="email" class="form-control form-control-lg is-valid"  placeholder="Unique Email" value="{{ $moderator->email }}">

                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServerUsername">Username</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@</span>
                                                                </div>
                                                                <input type="text" name="username" class="form-control form-control-lg is-invalid" placeholder="Username" value="{{ $moderator->username }}" aria-describedby="inputGroupPrepend3">
                                                            </div>
                                                        </div>
                                                    </div>
                                                 
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServer02">Picture</label>
                                                            <input type="file" name="picture" class="form-control form-control-lg" accept="image/*">
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServer01">Phone</label>
                                                            <input type="tel" name="phone" class="form-control form-control-lg is-valid"  placeholder="Phone Number" value="{{ $moderator->phone }}">

                                                        </div>
                                                    </div>
                                                  
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer02">Address</label>
                                                            <input type="text" name="address" class="form-control form-control-lg is-valid"  placeholder="Address" value="{{ $moderator->address }}">

                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer03">City</label>
                                                            <input type="text" name="city" value="{{ $moderator->city }}" class="form-control form-control-lg is-valid" placeholder="City">

                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer05">Country</label>
                                                            <input type="text" name="country" value="{{ $moderator->country }}" class="form-control form-control-lg is-valid" placeholder="Country Name">
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
                                <div class="modal fade" id="deleteModal{{$moderator->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.delete_moderator', $moderator->id) }}">
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
                            {{ $moderators->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> Create Moderator </h3>
                            <button type="button" class="close" data-dismiss="modal">
                                &times;
                            </button>
                        </div>

                        <div class="modal-body">
                            
                            <form method="POST" action = "{{ route('admin.created_moderator_submit') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServer01">First name</label>
                                        <input type="text" name="firstname" class="form-control form-control-lg is-valid"  placeholder="First Name">

                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServer02">Last name</label>
                                        <input type="text" name="lastname" class="form-control form-control-lg is-valid"  placeholder="Last Name">

                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer01">Email</label>
                                        <input type="text" name="email" class="form-control form-control-lg is-valid"  placeholder="Email">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServerUsername">Username</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@</span>
                                            </div>
                                            <input type="text" name="username" class="form-control form-control-lg is-invalid" placeholder="Username"  aria-describedby="inputGroupPrepend3" required>

                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer01">Password</label>
                                        <input type="password" name="password" class="form-control form-control-lg is-invalid" placeholder="Chosse a Suitable Password" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServer02">Picture</label>
                                        <input type="file" name="picture" class="form-control form-control-lg" accept="image/*">

                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="validationServer01">Phone</label>
                                        <input type="tel" name="phone" class="form-control form-control-lg is-valid"  placeholder="Phone Number">

                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer02">Address</label>
                                        <input type="text" name="address" class="form-control form-control-lg is-valid"  placeholder="Address">

                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer03">City</label>
                                        <input type="text" name="city" class="form-control form-control-lg is-valid" placeholder="City">

                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="validationServer05">Country</label>
                                        <input type="text" name="country" class="form-control form-control-lg is-valid" placeholder="Country Name">
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