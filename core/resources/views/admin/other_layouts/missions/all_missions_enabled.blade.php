
@extends('admin.master_layout.app')
@section('contents')

    <div class="card mb-4">
        <div class="card-body">
            
            <div class="row">
                <div class="col-6">
                    <h3 class="float-left"> Enabled Missions List </h3>
                </div>


                <div class="col-6">

                    @if(auth()->user()->can('read'))

                    <a  href="{{route('admin.view_disabled_missions')}}"  class="btn btn-outline-danger float-right btn-sm mr-1 ml-1" type="button">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Disabled Missions
                    </a>

                    @endif

                {{-- 
                    @if(auth()->user()->can('create'))

                    <button type="button" class="btn btn-info float-right btn-sm mr-1 ml-1" data-toggle="modal" data-target="#addType">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        New Mission Type
                    </button>

                    @endif 
                            --}}

                    @if(auth()->user()->can('create'))

                    <button type="button" class="btn btn-success float-right btn-sm" data-toggle="modal" data-target="#addModal">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        New Mission
                    </button>

                    @endif

                </div>

            </div>

            <hr>


            <div class="row">

                @if(auth()->user()->can('read'))
                <!--- View Modal --->
                <div class="modal fade" id="viewModal" role="dialog">
                    <div class="modal-dialog  modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4> Mission Package Details </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">  
                                <div class="form-row name">
                                    <div class="col-md-6">
                                        <label for="validationServerUsername">Package Name</label>
                                    </div>
                                        
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row mission_type">
                                    <div class="col-md-6">
                                        <label for="validationServerUsername">Mission Type</label>
                                    </div>
                                        
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>
                                
                                <div class="form-row description">
                                    <div class="col-md-6">
                                        <label for="validationServerUsername">Description</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>
                                
                                <div class="form-row play_number">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Number Game </label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row play_time">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Play Time</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row damage_opponent">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Damage Opponent</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row kill_opponent">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Kill Opponent</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row kill_monster">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Kill Monster</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row travel_distance">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Travel Distance</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row win_top_time">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Be Winner</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row among_two_time">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Be Among Two</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row among_three_time">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Be Among Three</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row among_five_time">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Be Among Five</label>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row reward_amount">
                                    <div class="col-md-6">
                                        <label for="validationServer01">Reward Amount</label>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="form-row closeButton mt-5">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif
                
                @if(auth()->user()->can('delete'))
                <!-- Delete Modal -->                       
                <div class="modal fade" id="deleteModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
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
                                    <p class="text-muted">This item will be removed to recycle bin.</p>
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

                @if(auth()->user()->can('create'))
                

                <div class="modal fade" id="addModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3> Create Mission </h3>
                                <button type="button" class="close" data-dismiss="modal">
                                    &times;
                                </button>
                            </div>

                            <div class="modal-body">
                                
                                <form method="post" action= "{{ route('admin.created_mission_submit') }}" enctype="multipart/form-data">
                                    
                                    @csrf

                                    <div class="row">    
                                        <div class="col-md-12">
                                            <h4>Mission Identity</h4>
                                            <div class="tile">
                                                <div class="tile-body">    
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Mission Type</label>

                                                            <select class="form-control form-control-lg is-invalid" name="mission_type_id" required="true">
                                                                
                                                                <option disabled="true" selected="true">
                                                                    --Please Select Mission Type--
                                                                </option>

                                                                @foreach(App\Models\MissionType::all() as $missionType)


                                                                    <option value="{{ $missionType->id }}">
                                                                        {{ $missionType->mission_type_name }}
                                                                    </option>
                                                                
                                                                @endforeach

                                                            </select>
                                                        </div>

                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Mission Name</label>
                                                            <div class="input-group">
                                                                <input type="text" name="name" class="form-control form-control-lg is-invalid"  placeholder="Mission Name" required="true">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Mission Description</label>
                                                            <div class="input-group">
                                                                <input type="text" name="description" class="form-control form-control-lg is-valid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row more">    
                                        <div class="col-md-12">
                                            <h4>More Game Mission</h4>
                                            <div class="tile">
                                                <div class="tile-body">    
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServer01">Play Time</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ times</span>
                                                                </div>
                                                                <input type="number" name="play_number" class="form-control form-control-lg is-valid"  placeholder="Number Games to Play">

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServerUsername">Play Duration </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ hour</span>
                                                                </div>
                                                                <input type="number" name="play_time" class="form-control form-control-lg is-valid" placeholder="Play Duration"aria-describedby="inputGroupPrepend3" min="1" step="any">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row opponent">    
                                        <div class="col-md-12">
                                            <h4>Mission Opponent</h4>
                                            <div class="tile">
                                                <div class="tile-body">
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-12 mb-4">
                                                            <label for="validationServerUsername">Kill Target</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ player</span>
                                                                </div>
                                                                <input type="number" name="kill_opponent" class="form-control form-control-lg is-valid" placeholder="Kill Opponent Player" aria-describedby="inputGroupPrepend3">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row monster">
                                        <div class="col-md-12">
                                            <h4>Mission Monoster</h4>
                                            <div class="tile">
                                                <div class="tile-body">
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-12 mb-4">
                                                            <label for="validationServerUsername">Kill Target</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ monster</span>
                                                                </div>
                                                                <input type="number" name="kill_monster" class="form-control form-control-lg is-valid" placeholder="Kill Opponent Monster" aria-describedby="inputGroupPrepend3" step="any">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row win"> 
                                        <div class="col-md-12">
                                            <h4>Winning Mission</h4>
                                            <div class="tile">
                                                <div class="tile-body">
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-12 mb-4">
                                                            <label for="validationServerUsername">Win First Position </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ times</span>
                                                                </div>
                                                                <input type="number" name="win_top_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row among">  
                                        <div class="col-md-12">
                                            <h4>Mission Position Among</h4>
                                            <div class="tile">
                                                <div class="tile-body">
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Win Among Two </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ times</span>
                                                                </div>
                                                                <input type="number" name="among_two_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Win Among Three </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ times</span>
                                                                </div>
                                                                <input type="number" name="among_three_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Win Among Five </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ times</span>
                                                                </div>
                                                                <input type="number" name="among_five_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any">
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row reward">    
                                        <div class="col-md-12">
                                            <h4>Reward Details</h4>
                                            <div class="tile">
                                                <div class="tile-body">
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-12 mb-4">
                                                            <label for="validationServerUsername">Reward Amount</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ xp</span>
                                                                </div>
                                                                <input type="number" name="reward_amount" class="form-control form-control-lg is-valid rewardInput" placeholder="Amount of Reward" aria-describedby="inputGroupPrepend3">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-row">
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

            {{--

                @if(auth()->user()->can('create'))

                <div class="modal fade" id="addType" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3> Add Mission Type</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                
                                <form method="post" action= "{{ route('admin.created_mission_type_submit') }}" enctype="multipart/form-data">
                                    
                                    @csrf

                                    <div class="form-row">
                                        <div class="col-md-12 mb-4">
                                            <label for="validationServer01">Type Name</label>
                                            <div class="input-group">
                                                <input step="any" type="text" name="mission_type_name" class="form-control form-control-lg is-invalid"  placeholder="Type Name" required="true">
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary">Create Type</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                @endif 
                        --}}

                @if(auth()->user()->can('update'))

                <div class="modal fade" id="editModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3> Edit Mission </h3>
                                <button type="button" class="close" data-dismiss="modal">
                                    &times;
                                </button>
                            </div>

                            <div class="modal-body">
                                
                                <form method="post" action= "" enctype="multipart/form-data">
                                    
                                    @csrf
                                    @method('PUT')

                                    <div class="row">    
                                        <div class="col-md-12">
                                            <h4>Mission Identity</h4>
                                            <div class="tile">
                                                <div class="tile-body">    
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Mission Type</label>

                                                            <select class="form-control form-control-lg is-invalid" name="mission_type_id" required="true">
                                                                
                                                                @foreach(App\Models\MissionType::all() as $missionType)

                                                                    <option value="{{ $missionType->id }}">
                                                                        {{ $missionType->mission_type_name }}
                                                                    </option>
                                                                
                                                                @endforeach

                                                            </select>
                                                        </div>

                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Mission Name</label>
                                                            <div class="input-group">
                                                                <input type="text" name="name" class="form-control form-control-lg is-invalid"  placeholder="Mission Name" value="" required="true">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServer01">Mission Description</label>
                                                            <div class="input-group">
                                                                <input type="text" name="description" class="form-control form-control-lg is-valid" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row more">    
                                        <div class="col-md-12">
                                            <h4>More Game Mission</h4>

                                            <div class="tile">
                                                <div class="tile-body">
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServer01">Play Time</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ times</span>
                                                                </div>
                                                                <input type="number" name="play_number" class="form-control form-control-lg is-valid"  placeholder="Number Games to Play" value="">

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-4">
                                                            <label for="validationServerUsername">Play Duration </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ hour</span>
                                                                </div>
                                                                <input type="number" name="play_time" class="form-control form-control-lg is-valid" placeholder="Play Duration" aria-describedby="inputGroupPrepend3" min="1" step="any" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row opponent">    
                                        <div class="col-md-12">
                                            <h4>Mission Opponent</h4>
                                            <div class="tile">
                                                <div class="tile-body">
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-12 mb-4">
                                                            <label for="validationServerUsername">Kill Target</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ player</span>
                                                                </div>
                                                                <input type="number" name="kill_opponent" class="form-control form-control-lg is-valid" placeholder="Kill Opponent Player" aria-describedby="inputGroupPrepend3" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row monster">
                                        <div class="col-md-12">
                                            <h4>Mission Monster</h4>
                                            <div class="tile">
                                                <div class="tile-body">
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-12 mb-4">
                                                            <label for="validationServerUsername">Kill Target</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ monster</span>
                                                                </div>
                                                                <input type="number" name="kill_monster" class="form-control form-control-lg is-valid" placeholder="Kill Opponent Monster" aria-describedby="inputGroupPrepend3" step="any" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row win"> 
                                        <div class="col-md-12">
                                            <h4>Winning Mission</h4>
                                            <div class="tile">
                                                <div class="tile-body">
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-12 mb-4">
                                                            <label for="validationServerUsername"> Winning Target </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ times</span>
                                                                </div>
                                                                <input type="number" name="win_top_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row among">  
                                        <div class="col-md-12">
                                            <h4>Mission Position Among</h4>
                                            <div class="tile">
                                                <div class="tile-body">
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Win Among Two </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ times</span>
                                                                </div>
                                                                <input type="number" name="among_two_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Win Among Three </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ times</span>
                                                                </div>
                                                                <input type="number" name="among_three_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label for="validationServerUsername">Win Among Five </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ times</span>
                                                                </div>
                                                                <input type="number" name="among_five_time" class="form-control form-control-lg is-valid" placeholder="" aria-describedby="inputGroupPrepend3" step="any" value="">
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row reward">    
                                        <div class="col-md-12">
                                            <h4>Reward Details</h4>
                                            <div class="tile">
                                                <div class="tile-body">
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-12 mb-4">
                                                            <label for="validationServerUsername">Reward Amount</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">@ xp</span>
                                                                </div>
                                                                <input type="number" name="reward_amount" class="form-control form-control-lg is-valid rewardInput" placeholder="Amount of Reward" aria-describedby="inputGroupPrepend3" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <br>

                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary">Update</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                @endif  

            </div>

            <div class="row">
                <div class="col-12 table-responsive">

                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%" id="missionsTable">

                        <thead class="thead-dark">
                            <tr>
                                <th>Mission Serial</th>
                                <th>Mission Name</th>
                                <th>Mission Type</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        
                    </table>

                </div>
            </div>
        </div>


    </div>
@stop

@push('scripts')

   <script type="text/javascript">
       
        $( document ).ready(function() {

            var globalVariable = 0;

            $('#missionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.view_enabled_missions') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { 
                        data: function(data){
                            if (data.mission_type) {
                                return data.mission_type.mission_type_name;
                            }
                            else
                                return 'No Name';
                        }, 
                        name: 'mission_type.mission_type_name', 
                        orderable : false, 
                        searchable : false 
                    },
                    { data: 'action', name: 'action', orderable: false }
                ],
                drawCallback: function( settings ) {
                    
                    var api = this.api();
                    
                    var jsonData = api.ajax.json();

                    globalVariable = jsonData.data;

                    // console.log(globalVariable);
                }
            });

            $('#missionsTable').on( 'draw.dt', function () {

                @if(auth()->user()->can('read'))
                
                $(".fa-eye").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    // console.log(expectedObject);

                    $( "#viewModal .form-row").hide();

                    if (expectedObject.name) {

                        $("#viewModal .form-row.name").show();
                        $( "#viewModal p:eq(0)" ).html( expectedObject.name );
                    }
                    if (expectedObject.mission_type) {

                        $("#viewModal .form-row.mission_type").show();
                        $( "#viewModal p:eq(1)" ).html( expectedObject.mission_type.mission_type_name );
                    }

                    if (expectedObject.description) {

                        $("#viewModal .form-row.description").show();
                        $( "#viewModal p:eq(2)" ).html( expectedObject.description );
                    }

                    if (expectedObject.play_number) {

                        $("#viewModal .form-row.play_number").show();
                        $( "#viewModal p:eq(3)" ).html( expectedObject.play_number  + " times" );
                    }

                    if (expectedObject.play_time) {

                        $("#viewModal .form-row.play_time").show();
                        $( "#viewModal p:eq(4)" ).html( expectedObject.play_time  + " hours" );
                    }

                    if (expectedObject.damage_opponent) {

                        $("#viewModal .form-row.damage_opponent").show();
                        $( "#viewModal p:eq(5)" ).html( expectedObject.damage_opponent + " times"  );
                    }

                    if (expectedObject.kill_opponent) {

                        $("#viewModal .form-row.kill_opponent").show();
                        $( "#viewModal p:eq(6)" ).html( expectedObject.kill_opponent );
                    }

                    if (expectedObject.kill_monster) {

                        $("#viewModal .form-row.kill_monster").show();
                        $( "#viewModal p:eq(7)" ).html( expectedObject.kill_monster );
                    }

                    if (expectedObject.travel_distance) {

                        $("#viewModal .form-row.travel_distance").show();
                        $( "#viewModal p:eq(8)" ).html( expectedObject.travel_distance + " meters");
                    }

                    if (expectedObject.win_top_time) {

                        $("#viewModal .form-row.win_top_time").show();
                        $( "#viewModal p:eq(9)" ).html( expectedObject.win_top_time + " times" );
                    }

                    if (expectedObject.among_two_time) {

                        $("#viewModal .form-row.among_two_time").show();
                        $( "#viewModal p:eq(10)" ).html( expectedObject.among_two_time + " times" );
                    }

                    if (expectedObject.among_three_time) {

                        $("#viewModal .form-row.among_three_time").show();
                        $( "#viewModal p:eq(11)" ).html( expectedObject.among_three_time + " times" );
                    }

                    if (expectedObject.among_five_time) {

                        $("#viewModal .form-row.among_five_time").show();
                        $( "#viewModal p:eq(12)" ).html( expectedObject.among_five_time + " times" );
                    }

                    if (expectedObject.reward_amount) {

                        $("#viewModal .form-row.reward_amount").show();
                        $( "#viewModal p:eq(13)" ).html( expectedObject.reward_amount + " xp" );
                    }

                    $("#viewModal .form-row.closeButton").show();
                    $('#viewModal').modal('toggle');
                });

                @endif
                
                @if(auth()->user()->can('update'))

                $(".fa-edit").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    var home = "{{ URL::to('/') }}";

                    $("#editModal form").attr("action", home + '/admin/missions/' +  expectedObject.id );

                    // $( "#editModal .row:gt(0)").hide();
                    $( "#editModal .row:not(':first'):not('.reward')").hide();

                    $("#editModal select").val(expectedObject.mission_type_id);
                    $( "#editModal input[name*='name']" ).val( expectedObject.name );
                    $( "#editModal input[name*='description']" ).val( expectedObject.description );

                    if (expectedObject.play_number || expectedObject.play_time) {

                        $("#editModal .row.more").show();
                        
                    }

                    if (expectedObject.kill_opponent) {

                        $("#editModal .row.opponent").show();
                        
                    }

                    if (expectedObject.kill_monster) {

                        $("#editModal .row.monster").show();
                        
                    }

                    if (expectedObject.win_top_time) {

                        $("#editModal .row.win").show();
                        
                    }

                    if (expectedObject.among_two_time || expectedObject.among_three_time || expectedObject.among_five_time) {

                        $("#editModal .row.among").show();
                        
                    }

                    $( "#editModal input[name*='play_number']" ).val( expectedObject.play_number );
                    $( "#editModal input[name*='play_time']" ).val( expectedObject.play_time );

                    // $( "#editModal input[name*='damage_opponent']" ).val( expectedObject.damage_opponent );

                    $( "#editModal input[name*='kill_opponent']" ).val( expectedObject.kill_opponent );
                    $( "#editModal input[name*='kill_monster']" ).val( expectedObject.kill_monster );

                    // $( "#editModal input[name*='travel_distance']" ).val( expectedObject.travel_distance );

                    $( "#editModal input[name*='win_top_time']" ).val( expectedObject.win_top_time );
                    $( "#editModal input[name*='among_two_time']" ).val( expectedObject.among_two_time );
                    $( "#editModal input[name*='among_three_time']" ).val( expectedObject.among_three_time );
                    $( "#editModal input[name*='among_five_time']" ).val( expectedObject.among_five_time );

                    $( "#editModal input[name*='reward_amount']" ).val( expectedObject.reward_amount );

                    $('#editModal').modal('toggle');
                });

                @endif

                @if(auth()->user()->can('delete'))

                $(".fa-trash").click(function() {

                    var clickedRow = $(this).closest("tr");
                    var clickedRowId = clickedRow.attr('id');
                    var expectedObject = globalVariable.find( x => x.id === clickedRowId );

                    var home = "{{ URL::to('/') }}";

                    $("#deleteModal form").attr("action", home + '/admin/missions/' +  expectedObject.id );

                    $('#deleteModal').modal('toggle');
                });

                @endif


                $( "select[name='mission_type_id']" ).change(function() {

                    var openedModal = $(this).closest('.modal').attr('id');

                    // $( "#"+openedModal+" .row:gt(0)").hide();
                    
                    $( "#"+openedModal+" .row").not(':first').not(':last').hide();

                    
                    var selectedMissionType = $(this).find('option:selected').text();                    

                    // alert(selectedMissionType);

                    var missionTypes = [ "More", "Opponent", "Monster", "Win", "Among"];

                    var matchedType = '';

                    $.each( missionTypes, function( index, value ) {

                        var searchResult = selectedMissionType.search(value);
                        
                        // alert(searchResult);

                        if (searchResult > -1) {

                            matchedType = value.toLowerCase();
                            // alert(matchedType);
                            $( "#"+openedModal+" .row."+matchedType).show();
                        }

                    });

                });
                
               
                $( "input[type=number]:not(.rewardInput)" ).keypress(function() {

                    // $('input[type=number]').not(this).not(':last').val('');
                    $('input[type=number]').not(this).not('.rewardInput').val('');


                });

            });  
        });

   </script>

@endpush