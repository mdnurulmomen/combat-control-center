
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-12 table-responsive">
                        <h3 class="float-left"> Player List </h3>
                    </div>
                </div>
                
                <hr>

                <div class="row">
                    <div class="col-12 table-responsive">

                        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>Serial</th>
                                <th>User Name</th>
                                <th>Level</th>
                                <th>Action</th>

                            {{--
                                <th class="actions">Actions</th>
                                    --}}

                            </tr>
                            </thead>
                            <tbody>

                            @if($users->isEmpty())
                                <tr class="danger">
                                    <td class="text-danger" colspan='5'>No Data Found</td>
                                </tr>
                            @endif
                            
                            @foreach($users as $user)

                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->username ?? 'None' }}</td>
                                    <td>
                                        {{ $user->player->playerStatistics->player_level }}
                                    </td>

                                    <td>
                                        {{--

                                        <a href="{{ route('admin.update_player', $user->id) }}" class="btn btn-icon btn-pill btn-success" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>

                                            --}}

                                        <a href="" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal{{$user->id}}" title="Delete">
                                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                        </a>

                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal{{$user->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.delete_player', $user->id) }}">
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
                            {{ $users->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
@stop