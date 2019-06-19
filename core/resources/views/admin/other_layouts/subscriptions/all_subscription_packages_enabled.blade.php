
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left"> Enabled Subscription Packages List </h3>
                </div>

                <div class="col-6">
                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal">
                        New Package
                    </button>
                </div>

            </div>

            <hr>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">

                        <thead class="thead-dark">
                            <tr>
                                <th>Package Serial</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                        @if($subscriptionPackages->isEmpty())
                            <tr class="danger">
                                <td class="text-danger" colspan='5'>No Data Found</td>
                            </tr>
                        @endif
                        
                        @foreach($subscriptionPackages as $package)
                            <tr>
                                <td>{{ $package->id }}</td>
                                <td>{{ $package->name ?? 'No Name' }}</td>
                                <td>{{ $package->subscriptionPackageType->name }}</td>
                                <td>

                                    <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$package->id}}">
                                        <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                    </button>

                                    <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$package->id}}" title="Delete">
                                        <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                    </button>
                                        
                                </td>
                            </tr>

                        
                        <!-- Delete Modal -->                       
                        <div class="modal fade" id="deleteModal{{$package->id}}" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.delete_subscription_package', $package->id) }}">

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
                        

                        <div class="modal fade" id="editModal{{$package->id}}" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h3> Edit Package </h3>
                                        <button type="button" class="close" data-dismiss="modal">
                                            &times;
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        
                                        <form method="post" action= "{{ route('admin.updated_subscription_package_submit', $package->id) }}" enctype="multipart/form-data">
                                            
                                            @csrf
                                            @method('PUT')

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Package Type</label>

                                                    <select class="form-control form-control-lg is-invalid" name="subcription_package_type_id" required="true">
                                                        
                                                        @foreach(App\Models\SubscriptionPackageType::all() as $packageType)
                                                        <option value="{{ $packageType->id }}" @if($package->subcription_package_type_id == $packageType->id) selected="true" @endif>
                                                            {{ $packageType->name }}
                                                        </option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Package Name </label>
                                                    <div class="input-group">
                                                        <input type="text" name="name" class="form-control form-control-lg is-valid"  value="{{ $package->name ?? 'No Name'}}">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-row">
                                                <div class="col-md-12 mb-4 offered_time @if($package->offered_time==0)  d-none @endif">
                                                    <label for="validationServer01">Offered Hour </label>
                                                    <div class="input-group">
                                                        <input step="1" type="number" name="offered_time" class="form-control form-control-lg is-valid"  value="{{ $package->offered_time ?? 0 }}" min="0">
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-4 offered_game @if($package->offered_game==0)  d-none @endif">
                                                    <label for="validationServer01">Offered Game </label>
                                                    <div class="input-group">
                                                        <input step="1" type="number" name="offered_game" class="form-control form-control-lg is-valid"  value="{{ $package->offered_game ?? 0 }}" min="0">
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
                        {{ $subscriptionPackages->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3> Create Package </h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        
                        <form method="post" action= "{{ route('admin.created_subscription_package_submit') }}" enctype="multipart/form-data">
                                            
                            @csrf

                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">Package Type</label>

                                    <select class="form-control form-control-lg is-invalid" name="subcription_package_type_id" required="true">
                                        
                                        @foreach(App\Models\SubscriptionPackageType::all() as $packageType)
                                        <option value="{{ $packageType->id }}">
                                            {{ $packageType->name }}
                                        </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="validationServer01">Package Name </label>
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control form-control-lg is-valid"  placeholder="Package Name">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="col-md-12 mb-4 offered_time">
                                    <label for="validationServer01">Offered Hour </label>
                                    <div class="input-group">
                                        <input step="1" type="number" name="offered_time" class="form-control form-control-lg is-valid" placeholder="Free Hours" min="0">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4 d-none offered_game">
                                    <label for="validationServer01">Offered Game </label>
                                    <div class="input-group">
                                        <input step="1" type="number" name="offered_game" class="form-control form-control-lg is-valid"  placeholder="Free Match" min="0">
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-lg btn-block btn-primary">
                                        Create
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">

            $( "select" ).change(function() {
  
                var str = $("option:selected", this).text();
                
                // alert( str );

                if (str.includes("Hour")) {
                    
                    // alert('Hour');

                    $(".offered_game").hide();
                    $(".offered_time").show();
                    $(".offered_time").removeClass('col-md-6 d-none').addClass('col-md-12');
                }
                else{
                    
                    // alert('Match');
                    
                    $(".offered_time").hide();
                    $(".offered_game").show();
                    $(".offered_game").removeClass('col-md-6 d-none').addClass('col-md-12');
                }
              
            });

        </script>
    @endpush

@stop