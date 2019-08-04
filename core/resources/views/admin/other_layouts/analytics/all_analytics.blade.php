
@extends('admin.master_layout.app')
@section('contents')     

    <div class="row">
        
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Talktime</h3>

                <div class="card mb-3 border-dark">
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-4">
                                <label for="validationServerUsername">Start Date</label>
                                <div class="input-group">
                                    <input class="form-control datePicker talkTimeTable" type="text" name="talkTimeStartDate" placeholder="Select Date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="validationServerUsername">Close Date</label>
                                <div class="input-group">
                                    <input class="form-control datePicker talkTimeTable" type="text" name="talkTimeEndDate" placeholder="Select Date" autocomplete="off">
                                </div>
                            </div>

                        </div>                        

                        <div class="row">

                            <div class="col-md-6 text-center">
                                <div class="widget-small info">
                                    <i class="icon fa fa-stack  ">#</i>

                                    <div class="info">
                                        <h4 class="talkTimeNumber"><b>{{ $allTreasureRedemptions->count() }}</b> </h4>
                                    </div>
                                </div>    
                            </div>

                            <div class="col-md-6">
                                <div class="widget-small info">
                                    <i class="icon fa fa-money "></i>
                                    <div class="info">
                                        <h4 class="talkTimeCost">
                                            
                                            BDT : 
                                            <b>{{ $allTreasureRedemptions->sum('equivalent_price') }}</b> 
                                        </h4>
                                    </div>
                                </div>
                            </div> 

                        </div>
                    </div>
                </div> 
            </div>
        </div>

        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Earning</h3>

                <div class="card mb-3 border-dark">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="validationServerUsername">Start Date</label>
                                <div class="input-group">
                                    <input class="form-control datePicker earningTable" type="text" name="earningStartDate" placeholder="Select Date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="validationServerUsername">Close Date</label>
                                <div class="input-group">
                                    <input class="form-control datePicker earningTable" type="text" name="earningEndDate" placeholder="Select Date" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                        
                            <div class="col-md-12">
                                <div class="widget-small info">
                                    <i class="icon fa fa-money"></i>
                                    <div class="info">
                                        <h4 class="earningAmount">
                                            BDT : <b>{{ $updatedEarning->total_currency_earning }}</b> 
                                        </h4>
                                    </div>
                                </div>
                            </div>  
                                      
                        </div>   
                    </div>
                </div>
                
            </div>
        </div>
    </div>

@stop

@push('scripts')

    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.min.js') }}"></script>

    <script type="text/javascript">
        
        $( function() {

            $('.datePicker').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true
            });

            $("input.talkTimeTable").change(function() { 

                jQuery.ajax({

                    url: "{{ route('admin.show_talktime_analytics') }}",
                    method: 'get',
                    data: {
                        talkTimeStartDate: $("input[name=talkTimeStartDate]").val(),
                        talkTimeEndDate: $("input[name=talkTimeEndDate]").val(),
                    },

                    success: function(result){
                        
                        // console.log(result);
                        $('h4.talkTimeNumber').html('<b>' + result.totalNumber + '</b>');
                        $('h4.talkTimeCost').html('BDT : <b>' + result.totalCost + '</b>');

                    }
                });

            });

            $("input.earningTable").change(function() { 

                // alert($("input[name=earningEndDate]").val());

                jQuery.ajax({

                    url: "{{ route('admin.show_earnings_analytics') }}",
                    method: 'get',
                    data: {
                        earningStartDate: $("input[name=earningStartDate]").val(),
                        earningEndDate: $("input[name=earningEndDate]").val(),
                    },

                    success: function(result){
                        
                        $('h4.earningAmount').html('BDT : <b>' + result.totalEarning + '</b>');

                    }
                });

            });               

        });

    </script>

@endpush