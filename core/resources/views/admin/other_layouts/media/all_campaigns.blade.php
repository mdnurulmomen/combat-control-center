
@extends('admin.master_layout.app')

@push('extraStyleLink')

   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 

@endpush

@section('contents')

    <div class="card mb-4">
        <div class="card-body">

            <div class="row">
                <div class="col-6">
                    <h3 class="float-left"> Campaigns List </h3>
                </div>

                @if(auth()->user()->can('create'))

                <div class="col-6">
                    <button type="button" class="btn btn-info float-right btn-sm" data-toggle="modal" data-target="#addModal">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        New Campaign
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
                                <th>Name</th>
                                <th>Total Impressions</th>
                                <th>Unique Impressions</th>
                                <th>Status</th>

                                @if(auth()->user()->can('update'))

                                <th class="actions">Actions</th>

                                @endif

                            </tr>
                        </thead>

                        <tbody>

                        @if($campaigns->isEmpty())
                            <tr class="danger">
                                <td class="text-danger" colspan='5'>No Data Found</td>
                            </tr>
                        @endif
                        
                        @foreach($campaigns as $campaign)

                            <tr>
                                <td>{{ $campaign->name }}</td>
                                <td>{{ $campaign->total_impression }}</td>
                                <td>{{ $campaign->unique_impression }}</td>
                                <td>{{ $campaign->status }}</td>
                                
                                @if(auth()->user()->can('update'))

                                <td>
                                    <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal{{$campaign->id}}" title="edit">
                                        <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                    </button>

                                    <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal{{$campaign->id}}" title="Delete">
                                        <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                    </button>
                                </td>

                                @endif

                            </tr>

                            @if(auth()->user()->can('update'))
                        
                            @endif

                            @if(auth()->user()->can('delete'))
                            
                        {{-- 
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{$campaign->id}}" role="dialog">
                                <div class="modal-dialog">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Confirmation</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <form method="POST" action="{{ route('admin.delete_campaign', $campaign->id) }}">
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
                                    --}}

                            @endif

                        @endforeach
                        
                        </tbody>
                    </table>
                    
                    <div class="float-right">
                        {{ $campaigns->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->can('create'))

        <div class="modal fade" id="addModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3> Create Campaign </h3>
                        <button type="button" class="close" data-dismiss="modal">
                            &times;
                        </button>
                    </div>

                    <div class="modal-body">
                        
                        <form method="POST" action = "{{ route('admin.created_campaign_submit') }}" enctype="multipart/form-data">

                            @csrf
                            @method('post')

                            <div class="row">
                                <div class="col-12">
                                    <h4 class="title-title text-right"><span class="bg-secondary text-white">Date Details</span></h4>
                                </div>

                                <div class="col-12">
                                    <div class="tile">
                                        <div class="tile-body">   
                                            
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Campaign Name</label>
                                                <div class="col-md-9">
                                                    <input class="form-control is-valid" type="text" name="name" placeholder="Enter Campaign name" required="true">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Starting Date</label>
                                                <div class="col-md-9">
                                                    <input class="form-control is-valid datePicker" type="text" name="start_date" placeholder="Select Date">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Closing Date</label>
                                                <div class="col-md-9">
                                                    <input class="form-control is-valid datePicker" type="text" name="close_date" placeholder="Select Date">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Status</label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" name="status" checked data-toggle="toggle" data-on="<i class='fa fa-check fa-3x'></i>" data-off="<i class='fa fa-times fa-3x'></i>" data-onstyle="success" data-offstyle="danger">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12">
                                    <h4 class="title-title text-right"><span class="bg-secondary text-white">Image Details</span></h4>
                                </div>

                                @foreach(App\Models\CampaignImageCategory::all() as $campaignImageCategory)
                                
                                <div class="col-6">
                                    <h4 class="title-title">{{ $campaignImageCategory->name }}</h4>
                                    <div class="tile">
                                        <div class="tile-body">

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Image 1</label>
                                                    <input class="form-control" type="file" accept="image/*" name="{{ str_replace(" ", "_", $campaignImageCategory->name)  }}[]" onchange="loadFile(event)">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <img id="output" class="img-fluid"/>
                                                </div>
                                            </div>  
                                            

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Image 2</label>
                                                    <input class="form-control" type="file" accept="image/*" name="{{ str_replace(" ", "_", $campaignImageCategory->name) }}[]">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <img class="img-fluid"/>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Image 3</label>
                                                    <input class="form-control" type="file" accept="image/*" name="{{ str_replace(" ", "_", $campaignImageCategory->name) }}[]">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <img class="img-fluid"/>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Image 5</label>
                                                    <input class="form-control" type="file" accept="image/*" name="{{ str_replace(" ", "_", $campaignImageCategory->name) }}[]">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <img class="img-fluid"/>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Image 5</label>
                                                    <input class="form-control" type="file" accept="image/*" name="{{ str_replace(" ", "_", $campaignImageCategory->name) }}[]">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <img class="img-fluid"/>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                @endforeach

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


        @if(auth()->user()->can('update'))

        <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3> Update Campaign </h3>
                        <button type="button" class="close" data-dismiss="modal">
                            &times;
                        </button>
                    </div>

                    <div class="modal-body">
                        
                        <form method="POST" action = "{{ route('admin.created_campaign_submit') }}" enctype="multipart/form-data">

                            @csrf
                            @method('post')

                            <div class="row">
                                <div class="col-12">
                                    <h4 class="title-title text-right"><span class="bg-secondary text-white">Date Details</span></h4>
                                </div>

                                <div class="col-12">
                                    <div class="tile">
                                        <div class="tile-body">   
                                            
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Campaign Name</label>
                                                <div class="col-md-9">
                                                    <input class="form-control is-valid" type="text" name="name" required="true">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Starting Date</label>
                                                <div class="col-md-9">
                                                    <input class="form-control is-valid datePicker" type="text" name="start_date" placeholder="Select Date">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Closing Date</label>
                                                <div class="col-md-9">
                                                    <input class="form-control is-valid datePicker" type="text" name="close_date" placeholder="Select Date">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Status</label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" name="status" checked data-toggle="toggle" data-on="<i class='fa fa-check fa-3x'></i>" data-off="<i class='fa fa-times fa-3x'></i>" data-onstyle="success" data-offstyle="danger">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12">
                                    <h4 class="title-title text-right"><span class="bg-secondary text-white">Image Details</span></h4>
                                </div>

                                @foreach(App\Models\CampaignImageCategory::all() as $campaignImageCategory)
                                
                                <div class="col-6">
                                    <h4 class="title-title">{{ $campaignImageCategory->name }}</h4>
                                    <div class="tile">
                                        <div class="tile-body">

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Image 1</label>
                                                    <input class="form-control" type="file" accept="image/*" name="{{ str_replace(" ", "_", $campaignImageCategory->name)  }}[]" onchange="loadFile(event)">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <img id="output" class="img-fluid"/>
                                                </div>
                                            </div>  
                                            

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Image 2</label>
                                                    <input class="form-control" type="file" accept="image/*" name="{{ str_replace(" ", "_", $campaignImageCategory->name) }}[]">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <img class="img-fluid"/>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Image 3</label>
                                                    <input class="form-control" type="file" accept="image/*" name="{{ str_replace(" ", "_", $campaignImageCategory->name) }}[]">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <img class="img-fluid"/>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Image 5</label>
                                                    <input class="form-control" type="file" accept="image/*" name="{{ str_replace(" ", "_", $campaignImageCategory->name) }}[]">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <img class="img-fluid"/>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="validationServer01">Image 5</label>
                                                    <input class="form-control" type="file" accept="image/*" name="{{ str_replace(" ", "_", $campaignImageCategory->name) }}[]">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <img class="img-fluid"/>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                @endforeach

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

@push('scripts')
   
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script>

        $( function() {

            $('.datePicker').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0
            });

        });

    </script>

    <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
  
@endpush