
@extends('admin.master_layout.app')

@push('extraStyleLink')
    <meta name="csrf_token" content = "{{ csrf_token() }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
@endpush

@section('contents')

    <div class="card mb-4" id="appCampaign">
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

            <div class="row" id="listCampaign">
                <list-campaigns :campaigns="{{$campaigns}}" :update='true'></list-campaigns>
            </div>
        </div>

        {{-- @dd(route('admin.created_campaign_submit')) --}}
        {{-- {{route('admin.created_campaign_submit')}} --}}

        @if(auth()->user()->can('create'))
            <div id="createComponent">
                <create-campaign 
                :campaign-image-categories="{{ App\Models\CampaignImageCategory::select('name')->get() }}" 
                create-campaign-route = "{{route('admin.created_campaign_submit')}}"
                @create-campaign-request="createCampaignRequest"/>
                            
            </div>
        @endif


        @if(auth()->user()->can('update'))

        @endif


        @if(auth()->user()->can('delete'))
            
        @endif

    </div>

@stop

@push('scripts')
   
    {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>

    <script src="{{ asset('assets/admin/js/campaign.js') }}"></script>
    
    {{-- <script type="text/javascript" src="{{ asset('assets/admin/js/app.js') }}"></script> --}}

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script>
        $( function() {
            $('.datePicker').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0
            });
        });

        /*new Vue({
            
            el : '#appCampaign'

        });*/

    </script>

    {{-- <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script> --}}
  
@endpush