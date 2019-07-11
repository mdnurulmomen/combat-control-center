
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left">Disabled Daily Login Rewards List </h3>
                </div>

                @if(auth()->user()->can('read'))

                <div class="col-6">
                    <a  href="{{route('admin.view_enabled_login_rewards')}}"  class="btn btn-outline-success float-right btn-sm" type="button">
                        <i class="fa fa-list" aria-hidden="true"></i>
                        Enabled Rewards
                    </a>
                </div>

                @endif

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

                                @if(auth()->user()->can('update'))

                                <th class="actions">Actions</th>

                                @endif

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
                                <td>{{ $loginReward->rewardType->reward_type_name }}</td>
                                <td>{{ $loginReward->amount }}</td>

                                @if(auth()->user()->can('update'))
                                
                                <td>
                                    <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#undoDailyReward{{$loginReward->id}}" title="Delete">
                                        <i class="fa fa-fw fa-undo" style="transform: scale(1.5);"></i>
                                    </button>      
                                </td>

                                @endif
                            </tr>

                        @if(auth()->user()->can('update'))
                        <!-- Delete Modal -->                       
                        <div class="modal fade" id="undoDailyReward{{$loginReward->id}}" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.restore_login_rewards', $loginReward->id) }}">

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

                        @endif  

                        @endforeach

                        </tbody>
                    </table>

                    <div class="float-right">
                        {{ $allLoginRewards->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop