
@extends('admin.master_layout.app')

@push('extraStyleLink')
    <meta http-equiv="expires" content="0">
    <meta name="csrf_token" content = "{{ csrf_token() }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
@endpush

@section('contents')
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left"> Campaigns List </h3>
                </div>

                <div class="col-6">

                    @if(auth()->user()->can('read'))
                    <a  href="{{route('admin.view_disabled_campaigns')}}"  class="btn btn-outline-danger float-right btn-sm mr-1 ml-1" type="button">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Disabled Campaigns
                    </a>
                    @endif

                    @if(auth()->user()->can('create'))
                    <button type="button" id="createCampaignButton" class="btn btn-info float-right btn-sm" data-toggle="modal" data-target="#commonModal">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        New Campaign
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
                            
                        @else
                            @foreach($campaigns as $campaign)

                            <tr>
                                <td>{{ $campaign->name }}</td>
                                <td>{{ $campaign->total_impression }}</td>
                                <td>{{ $campaign->unique_impression }}</td>
                                <td>
                                    @if($campaign->status)
                                        <span class="badge badge-success">Enabled</span>
                                    @else
                                        <span class="badge badge-danger">Disabled</span>
                                    @endif
                                </td>

                                @if(auth()->user()->can('update'))
                                
                                <td>
                                    <button class="btn btn-outline-success" name="editCampaignButton" data-toggle="modal" data-target="#commonModal" title="edit" data-campaignDetails="{{$campaign}}" data-allImageCategoryNames="{{ App\Models\CampaignImageCategory::select(['id', 'name'])->get() }}">
                                        <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                                    </button>

                                    <button class="btn btn-outline-danger" name="deleteCampaignButton" data-toggle="modal" data-target="#deleteModal" title="Delete" data-campaignId="{{$campaign->id}}">
                                        <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                                    </button>
                                </td>

                                @endif
                            </tr>
                            
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        @if(auth()->user()->can('create'))   
            <div class="modal fade" id="commonModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3> <span class="crudOperation"></span> Campaign </h3>
                            <button type="button" class="close" data-dismiss="modal">
                                &times;
                            </button>
                        </div>

                        <div class="modal-body">
                            
                            <form method="POST" action="{{route('admin.created_campaign_submit')}}" enctype="multipart/form-data">
                                
                                <div id="formMethod"></div>
                                @csrf

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
                                        <h4 class="title-title text-right">
                                            <span class="bg-secondary text-white">Image Details</span>
                                        </h4>
                                    </div>
                                    
                                    @foreach(App\Models\CampaignImageCategory::all() as $campaignImageCategory)
                                    <div class="col-6">
                                        <h4 class="title-title">{{ $campaignImageCategory->name }}</h4>
                                        <div class="tile">
                                            <div class="tile-body">
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-4">
                                                        <label for="validationServer01">Image 1</label>
                                                        <input type="hidden" name="{{'uploaded_'.str_replace(' ','_', $campaignImageCategory->name )}}[1]">
                                                        <input class="form-control" type="file" accept="image/*" name="{{str_replace(' ','_', $campaignImageCategory->name )}}[]" onChange="previewImage(event, '{{str_replace(' ','_', $campaignImageCategory->name )}}', 1)">
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <img class="img-fluid" id="preview_{{str_replace(' ','_', $campaignImageCategory->name )}}1" />
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-4">
                                                        <label for="validationServer01">Image 2</label>
                                                        <input type="hidden" name="{{'uploaded_'.str_replace(' ','_', $campaignImageCategory->name )}}[2]">
                                                        <input class="form-control" type="file" accept="image/*" name="{{str_replace(' ','_', $campaignImageCategory->name )}}[]" onChange="previewImage(event, '{{str_replace(' ','_', $campaignImageCategory->name )}}', 2)">
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <img class="img-fluid" id="preview_{{str_replace(' ','_', $campaignImageCategory->name )}}2"  width="200"/>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-4">
                                                        <label for="validationServer01">Image 3</label>
                                                        <input type="hidden" name="{{'uploaded_'.str_replace(' ','_', $campaignImageCategory->name )}}[3]">
                                                        <input class="form-control" type="file" accept="image/*" name="{{str_replace(' ','_', $campaignImageCategory->name )}}[]" onChange="previewImage(event, '{{str_replace(' ','_', $campaignImageCategory->name )}}', 3)">
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <img class="img-fluid" id="preview_{{str_replace(' ','_', $campaignImageCategory->name )}}3" width="200"/>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-4">
                                                        <label for="validationServer01">Image 4</label>
                                                        <input type="hidden" name="{{'uploaded_'.str_replace(' ','_', $campaignImageCategory->name )}}[4]">
                                                        <input class="form-control" type="file" accept="image/*" name="{{str_replace(' ','_', $campaignImageCategory->name )}}[]" onChange="previewImage(event, '{{str_replace(' ','_', $campaignImageCategory->name )}}', 4)">
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <img class="img-fluid" id="preview_{{str_replace(' ','_', $campaignImageCategory->name )}}4" width="200"/>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-4">
                                                        <label for="validationServer01">Image 5</label>
                                                        <input type="hidden" name="{{'uploaded_'.str_replace(' ','_', $campaignImageCategory->name )}}[5]">
                                                        <input class="form-control" type="file" accept="image/*" name="{{str_replace(' ','_', $campaignImageCategory->name )}}[]" onChange="previewImage(event, '{{str_replace(' ','_', $campaignImageCategory->name )}}', 5)">
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <img class="img-fluid" id="preview_{{str_replace(' ','_', $campaignImageCategory->name )}}5" width="200"/>
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
                                        <button type="submit" class="btn btn-lg btn-block btn-primary">
                                            <span class="crudOperation"></span> Campaign 
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(auth()->user()->can('delete'))
            
            <!-- Modal -->
            <div class="modal fade" id="deleteModal" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirmation</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form method="POST" action="">

                            @method('DELETE')
                            @csrf

                            <div class="modal-body">
                                <p>You are about to delete.</p> 
                                                
                                <p class="text-muted">This campaign will be removed to recycle bin.</p>
                                
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

    </div>

@stop

@push('scripts')
    
    <script>

        $(function() {
        
            @if(auth()->user()->can('create') || auth()->user()->can('update'))

                $('.datePicker').datepicker({
                    dateFormat: "yy-mm-dd",
                    minDate: 0
                });

            @endif

            @if(auth()->user()->can('create'))

                $("button#createCampaignButton").click(function() {

                    $("div#commonModal form").trigger('reset');
                    $("#commonModal img").removeAttr("src");
                    $('span.crudOperation').html('Create');
                    $('div#formMethod').empty();
                    $("#commonModal form").attr("action", "{{route('admin.created_campaign_submit')}}");
                });

            @endif

            @if(auth()->user()->can('update'))

                $("button[name='editCampaignButton']").click(function() {
                    
                    $("div#commonModal form").trigger('reset');
                    $("#commonModal img").removeAttr("src");
                    $('span.crudOperation').html('Update');
                    $('div#formMethod').html("<input type='hidden' name='_method' value='PUT'>");

                    var campaignImageCategories = $(this).attr("data-allImageCategoryNames");
                    campaignImageCategories = JSON.parse(campaignImageCategories);
                    var campaignDetails = $(this).attr("data-campaignDetails");
                    campaignDetails = JSON.parse(campaignDetails);
                    
                    var baseUrl = "{{ URL::to('/') }}";
                    $("#commonModal form").attr("action", baseUrl + '/admin/campaigns/' +  campaignDetails.id );

                    $( "input[name='name']" ).val( campaignDetails.name );
                    $( "input[name='start_date']" ).val( campaignDetails.start_date );
                    $( "input[name='close_date']" ).val( campaignDetails.close_date );

                    if (campaignDetails.status) {

                        $("input[name='status']").bootstrapToggle('on');
                    }
                    else
                        $("input[name='status']").bootstrapToggle('off');

                    campaignImageCategories.forEach(function myFunction(campaignImageCategory, index) {

                        axios.post(
                            "{{ route('admin.campaign_category_images') }}", 
                            {
                                campaignId : campaignDetails.id, 
                                categoryId : campaignImageCategory.id
                            },
                            {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': $("meta[name='csrf_token']").attr('content')
                                }
                            }
                        )
                        .then(function (response) {

                            var baseUrl = "{{ URL::to('/') }}";
                            var campaignCategoryName = campaignImageCategory.name;
                            var campaignCategoryTrimmedName = campaignCategoryName.replace(/ /g, "_");

                            for(i=0; i<(response.data.length); i++){

                                $('#preview_'+campaignCategoryTrimmedName+(i+1)).attr('src', baseUrl + '/' + response.data[i].image_path);
                                $("input:hidden[name='uploaded_"+ campaignCategoryTrimmedName +"["+(i+1)+"]"+"']").val(response.data[i].image_path);
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                    });

                });


                $("button[name='deleteCampaignButton']").click(function() {

                    var campaignId = $(this).attr("data-campaignId");
                    var baseUrl = "{{ URL::to('/') }}";
                    $("#deleteModal form").attr("action", baseUrl + '/admin/campaigns/' +  campaignId );
                });

            @endif
        
        });

        @if(auth()->user()->can('create') || auth()->user()->can('update'))

        function previewImage(event, campaignImageCategoryName, imageIndex) {
                
            $( "input[name='uploaded_"+ campaignImageCategoryName+"["+imageIndex+"]"+"']" ).removeAttr('value');
            
            var input = event.target;
            // Ensure that you have a file before attempting to read it
            if (input.files && input.files[0]) {
                // create a new FileReader to read this image and convert to base64 format
                const file = input.files[0];
                $('#preview_'+campaignImageCategoryName+imageIndex).attr('src', URL.createObjectURL(file));
            }else {
                $('#preview_'+campaignImageCategoryName+imageIndex).removeAttr('src')
            }
        }

        @endif

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  
@endpush