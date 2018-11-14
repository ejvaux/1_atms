@if(count($request)>0)
<div class='row'>
    <div class='col-md'>
        <div class="card" style='width:100%'>
            <h4 class="card-header font-weight-bold">
                <div class="row">
                    <div class="col-md-5">
                        #{{ $request->request_id }} - {{ $request->user->name }}
                    </div>
                    <div class="col-md ml-auto">
                        Created: {{ $request->created_at }}
                    </div>
                </div>                
            </h4>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-5">
                        <div class="row mb-2">
                            <div class="col-md">
                                <h3>{!! CustomFunctions::priority_format($request->priority_id) !!} {!! CustomFunctions::r_status_format($request->status_id) !!}</h3>            
                            </div>               
                        </div>
                        <div class="row mb-2">
                            <div class="col-md">
                                <h4 class="font-weight-bold">
                                    @if ($request->start_at == null)
                                        @if ($request->status_id == 2)
                                            On Queue
                                        @else
                                            Waiting for Queue
                                        @endif                                                
                                    @else
                                        @if($request->finish_at == null)
                                            {!! CustomFunctions::datetimelapse($request->start_at) !!}
                                        @else
                                            {!! CustomFunctions::datetimefinished($request->start_at,$request->finish_at) !!}
                                        @endif
                                    @endif                                       
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                @if (!empty($request->r_attach))
                                    <a href='{{ url("/report/".$request->r_attach) }}' id='show_report' class='btn btn-secondary'>Download Report</a>
                                @else
                                    <span class='text-muted font-weight-bold'>No Report</span>
                                @endif                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class='row '>
                            <div class='col-md-3'>                                    
                                <div class='row'>
                                    <div class='col-md '>
                                        <label for='department' class='font-weight-bold'><span class='text-muted'>Department:</span></label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label for='category' class='font-weight-bold'><span class='text-muted'>Location:</span></label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label for='category' class='font-weight-bold'><span class='text-muted'>Time:</span></label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label class='font-weight-bold'><span class='text-muted'>Start At:</span></label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label class='font-weight-bold'><span class='text-muted'>Finish At:</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-9'>                                    
                                <div class='row'>
                                    <div class='col-md '>
                                        <label class='font-weight-bold editrequestlabel '>{{ $request->department->name }}</label>
                                        <input type='hidden' id='departmentNewSelected' value='{{ $request->department_id }}'>
                                        <select type="text" class="form-control-sm editrequestinput border" id="departmentNew" name="department_id" style='display:none' required>
                                            <option value="">- Select Department -</option>
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}">{{$department->name}}</option>
                                            @endforeach
                                        </select>                                      
                                    </div>                                    
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label class='font-weight-bold editrequestlabel'>{{ $request->locationname->name }}</label>
                                        <input type='hidden' id='locationNewSelected' value='{{ $request->location }}'>
                                        <select type="text" class="form-control-sm editrequestinput border" id="locationNew" name="location" style='display:none' required>
                                            <option value="">- Select Location -</option>
                                            @foreach($locations as $location)
                                                <option value="{{$location->id}}">{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        {{-- <label class='font-weight-bold editrequestlabel '>{{ $request->category->name }}</label>
                                        <input type='hidden' id='categoryNewSelected' value='{{ $request->category_id }}'>
                                        <select type="text" class="form-control-sm editticketinput border" id="categoryNew" name="category_id" style='display:none' required>
                                            <option value="">- Select Category -</option>                            
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select> --}}
                                        <div class='font-weight-bold editrequestlabel'>
                                            {{ str_replace('T',' ',$request->start_time) }} -- {{ str_replace('T',' ',$request->end_time) }}
                                        </div>
                                        <div class='btn-group editrequestinput' style='display:none;'>
                                            <input type='hidden' id='start_timecurrent' value='{{ $request->start_time }}'>
                                            <input type='hidden' id='end_timecurrent' value='{{ $request->end_time }}'>
                                            <input class="form-control-sm" type='datetime-local' id='start_timeNew' name='start_time' style='width:40%' value='{{ $request->start_time }}'><span class='pt-2 mx-1'> to </span><input style='width:40%' class="form-control-sm" type='datetime-local' id='end_timeNew' name='end_time' value='{{ $request->end_time }}'>
                                        </div>                              
                                    </div>                                    
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label class='font-weight-bold'>{{ $request->start_at }}</label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label class='font-weight-bold'>{{ $request->finish_at }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>                                                                                
                    </div>
                </div>
                <div class='row mb-2'>
                    <div class='col-md-5'>
                        @if ($request->status_id == 6)
                            @if (Auth::user()->req_approver == 1)
                                <form class='form_to_submit' method='POST' action='/1_atms/public/cctvreview/{{ $request->id }}'>
                                    @method('PUT')
                                    @csrf
                                    <input type='hidden' name='approved' value='1'>
                                    <input type='hidden' name='status_id' value='1'>
                                    <input type='hidden' name='mod' value='approve'>
                                    <button type='submit' id='approve_request' class='btn btn-secondary'>Approve Request</button>
                                    <button type='button' id='reject_request' class='btn btn-warning'>Reject Request</button>
                                </form>
                                <form id='reject_request_form' class='form_to_submit' method='POST' action='{{ url('rejectedrequest/reject/'.$request->id) }}'>                                    
                                    @csrf
                                    <input id='reject_request_reason' type='hidden' name='reason' value=''>                                                                  
                                </form>                                     
                            @endif
                        @elseif ($request->status_id == 1)                            
                            @if (Auth::user()->admin == 1)
                                @if($request->assigned_to == '')
                                    <button type='button' id='assign_request' class='btn btn-secondary'>Assign Request</button>
                                @else
                                    @if($request->start_at == null)
                                        <button type='button' id='assign_request' class='btn btn-secondary'>Reassign Request </button>
                                    @endif
                                    <span class='font-weight-bold' style='font-size:1rem'>Assigned to {{ $request->assign->name }}</span> 
                                @endif                                     
                            @endif
                            <span class='font-weight-bold' id='assign_label' style='font-size:1rem'></span> 
                            <form class='form_to_submit' method='POST' action='/1_atms/public/cctvreview/{{ $request->id }}'>
                                @method('PUT')
                                @csrf
                                <input type='hidden' name='status_id' value='2'>
                                <input type='hidden' name='mod' value='assign'>
                                <input type='hidden' name='assigner' value='{{ Auth::user()->name }}'>
                                <input type='hidden' name='url' value='/it/htv/{{ $request->id }}'>
                                <input type='hidden' name='request_id' value='{{ $request->id }}'>
                                <div class='input-group' id='req_assigned_to' style='display:none'>
                                    <select type="text" class="form-control" id="assigned_to" name="assigned_to" placeholder="" required>
                                        <option value="">- Select Tech -</option>                            
                                        @foreach($techs as $tech)
                                            {{-- @if($user->id != $tickets->user_id)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endif --}}
                                            <option value="{{$tech->id}}">{{$tech->name}}</option>
                                        @endforeach
                                    </select>
                                    <button type='submit' class='btn btn-secondary form_submit_button'>Assign</button>
                                    <button type='button' id='req_cancel_assign' class='btn btn-warning'>Cancel</button>
                                </div>                                                                          
                            </form>
                        @elseif ($request->status_id == 2)
                            @if($request->assigned_to == Auth::user()->id)
                                <form class='form_to_submit' method='POST' action='/1_atms/public/cctvreview/{{ $request->id }}'>
                                    @method('PUT')
                                    @csrf
                                    <input type='hidden' name='status_id' value='3'>
                                    <input type='hidden' name='mod' value='accept'>
                                    <input id='datenow' type='hidden' name='start_at' value="{{ Date('Y-m-d H:i:s') }}">
                                    <input type='hidden' name='url' value='/it/vt/{{ $request->id }}'>
                                    <button type='submit' id='accept_ticket' class='btn btn-secondary form_submit_button'>Accept Ticket</button>
                                </form>
                            @else
                                <span class='font-weight-bold' style='font-size:1rem'>Assigned to {{ $request->assign->name }}</span>
                            @endif
                        @else
                            @if($request->assigned_to != null)                         
                                @if($request->assigned_to == Auth::user()->id)
                                    <form class='form_to_submit' method='POST' action='/1_atms/public/cctvreview/{{ $request->id }}'>
                                            @method('PUT')
                                            @csrf
                                        <div class='input-group' id='req_change_priority' style='display:none'>
                                            <select type="text" class="form-control" name="priority_id" placeholder="" required >
                                                <option value="">- Select Priority -</option>
                                                @foreach($priorities as $priority)
                                                    @if($priority->id != $request->priority_id)
                                                        <option value="{{$priority->id}}">{{$priority->name}}</option>
                                                    @endif                                                    
                                                @endforeach
                                            </select>
                                            <input type='hidden' name='mod' value='priority'>
                                            <input type='hidden' name='url' value='/it/vt/{{ $request->id }}'>
                                            <button type='submit' class='btn btn-secondary form_submit_button'>Change</button>
                                            <button type='button' id='req_cancel_change_priority' class='btn btn-warning'>Cancel</button>
                                        </div>
                                    </form>
                                    <form class='form_to_submit' id='req_change_status_form' method='POST' action='/1_atms/public/cctvreview/{{ $request->id }}'>
                                            @method('PUT')
                                            @csrf
                                        <div class='input-group' id='req_change_status' style='display:none'>
                                            <select type="text" class="form-control" id='req_change_status_id' name="status_id" placeholder="" required>
                                                <option value="">- Select Status -</option>
                                                @foreach($statuses as $status)
                                                    @if(!($status->id == $request->status_id || $status->id == 1 || $status->id == 2 || $status->id == 6 || $status->id == 7 ))                                                        
                                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                                    @endif                                                    
                                                @endforeach
                                            </select>                                            
                                            <input type='hidden' name='mod' value='escalate'>
                                            <input type='hidden' name='url' value='/it/vt/{{ $request->id }}'>
                                            <button type='submit' class='btn btn-secondary form_submit_button'>Change</button>
                                            <button type='button' id='req_cancel_change_status' class='btn btn-warning'>Cancel</button>
                                        </div>
                                    </form>
                                    <div id='req_change_buttons'>
                                        <button type='button' id='req_change_priority_button' class='btn btn-secondary'>Change Priority</button>
                                        <button type='button' id='req_change_status_button' class='btn btn-secondary'>Change Status</button>
                                        <button type='button' id='add_review_details' class='btn btn-secondary'>Request Details</button>
                                        {{-- <button type='button' id='add_ticket_details' class='btn btn-secondary'>Ticket Details</button>
                                        <form class='form_to_submit' id='close_ticket_form' method='POST' action='/1_atms/public/closed_ticket/transfer/{{ $request->id }}'>
                                            @csrf
                                            <input type='hidden' name='status_id' value='{{ $request->status_id }}'>
                                            <input type='hidden' name='mod' value='default'>
                                            <input type='hidden' name='url' value='/it/ctlv/{{ $request->id }}'>            
                                            <button type='button' id='close_ticket' class='btn btn-danger mt-2' style='display:inline;'>Close Ticket</button>
                                        </form> --}}
                                    </div>
                                @else
                                    <span class='font-weight-bold' style='font-size:1rem'>Assigned to {{ $request->assign->name }}</span>
                                @endif                           
                            @endif
                        @endif

                        {{-- @if($request->status_id == 1)
                            <button type='button' id='assign_request' class='btn btn-secondary'>Assign Request</button>
                            @if($request->assigned_to == '')
                                <button type='button' id='assign_request' class='btn btn-secondary'>Assign Request</button>
                            @else
                                @if($request->status_id == 2)
                                    <button type='button' id='assign_request' class='btn btn-secondary'>Reassign Request </button>
                                @endif
                                    <span class='font-weight-bold' style='font-size:1rem'>Assigned to {{ $request->assign->name }}</span> 
                            @endif
                            <span class='font-weight-bold' id='assign_label' style='font-size:1rem'></span> 
                            <form class='form_to_submit' method='POST' action='/1_atms/public/cctvreview/{{ $request->id }}'>
                                @method('PUT')
                                @csrf
                                <input type='hidden' name='status_id' value='2'>
                                <input type='hidden' name='mod' value='assign'>
                                <input type='hidden' name='assigner' value='{{ Auth::user()->name }}'>
                                <input type='hidden' name='url' value='/it/htv/{{ $request->id }}'>
                                <input type='hidden' name='request_id' value='{{ $request->id }}'>
                                <div class='input-group' id='req_assigned_to' style='display:none'>
                                    <select type="text" class="form-control" id="assigned_to" name="assigned_to" placeholder="" required>
                                        <option value="">- Select Tech -</option>                            
                                        @foreach($techs as $tech)                                            
                                            <option value="{{$tech->id}}">{{$tech->name}}</option>
                                        @endforeach
                                    </select>
                                    <button type='submit' class='btn btn-secondary form_submit_button'>Assign</button>
                                    <button type='button' id='req_cancel_assign' class='btn btn-warning'>Cancel</button>
                                </div>                                                                          
                            </form>
                        @elseif($request->status_id == 2)                        
                            @if($request->assigned_to == Auth::user()->id)
                                <form class='form_to_submit' method='POST' action='/1_atms/public/cctvreview/{{ $request->id }}'>
                                    @method('PUT')
                                    @csrf
                                    <input type='hidden' name='status_id' value='3'>
                                    <input type='hidden' name='mod' value='accept'>
                                    <input id='datenow' type='hidden' name='start_at' value="{{ Date('Y-m-d H:i:s') }}">
                                    <input type='hidden' name='url' value='/it/vt/{{ $request->id }}'>
                                    <button type='submit' id='accept_ticket' class='btn btn-secondary form_submit_button'>Accept Ticket</button>
                                </form>
                            @else
                                <span class='font-weight-bold' style='font-size:1rem'>Assigned to {{ $request->assign->name }}</span>
                            @endif
                        @elseif(!($request->status_id == 1 || $request->status_id == 2))
                            @if($request->assigned_to != null)                         
                                @if($request->assigned_to == Auth::user()->id)
                                    <form class='form_to_submit' method='POST' action='/1_atms/public/cctvreview/{{ $request->id }}'>
                                            @method('PUT')
                                            @csrf
                                        <div class='input-group' id='req_change_priority' style='display:none'>
                                            <select type="text" class="form-control" name="priority_id" placeholder="" required >
                                                <option value="">- Select Priority -</option>
                                                @foreach($priorities as $priority)
                                                    @if($priority->id != $request->priority_id)
                                                        <option value="{{$priority->id}}">{{$priority->name}}</option>
                                                    @endif                                                    
                                                @endforeach
                                            </select>
                                            <input type='hidden' name='mod' value='priority'>
                                            <input type='hidden' name='url' value='/it/vt/{{ $request->id }}'>
                                            <button type='submit' class='btn btn-secondary form_submit_button'>Change</button>
                                            <button type='button' id='req_cancel_change_priority' class='btn btn-warning'>Cancel</button>
                                        </div>
                                    </form>
                                    <form class='form_to_submit' id='req_change_status_form' method='POST' action='/1_atms/public/cctvreview/{{ $request->id }}'>
                                            @method('PUT')
                                            @csrf
                                        <div class='input-group' id='req_change_status' style='display:none'>
                                            <select type="text" class="form-control" id='req_change_status_id' name="status_id" placeholder="" required>
                                                <option value="">- Select Status -</option>
                                                @foreach($statuses as $status)
                                                    @if(!($status->id == $request->status_id || $status->id == 1 || $status->id == 2 || $status->id == 6))                                                        
                                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                                    @endif                                                    
                                                @endforeach
                                            </select>                                            
                                            <input type='hidden' name='mod' value='escalate'>
                                            <input type='hidden' name='url' value='/it/vt/{{ $request->id }}'>
                                            <button type='submit' class='btn btn-secondary form_submit_button'>Change</button>
                                            <button type='button' id='req_cancel_change_status' class='btn btn-warning'>Cancel</button>
                                        </div>
                                    </form>
                                    <div id='req_change_buttons'>
                                        <button type='button' id='req_change_priority_button' class='btn btn-secondary'>Change Priority</button>
                                        <button type='button' id='req_change_status_button' class='btn btn-secondary'>Change Status</button>
                                        <button type='button' id='add_review_details' class='btn btn-secondary'>Request Details</button>                                        
                                    </div>
                                @else
                                    <span class='font-weight-bold' style='font-size:1rem'>Assigned to {{ $request->assign->name }}</span>
                                @endif                           
                            @endif
                        @endif --}}                                                                                                         
                    </div>
                    <div class='col-md-7'>
                        @if($request->attach != null)
                            <a class='btn btn-secondary' id='c_attach' href="{{ url('/cr/crda/'.$request->id) }}" >See Attachments</a>
                            @if(Auth::user()->id == $request->assigned_to)
                            <button id='addimagebtn' class='btn btn-secondary'>Add Images</button>
                            <div id='addimageinput' style='display:none'>
                                <form id='addimageform' class='form_to_submit' method='POST' action='{{ url('/cctvreview/addimage/'.$request->id) }}' enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <input id='inputaddimage' class='border border-secondary rounded form-control-sm py-1' type='file' name='attach[]' multiple>
                                    <button type='submit' class="btn btn-primary form_submit_button" id="saveTicketButton"><i class="fa fa-share-square"></i> Upload</button>
                                    <button type='button' class='btn btn-warning' id='canceladdimagebtn'>Cancel</button>
                                </form>
                            </div>
                            @endif
                        @else
                            @if(Auth::user()->id == $request->assigned_to && !($request->status_id == 1 || $request->status_id == 2))
                                <div class='row'>                                    
                                    <div class="col-md text-left">
                                        {{-- <span>Attach Image/ScreenShot: </span> --}}
                                        <button id='uploadbtn' class='btn btn-secondary'>Upload Images</button>
                                        <div id='uploadinput' style='display:none'>
                                            <form id='uploadform' class='form_to_submit' method='POST' action='{{ url('/cctvreview/'.$request->id) }}' enctype="multipart/form-data">
                                                @method('PUT')
                                                @csrf
                                                <input id='inputupload' class='border border-secondary rounded form-control-sm py-1' type='file' name='attach[]' multiple>
                                                <button type='submit' class="btn btn-primary form_submit_button" id="saveTicketButton"><i class="fa fa-share-square"></i> Upload</button>
                                                <button type='button' class='btn btn-warning' id='canceluploadbtn'>Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>                                
                            @else
                                <span class='text-muted font-weight-bold'>No attachment.</span>
                            @endif                            
                        @endif 
                    </div>                                           
                </div>
                <div class='row mb-2'>
                    <div class='col-md'>
                        @if($request->user_id == Auth::user()->id)
                            <button type='button' id='edit_request' class='btn btn-secondary'>Edit Request</button>
                            <button type='button' id='cancel_request' class='btn btn-danger' style='display:inline;'>Cancel Request</button>
                            <div id='edit_request_buttons' style='display:none'>
                                <form class='form_to_submit' id='saveEditRequest' method='POST' action='{{ url('/cctvreview/'.$request->id) }}'>
                                    @method('PUT')
                                    @csrf
                                    <input type='hidden' id='editDepartment' name='department_id' value=''>
                                    <input type='hidden' id='editSubject' name='subject' value=''>
                                    <input type='hidden' id='editMessage' name='message' value=''>
                                    <input type='hidden' id='editStart' name='start_time' value=''>
                                    <input type='hidden' id='editEnd' name='end_time' value=''>
                                    <input type='hidden' id='editLocation' name='location' value=''>
                                    <input type='hidden' id='' name='mod' value='editTicket'>
                                    <div class='input-group'>
                                        <button type='submit' class='btn btn-primary form_submit_button'>Save Request</button>
                                        <button type='button' id='cancel_edit_request' class='btn btn-warning'>Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <form class='form_to_submit' id='cancel_request_form' method='POST' action='{{ url('/cctvreview/'.$request->id) }}'>
                                @method('DELETE')
                                @csrf                                           
                                
                            </form>                        
                        @endif
                    </div>                    
                </div>
                <hr>                          
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>SUBJECT:</span></label>      
                    </div>
                    <div class="col-md" style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>
                        <span class='editrequestlabel'>{{ $request->subject }}</span>                        
                        <textarea id='subjectNew' name='subject' class='form-control editrequestinput' style='display:none; width:100%'>{{ $request->subject }}</textarea>
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>DESCRIPTION:</span></label>
                    </div>
                    <div class="col-md-10" id='editmessagecol' style='max-height: 30vh; overflow:hidden; overflow-y: scroll'>
                        <span class='editrequestlabel'>{!! $request->message !!}</span>
                        <textarea type="text" class="form-control editrequestinput" rows="8" id="messageNew" name="message" placeholder="" style='display:none; width:100%'>{!! $request->message !!}</textarea>
                    </div>
                </div>
            <form class='form_to_submit' method='POST' action='{{ url('/cctvreview/'.$request->id) }}'>
                @method('PUT')
                @csrf
                <input type='hidden' name='mod' value='detail'>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>ROOT CAUSE:</span></label>      
                    </div>                    
                    <div class="col-md " style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>
                        <textarea name='root' class='review_details_edit' style='display:none; width:100%'>{{ $request->root }}</textarea>
                        <p class='review_details_display'>{{ $request->root }}</p>       
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>ACTION:</span></label>      
                    </div>                    
                    <div class="col-md" style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>
                        <textarea name='action' class='review_details_edit' style='display:none; width:100%'>{{ $request->action }}</textarea>
                        <p class='review_details_display'>{{ $request->action }}</p>       
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>RESULT:</span></label>      
                    </div>                    
                    <div class="col-md" style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>
                        <textarea name='result' class='review_details_edit' style='display:none; width:100%'>{{ $request->result }}</textarea>
                        <p class='review_details_display'>{{ $request->result }}</p>       
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>RECOMMENDATION:</span></label>      
                    </div>                    
                    <div class="col-md" style='max-height: 20vh; overflow:hidden; overflow-y: scroll'>
                        <textarea name='recommend' class='mb-2 review_details_edit' style='display:none; width:100%'>{{ $request->recommend }}</textarea>                        
                        <p class='review_details_display'>{{ $request->recommend }}</p>       
                    </div>                    
                </div>
                <div class='col-md review_details_edit text-right' style='display:none;'>
                    <button type='submit' id='' class='btn btn-secondary form_submit_button' >Save</button>
                    <button type='button' id='cancel_request_details' class='btn btn-warning'>Cancel</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@else
    <div class='alert alert-danger'><h5>Request not found, not existed or already cancelled/rejected.</h5></div>
@endif