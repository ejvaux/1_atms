@if(count($tickets)>0)
<div class="row mb-2">
    <div class='col-md'>
        <div class="card" style='width:100%'>
            <h4 class="card-header font-weight-bold">#{{ $tickets->ticket_id }} - {{ $tickets->user->name }}</h4>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <div class="col-md">
                                <h3>{!! CustomFunctions::priority_format($tickets->priority_id) !!} {!! CustomFunctions::status_format($tickets->status_id) !!}</h3>            
                            </div>               
                        </div>
                        <div class="row mb-2">
                            <div class="col-md">
                                <h4 class="font-weight-bold">
                                    @if ($tickets->start_at == null)
                                        @if ($tickets->status_id == 2)
                                            On Queue
                                        @else
                                            Waiting for Queue
                                        @endif                                                
                                    @else
                                        @if($tickets->finish_at == null)
                                            {!! CustomFunctions::datetimelapse($tickets->start_at) !!}
                                        @else
                                            {!! CustomFunctions::datetimefinished($tickets->start_at,$tickets->finish_at) !!}
                                        @endif
                                    @endif                                       
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class='row '>
                            <div class='col-md-3'>                                    
                                <div class='row'>
                                    <div class='col-md '>
                                        <label for='department' class='font-weight-bold'><span class='text-muted'>Department:</span></label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label for='category' class='font-weight-bold'><span class='text-muted'>Category:</span></label>
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
                                        <label class='font-weight-bold editticketlabel '>{{ $tickets->department->name }}</label>
                                        <input type='hidden' id='departmentNewSelected' value='{{ $tickets->department_id }}'>
                                        <select type="text" class="form-control-sm editticketinput border" id="departmentNew" name="department_id" style='display:none' required>
                                            <option value="">- Select Department -</option>
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}">{{$department->name}}</option>
                                            @endforeach
                                        </select>                                      
                                    </div>                                    
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label class='font-weight-bold editticketlabel '>{{ $tickets->category->name }}</label>
                                        <input type='hidden' id='categoryNewSelected' value='{{ $tickets->category_id }}'>
                                        <select type="text" class="form-control-sm editticketinput border" id="categoryNew" name="category_id" style='display:none' required>
                                            <option value="">- Select Category -</option>                            
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>                                       
                                    </div>                                    
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label class='font-weight-bold '>{{ $tickets->start_at }}</label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label class='font-weight-bold '>{{ $tickets->finish_at }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>                                                                                
                    </div>
                </div>
                <div class='row mb-2'>
                    <div class='col-md-6'>
                        {{-- assigning --}}
                        @if(Auth::user()->admin == true)
                        @if($tickets->assigned_to == '')
                            <button type='button' id='assign_ticket' class='btn btn-secondary assign_grp'>Assign Ticket</button>
                            <button type='button' id='decline_ticket' class='btn btn-warning assign_grp' style='display:inline;'>Decline Ticket</button>
                            <form class='form_to_submit' id='decline_ticket_form' method='POST' action='/1_atms/public/declined_ticket/transfer/{{ $tickets->id }}'>
                                @csrf
                                <input type='hidden' name='status_id' value='{{ $tickets->status_id }}'>
                                <input type='hidden' name='mod' value='default'>
                                <input type='hidden' name='url' value='/it/ctlv/{{ $tickets->id }}'>                                    
                            </form>
                        @else
                        <span class='font-weight-bold assign_grp' style='font-size:1rem'>Assigned to {{ $tickets->assign->name }}</span><br>
                            @if($tickets->status_id == 2)
                                <button type='button' id='assign_ticket' class='btn btn-secondary assign_grp'>Reassign Ticket</button>
                                <button type='button' id='edit_instruction' class='btn btn-secondary assign_grp'>Edit Instructions</button>
                            @elseif($tickets->status_id == 5)
                                <form class='form_to_submit' id='close_ticket_form' method='POST' action='/1_atms/public/closed_ticket/transfer/{{ $tickets->id }}'>
                                    @csrf
                                    <input type='hidden' name='status_id' value='{{ $tickets->status_id }}'>
                                    <input type='hidden' name='mod' value='default'>
                                    <input type='hidden' name='url' value='/it/ctlv/{{ $tickets->id }}'>            
                                    <button type='button' id='close_ticket' class='btn btn-danger mt-2' style='display:inline;'>Close Ticket</button>
                                </form>
                            @endif                            
                        @endif
                        <span class='font-weight-bold' id='assign_label' style='font-size:1rem'></span> 
                        <form class='form_to_submit' method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
                            @method('PUT')
                            @csrf
                            <input type='hidden' name='status_id' value='2'>
                            <input type='hidden' name='mod' value='assign'>
                            <input type='hidden' name='assigner' value='{{ Auth::user()->name }}'>
                            <input type='hidden' name='url' value='/it/htv/{{ $tickets->id }}'>
                            <input type='hidden' name='ticket_id' value='{{ $tickets->id }}'>
                            <div class='input-group' id='dd_assigned_to' style='display:none'>
                                <select type="text" class="form-control" id="assigned_to" name="assigned_to" placeholder="" required>
                                    <option value="">- Select Tech -</option>                            
                                    @foreach($users as $user)
                                        {{-- @if($user->id != $tickets->user_id)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endif --}}
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                <button type='submit' class='btn btn-secondary form_submit_button'>Assign</button>
                                <button type='button' id='cancel_assign' class='btn btn-warning'>Cancel</button>
                                <textarea id='instNew' name='instruction' class='form-control ' style='width:100%' placeholder="Insert instructions here. . . . .">{{$tickets->instruction}}</textarea>
                            </div>                                                                          
                        </form>
                        @endif
                        {{-- old --}}
                        @if($tickets->status_id == 2)                        
                            @if($tickets->assigned_to == Auth::user()->id)
                                <form class='form_to_submit' method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
                                    @method('PUT')
                                    @csrf
                                    <input type='hidden' name='status_id' value='3'>
                                    <input type='hidden' name='mod' value='accept'>
                                    <input id='datenow' type='hidden' name='start_at' value="{{ Date('Y-m-d H:i:s') }}">
                                    <input type='hidden' name='url' value='/it/vt/{{ $tickets->id }}'>
                                    <button type='submit' id='accept_ticket' class='btn btn-secondary form_submit_button'>Accept Ticket</button>
                                </form>
                            @else
                                {{-- <span class='font-weight-bold' style='font-size:1rem'>Assigned to {{ $tickets->assign->name }}</span> --}}
                            @endif
                        @elseif(!($tickets->status_id == 1 || $tickets->status_id == 2))
                            @if($tickets->assigned_to != null)                         
                                @if($tickets->assigned_to == Auth::user()->id)
                                    <form class='form_to_submit' method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
                                            @method('PUT')
                                            @csrf
                                        <div class='input-group' id='change_priority' style='display:none'>
                                            <select type="text" class="form-control" name="priority_id" placeholder="" required >
                                                <option value="">- Select Priority -</option>
                                                @foreach($priorities as $priority)
                                                    @if($priority->id != $tickets->priority_id)
                                                        <option value="{{$priority->id}}">{{$priority->name}}</option>
                                                    @endif                                                    
                                                @endforeach
                                            </select>
                                            <input type='hidden' name='mod' value='priority'>
                                            <input type='hidden' name='url' value='/it/vt/{{ $tickets->id }}'>
                                            <button type='submit' class='btn btn-secondary form_submit_button'>Change</button>
                                            <button type='button' id='cancel_change_priority' class='btn btn-warning'>Cancel</button>
                                        </div>
                                    </form>
                                    <form class='form_to_submit' id='change_status_form' method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
                                            @method('PUT')
                                            @csrf
                                        <div class='input-group' id='change_status' style='display:none'>
                                            <select type="text" class="form-control" id='change_status_id' name="status_id" placeholder="" required>
                                                <option value="">- Select Status -</option>
                                                @foreach($statuses as $status)
                                                    @if(!($status->id == $tickets->status_id || $status->id == 1 || $status->id == 2 || $status->id == 6))                                                        
                                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                                    @endif                                                    
                                                @endforeach
                                            </select>
                                            <input type='hidden' name='mod' value='escalate'>
                                            <input type='hidden' name='url' value='/it/vt/{{ $tickets->id }}'>
                                            <button type='submit' class='btn btn-secondary form_submit_button'>Change</button>
                                            <button type='button' id='cancel_change_status' class='btn btn-warning'>Cancel</button>
                                        </div>
                                    </form>
                                    <div id='change_buttons'>
                                        <button type='button' id='change_priority_button' class='btn btn-secondary'>Change Priority</button>
                                        <button type='button' id='change_status_button' class='btn btn-secondary'>Change Status</button>
                                        <button type='button' id='add_ticket_details' class='btn btn-secondary'>Ticket Details</button>
                                        <form class='form_to_submit' id='close_ticket_form' method='POST' action='/1_atms/public/closed_ticket/transfer/{{ $tickets->id }}'>
                                            @csrf
                                            <input type='hidden' name='status_id' value='{{ $tickets->status_id }}'>
                                            <input type='hidden' name='mod' value='default'>
                                            <input type='hidden' name='url' value='/it/ctlv/{{ $tickets->id }}'>            
                                            <button type='button' id='close_ticket' class='btn btn-danger mt-2' style='display:inline;'>Close Ticket</button>
                                        </form>
                                    </div>
                                @else
                                    <span class='font-weight-bold' style='font-size:1rem'>Assigned to {{ $tickets->assign->name }}</span>
                                @endif
                            @endif
                        @endif                                                                                                         
                    </div>
                    <div class='col-md'>
                        @if($tickets->attach != null)
                            <a class='btn btn-secondary' href="/1_atms/public/storage/attachedfile/{{$tickets->attach}}" onclick="window.open(this.href,'_blank');return false;">See Attachments</a>
                        @else
                            No attachment.
                        @endif 
                    </div>                                               
                </div>
                <div class='row mb-2'>
                    <div class='col-md'>
                        @if($tickets->user_id == Auth::user()->id)
                            <button type='button' id='edit_ticket' class='btn btn-secondary'>Edit Ticket</button>
                            <button type='button' id='cancel_ticket' class='btn btn-danger'>Cancel Ticket</button>
                            <div id='edit_ticket_buttons' style='display:none'>
                                <form class='form_to_submit' id='saveEditTicket' method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
                                    @method('PUT')
                                    @csrf
                                    <input type='hidden' id='editDepartment' name='department_id' value=''>
                                    <input type='hidden' id='editCategory' name='category_id' value=''>
                                    <input type='hidden' id='editSubject' name='subject' value=''>
                                    <input type='hidden' id='editMessage' name='message' value=''>
                                    <input type='hidden' id='' name='mod' value='editTicket'>
                                    <div class='input-group'>
                                        <button type='submit' class='btn btn-secondary form_submit_button'>Save</button>
                                        <button type='button' id='cancel_edit_ticket' class='btn btn-warning'>Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <form class='form_to_submit' id='cancel_ticket_form' method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
                                @method('DELETE')
                                @csrf
                                {{-- <input type='hidden' name='status_id' value='{{ $tickets->status_id }}'>
                                <input type='hidden' name='mod' value='default'>
                                <input type='hidden' name='url' value='/it/ctlv/{{ $tickets->id }}'> --}}            
                                {{-- <button type='button' id='cancel_ticket' class='btn btn-danger mt-2' style='display:inline;'>Cancel Ticket</button> --}}
                            </form>
                        @endif
                    </div>
                </div>
                <hr>
                @if($tickets->status_id == 2)
                    @if(Auth::user()->admin == true or $tickets->assigned_to == Auth::user()->id)
                        <div class="row mb-2">
                            <div class="col-md-2">
                                <label class='font-weight-bold'><span class='text-muted'>INSTRUCTION:</span></label>      
                            </div>
                            <div class="col-md" style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>
                                <span class='editinstlabel'>{{ $tickets->instruction }}</span>
                                <form class='form_to_submit' id='edit_instruction_form' method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>                        
                                    @method('PUT')
                                    @csrf
                                    <input type='hidden' name='mod' value='instruct'>
                                    <div class='editinstinput' style='display:none'>
                                        <textarea id='instNew' name='instruction' class='form-control ' style='width:100%'>{{ $tickets->instruction }}</textarea>
                                        <div class='input-group'>
                                            <button type='submit' class='btn btn-secondary form_submit_button '>Save</button>
                                            <button type='button' id='cancel_editinst' class='btn btn-warning '>Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>  
                        </div>
                    @endif
                @endif                      
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>SUBJECT:</span></label>      
                    </div>
                    <div class="col-md" style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>
                        <span class='editticketlabel'>{{ $tickets->subject }}</span>                        
                        <textarea id='subjectNew' name='subject' class='form-control editticketinput' style='display:none; width:100%'>{{ $tickets->subject }}</textarea>
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>DESCRIPTION:</span></label>
                    </div>
                    <div class="col-md-10" id='editmessagecol' style='max-height: 30vh; overflow:hidden; overflow-y: scroll'>
                        <span class='editticketlabel'>{!! $tickets->message !!}</span>
                        <textarea type="text" class="form-control editticketinput" rows="8" id="messageNew" name="message" placeholder="" style='display:none; width:100%'>{!! $tickets->message !!}</textarea>
                    </div>
                </div>
            <form class='form_to_submit' method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
                @method('PUT')
                @csrf
                <input type='hidden' name='mod' value='detail'>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>ROOT CAUSE:</span></label>      
                    </div>                    
                    <div class="col-md " style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>
                        <textarea name='root' class='details_edit' style='display:none; width:100%'>{{ $tickets->root }}</textarea>
                        <p class='details_display'>{{ $tickets->root }}</p>       
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>ACTION:</span></label>      
                    </div>                    
                    <div class="col-md" style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>
                        <textarea name='action' class='details_edit' style='display:none; width:100%'>{{ $tickets->action }}</textarea>
                        <p class='details_display'>{{ $tickets->action }}</p>       
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>RESULT:</span></label>      
                    </div>                    
                    <div class="col-md" style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>
                        <textarea name='result' class='details_edit' style='display:none; width:100%'>{{ $tickets->result }}</textarea>
                        <p class='details_display'>{{ $tickets->result }}</p>       
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>RECOMMENDATION:</span></label>      
                    </div>                    
                    <div class="col-md" style='max-height: 20vh; overflow:hidden; overflow-y: scroll'>
                        <textarea name='recommend' class='mb-2 details_edit' style='display:none; width:100%'>{{ $tickets->recommend }}</textarea>                        
                        <p class='details_display'>{{ $tickets->recommend }}</p>       
                    </div>                    
                </div>
                <div class='col-md details_edit text-right' style='display:none;'>
                    <button type='submit' id='' class='btn btn-secondary form_submit_button' >Save</button>
                    <button type='button' id='cancel_add_details' class='btn btn-warning'>Cancel</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>    
<div class="row">
    <div class='col-md'>
        <div class="card">
            <h5 class="card-header font-weight-bold">Ticket Updates</h5>
            <div class="card-body">
                @foreach($updates as $update)
                    @php
                        if($update->user_id == Auth::user()->id){
                            $updatetext .= "<p class='text-muted mb-0 mt-3 text-right'>You (" . $update->created_at . ")</p><div class='card mt-0 mb-2 p-0 ml-auto' style='width:fit-content; background-color:#D4E6F1;'><div class='card-body p-2'>" . $update->message . '</div></div>';
                        }
                        else{
                            $updatetext .= "<p class='text-muted mb-0 mt-3'>". $update->user->name . " (" . $update->created_at . ")</p><div class='card mt-0 mb-2 p-0' style='width:fit-content; background-color:#D4E6F1;'><div class='card-body p-2'>" . $update->message . '</div></div>';
                        }
                    @endphp
                @endforeach
                <div class="updatetext px-3" id='update_div' style="width:100%; height:30vh; overflow-y: auto;">{!!$updatetext!!}</div>
            </div>
        </div>
    </div>  
</div>  
<form class='form_to_submit' method="POST" action="/1_atms/public/ticket_updates">
@csrf
<input type="hidden" id='update_ticket_id' name="ticket_id" value="{{ $tickets->id }}">
<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
<input type="hidden" name="mod" value="default">
<div class="row pt-0 mt-0 mb-4">
    <div class="col-md-12">
        <div class="input-group">
            @if($tickets->assigned_to == Auth::user()->id || $tickets->user_id == Auth::user()->id)
                <input type="text" name="message" class="" id="update_message" placeholder="Enter comment here . . ." style="width:90%">           
                <button class='form_submit_button' type="submit" style="width:10%">SEND</button>
            @endif
        </div>
    </div>        
</div>
</form>
@else
    <div class='alert alert-danger'><h3>Ticket not found or, Already cancelled or closed.</h3></div>
@endif