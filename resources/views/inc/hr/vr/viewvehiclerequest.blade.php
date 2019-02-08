@if(count($vrequest)>0)
    <div class="container">
        {{-- <div class="row">
            <div class="col-md">
                @foreach ($vrequestapprovaltypes as $vrequestapprovaltype)
                    <span>{{$vrequestapprovaltype}}</span><br>
                @endforeach
            </div>
        </div> --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <span class='approveLabel'>{{ $vrequest->vehicle_request_serial }} - {{ $vrequest->createdby->name }}</span>
            </div>
            <div class="col-md-6">
                @if ($vrequest->approval_id < $vrequestapprovaltypes->count())
                    <span class='approveLabel'>Waiting Approval: <span class='text-danger'>{{ $vrequestapprovaltypes->where('id',$vrequest->approval_id + 1)->first()->name }}</span></span>
                @else
                    <span class='approveLabel text-success'>Approval Complete</span>
                @endif                
            </div>            
        </div>
        <div class="row mb-3">            
            @if ( ($vrequest->approval_id >= 2) && Auth::user()->hrvr_approval_type == 3 )
                <div class="col-md-4">                        
                    <button id='vr_adminedit' type='button' class='btn btn-info hr_admin_label p-1 px-5'>Update Admin Arrangement</button>
                    <button id='vr_adminsave' type='button' class='btn btn-success hr_admin_input2 p-1 px-5' >SAVE</button>
                    <button id='vr_admincancel' type='button' class='btn btn-warning hr_admin_input2 p-1 px-5'>CANCEL</button>                        
                </div>
            @endif
            @if ( ((Auth::user()->hrvr_approval_type - 1) == $vrequest->approval_id  && Auth::user()->hrvr_approval_dept == $vrequest->department_id) || ((Auth::user()->hrvr_approval_type - 1) == $vrequest->approval_id))
                <div class="col-md-3">
                    <form id='vr_approveform' class='form_to_submit' method='POST' action='/1_atms/public/hr/vra/{{ $vrequest->id }}'>
                        @csrf
                        <button id='vr_approve_button' type='button' class='btn btn-success p-1 px-5 mb-2'>Approve Request</button>
                    </form>
                </div>
            @endif
        </div>
        <div class="row hr_admin_input">
            <div class="col-md p-3 border border-success">
                <form id='admin_arrange_form' method='POST' action='/1_atms/public/vehiclerequest/{{ $vrequest->id }}'>
                    @csrf
                    @method('PUT')
                    <div class="row ">        
                        <div class="col-md-3 form-group">
                            <label for='vehicle_id'>Vehicle:</label>
                            <select class='form-control border-info' name="vehicle_id" id="vehicle_id" value="{{$vrequest->vehicle_id}}">
                                <option value="0">- Select Vehicle -</option>
                                @foreach ($vehicles as $vehicle)
                                    @if ($vehicle->id == $vrequest->vehicle_id)
                                        <option value="{{$vehicle->id}}" selected>{{$vehicle->name}}</option>
                                    @else
                                        <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                    @endif                                
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="vr_driver">Driver:</label>
                            <input class='form-control border-info' id='vr_driver' name='driver' type='text' value='{{$vrequest->driver}}' placeholder='Enter driver name..'>
                        </div>
                        <div class="col-md form-group">
                            <label for="vr_remarks">Remarks:</label>
                            <input class='form-control border-info' id='vr_remarks' name='remarks' type='text' value='{{$vrequest->remarks}}' placeholder='Enter remarks..'>
                        </div>
                    </div>
                </form>
            </div>
        </div>        
        <div class="row">
            <div class="col-md">
                <span class='font-weight-bold text-muted'>APPROVALS:</span>
            </div>
        </div>
        <div class='row mb-3'>
            @if ($vrequestapprovals->count()>0)
                @foreach ($vrequestapprovals as $vrequestapproval)
                    <div class='col-md-3'>
                        <div class="card border-secondary">
                            <ul class="list-group list-group-flush text-center">
                                <li class="list-group-item p-1">
                                    <h5>                            
                                        <span class='badge badge-success badge-outlined'>
                                            {{ $vrequestapproval->approval->name }}
                                        </span>
                                    </h5>
                                </li>                                            
                                <li class="list-group-item p-0 font-weight-bold">
                                    {{ $vrequestapproval->approver->name }}
                                </li>                                               
                                <li class="list-group-item p-0 ">
                                    {{ $vrequestapproval->created_at }}
                                </li>
                            </ul>
                        </div> 
                    </div>
                @endforeach
            @else
                <div class="col-md">
                    <span>No Approvals</span>
                </div>
            @endif    
        </div>
        @if ($vrequest->created_by == Auth::user()->id || $vrequest->approval_id == 0)
        <div class="row mb-3">
            <div class="col-md">
                <button id='vr_edit' class='btn btn-info p-1 px-5 user_edit_label' type='button' >Edit Vehicle Request</button>
                <button id='vr_saveedit' class='btn btn-success p-1 px-5 user_edit_input1' type='button' >SAVE</button>
                <button id='vr_canceledit' class='btn btn-warning p-1 px-5 user_edit_input1' type='button' >CANCEL</button>
            </div>
        </div>                
        @endif
        {{-- --------------FORM--------------- --}}
        <form id='vr_useredit_form' action="/1_atms/public/vehiclerequest/{{ $vrequest->id }}" method="post">
            @csrf
            @method('PUT')
        <div class="row">        
            <div class="col-md border border-bottom-0">
                <div class="row">
                    <div class="col-md">
                        <span class="text-muted font-weight-bold">Date Prepared:</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        {{-- {{ date('Y-m-d',strtotime($vrequest->created_at)) }} --}}
                        {{ $vrequest->created_at }}                  
                    </div>
                </div>
            </div>
            <div class="col-md border-top border-right">
                <div class="row">
                    <div class="col-md">
                        <span class="text-muted font-weight-bold">Department:</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <span class='user_edit_label'>{{ $vrequest->department->name }}</span>
                        <select type="text" class="form-control custom-select border-info user_edit_input" id="department_id" name="department_id" placeholder="" required>
                            <option value="">- Select Department -</option>
                            @foreach($departments as $department)
                                @if ($department->id == $vrequest->department_id)
                                    <option value="{{$department->id}}" selected>{{$department->name}}</option>
                                @else
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                @endif                                
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md border">
                <div class="row">
                    <div class="col-md">
                        <span class="text-muted font-weight-bold">Name of User/s:</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <span class='user_edit_label'>{{ $vrequest->user }}</span>
                        <input class="form-control border-info user_edit_input" value='{{ $vrequest->user }}' type='text' id='position' name='user' required>
                    </div>
                </div>
            </div>
            <div class="col-md border border-left-0">
                <div class="row">
                    <div class="col-md">
                        <span class="text-muted font-weight-bold">Position:</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <span class='user_edit_label'>{{ $vrequest->position }}</span>
                        <input class="form-control border-info user_edit_input" value='{{ $vrequest->position }}' type='text' id='position' name='position' required>
                    </div>
                </div>                
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <span class="text-muted font-weight-bold">Official Business Details:</span>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md border border-right-0">
                <div class="row">
                    <div class="col-md">
                        <span class="text-muted font-weight-bold">Destination/Purpose:</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <span class='user_edit_label'>{{ $vrequest->purpose }}</span>
                        <textarea type="text" class="form-control border-info user_edit_input" rows="4" id="purpose" name="purpose" placeholder="" required>{{ $vrequest->purpose }}</textarea>
                    </div>
                </div>                
            </div>
            <div class="col-md">
                <div class="row">
                    <div class="col-md border border-bottom-0 text-center">
                        <span class="text-muted font-weight-bold">Date/Time of use:</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md border border-right-0">
                        <div class="row">
                            <div class="col-md">
                                <span class="text-muted font-weight-bold">Requested Date:</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <span class='user_edit_label'>{{ $vrequest->requested_date }}</span>
                                <input class="form-control border-info user_edit_input" value='{{ $vrequest->requested_date }}' type='date' id='requested_date' name='requested_date' required>
                            </div>
                        </div>                        
                    </div>
                    <div class="col-md">
                        <div class="row">
                            <div class="col-md border border-bottom-0">
                                <div class="row">
                                    <div class="col-md">
                                        <span class="text-muted font-weight-bold">Departure Time:</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <span class='user_edit_label'>{{ $vrequest->departure_time }}</span>
                                        <input class="form-control border-info user_edit_input" value='{{ $vrequest->departure_time }}' type='time' id='departure_time' name='departure_time' required>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md border">
                                <div class="row">
                                    <div class="col-md">
                                        <span class="text-muted font-weight-bold">Arrival Time:</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <span class='user_edit_label'>{{ $vrequest->arrival_time }}</span>
                                        <input class="form-control border-info user_edit_input" value='{{ $vrequest->arrival_time }}' type='time' id='arrival_time' name='arrival_time' required>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {{-- ---------------FORM END------------------ --}}
        </div>
        <div class="row">
            <div class="col-md">
                <span class="text-muted font-weight-bold">Admin Arrangement:</span>                
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md border border-right-0">
                <div class="row">
                    <div class="col-md">
                        <span class="text-muted font-weight-bold">Vehicle/Car:</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="">
                            @if (!empty($vrequest->vehicle_id))
                                {{ $vrequest->vehicle->name }}
                            @else
                                * To be filled up *
                            @endif
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="col-md border">
                <div class="row">
                    <div class="col-md">                        
                        <span class="text-muted font-weight-bold">Driver Name:</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="">
                            @if (!empty($vrequest->driver))
                                {{ $vrequest->driver }}
                            @else
                                * To be filled up *
                            @endif
                        </div>
                        {{-- <div class="hr_admin_input">                            
                            <input id='vr_driver' name='driver' type='text' class='form-control m-2 border-info' value='{{$vrequest->driver}}' placeholder='Enter driver'>
                        </div> --}}                       
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <span class="text-muted font-weight-bold">Others/Remarks</span>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md border">
                <div class="">
                    @if (!empty($vrequest->remarks))
                        {{ $vrequest->remarks }}
                    @else
                        * To be filled up *
                    @endif
                </div>
                {{-- <div class="hr_admin_input">                            
                    <input id='vr_remarks' name='remarks' type='text' class='form-control m-2 border-info' value='{{$vrequest->remarks}}' placeholder='Enter remarks'>
                </div> --}} 
            </div>
        </div>
    </div>
@else
    <div class='alert alert-danger'><h3>Vehicle Request not found.</h3></div>
@endif