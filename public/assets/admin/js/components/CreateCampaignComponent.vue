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


<script>
    export default {
        mounted(){
            console.log('Create Campaign Component');
        }
    }
</script>