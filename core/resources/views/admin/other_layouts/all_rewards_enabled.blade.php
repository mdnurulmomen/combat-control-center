
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left">Enabled Daily Login Rewards List </h3>
                </div>

                <div class="col-6">
                    <button type="button" class="btn btn-info float-right mr-3 ml-3" data-toggle="modal" data-target="#addReward">
                        New Rewards
                    </button>
                </div>

            </div>

            <hr>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">

                        <thead class="thead-dark">
                            <tr>
                                <th>Type Serial</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                        @if($allLoginRewards->isEmpty())
                            <tr class="danger">
                                <td class="text-danger" colspan='5'>No Data Found</td>
                            </tr>
                        @endif

                        @foreach($allLoginRewards as $loginReward)
                            <tr>
                                <td>{{ $loginReward->id }}</td>
                                <td>{{ $loginReward->name }}</td>
                                <td>{{ $loginReward->rewardType->name }}</td>
                                <td>{{ $loginReward->amount }}</td>
                                <td>

                                    <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editDailyReward{{$loginReward->id}}">
                                        <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                    </button>

                                    <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteDailyReward{{$loginReward->id}}" title="Delete">
                                        <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                    </button>
                                        
                                </td>
                            </tr>

                        
                        <!-- Delete Modal -->                       
                        <div class="modal fade" id="deleteDailyReward{{$loginReward->id}}" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.delete_reward_type', $loginReward->id) }}">
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
                        
                        <!-- Edit Modal -->  
                        <div class="modal fade" id="editDailyReward{{$loginReward->id}}" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h3> Edit Reward Type</h3>
                                        <button type="button" class="close" data-dismiss="modal">
                                            &times;
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        
                                        <form method="post" action= "{{ route('admin.submit_updated_login_rewards', $rewardType->id) }}" enctype="multipart/form-data">
                                            
                                            @csrf
                                            @method('PUT')

                                            <div class="form-row">
                                                <div class="col-md-12 mb-4">
                                                    <label for="validationServer01">Reward Type Name </label>
                                                    <div class="input-group">
                                                        <input step="any" type="text" name="reward_type_name" class="form-control form-control-lg is-invalid"  value="{{ $rewardType->reward_type_name }}" required="true">
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
                                

                        @endforeach

                        </tbody>
                    </table>

                    <div class="float-right">
                        {{ $allLoginRewards->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>

        

        <div class="modal fade" id="addReward" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3> Add Login Reward</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        
                        <form method="post" action= "{{ route('admin.submit_created_login_rewards') }}" enctype="multipart/form-data">
                            
                            @csrf

                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">Reward Type</label>

                                    <div class="input-group">
                                        
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">Reward Name</label>
                                    <div class="input-group">
                                        <input step="any" type="text" name="name" class="form-control form-control-lg is-invalid"  placeholder="Reward Name">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">Amount</label>
                                    
                                    <div class="input-group">
                                        <input step="any" type="text" name="amount" class="form-control form-control-lg is-invalid"  placeholder="Reward Name" required="true">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">Description</label>
                                    <div class="input-group">
                                        <input step="any" type="text" name="description" class="form-control form-control-lg is-invalid"  placeholder="Reward Name">
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-lg btn-block btn-primary">Create Reward</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@stop