<div class="row mb-2">
    <div class='col-md'>
        <div class="card" style='width:100%'>
            <h4 class="card-header font-weight-bold">#{{ $tickets->id }}</h4>
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
                        <div class='row'>
                            <div class='col-md-3'>                                    
                                <div class='row'>
                                    <div class='col-md'>
                                        <label for='department' class='font-weight-bold'><span class='text-muted'>Department:</span></label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md'>
                                        <label for='category' class='font-weight-bold'><span class='text-muted'>Category:</span></label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md'>
                                        <label class='font-weight-bold'><span class='text-muted'>Start At:</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-9'>                                    
                                <div class='row'>
                                    <div class='col-md'>
                                        <label class='font-weight-bold'>{{ $tickets->department->name }}</label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md'>
                                        <label class='font-weight-bold'>{{ $tickets->category->name }}</label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md'>
                                        <label class='font-weight-bold'>{{ $tickets->start_at }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>                            
                    </div>
                </div>
                <div class='row mb-2'>
                    <div class='col-md-5'>
                        @if($tickets->status_id == 2)                        
                            @if($tickets->assigned_to == Auth::user()->id)
                                <form method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
                                    @method('PUT')
                                    @csrf
                                    <input type='hidden' name='status_id' value='3'>
                                    <input type='hidden' name='mod' value='accept'>
                                    <input id='datenow' type='hidden' name='start_at' value="{{ Date('Y-m-d H:i:s') }}">
                                    <button type='submit' id='accept_ticket' class='btn btn-secondary'>Accept Ticket</button>
                                </form>
                            @else
                                
                            @endif
                        @elseif(!($tickets->status_id == 1 && $tickets->status_id == 2))
                            @if($tickets->assigned_to != null)                         
                                @if($tickets->assigned_to == Auth::user()->id)
                                    <form method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
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
                                            <button type='submit' class='btn btn-secondary'>Change</button>
                                            <button type='button' id='cancel_change_priority' class='btn btn-warning'>Cancel</button>
                                        </div>
                                    </form>
                                    <form id='change_status_form' method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
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
                                            <button type='submit' class='btn btn-secondary'>Change</button>
                                            <button type='button' id='cancel_change_status' class='btn btn-warning'>Cancel</button>
                                        </div>
                                    </form>
                                    <div id='change_buttons'>
                                        <button type='button' id='change_priority_button' class='btn btn-secondary'>Change Priority</button>
                                        <button type='button' id='change_status_button' class='btn btn-secondary'>Change Status</button>
                                        <button type='button' id='add_ticket_details' class='btn btn-secondary'>Ticket Details</button>
                                        <form id='close_ticket_form' method='POST' action='/1_atms/public/closed_ticket/transfer/{{ $tickets->id }}'>
                                            @csrf
                                            <input type='hidden' name='status_id' value='{{ $tickets->status_id }}'>
                                            <input type='hidden' name='mod' value='default'>                     
                                            <button type='button' id='close_ticket' class='btn btn-danger mt-2' style='display:inline;'>Close Ticket</button>
                                        </form>
                                    </div>
                                @else
                                    <span class='font-weight-bold' style='font-size:1rem'>Assigned to {{ $tickets->assign->name }}</span>
                                @endif
                            @endif
                        @endif                                                                                                         
                    </div>                                                  
                </div>
                <hr>                          
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>SUBJECT:</span></label>      
                    </div>
                    <div class="col-md" style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>
                        <p>{{ $tickets->subject }}</p>       
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>DESCRIPTION:</span></label>
                    </div>
                    <div class="col-md-10" style='max-height: 20vh; overflow:hidden; overflow-y: scroll'>
                        <p>{!! $tickets->message !!}</p>
                    </div>
                </div>
            <form method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
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
                    <button type='submit' id='' class='btn btn-secondary' >Save</button>
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
<form method="POST" action="/1_atms/public/ticket_updates">
@csrf
<input type="hidden" id='update_ticket_id' name="ticket_id" value="{{ $tickets->id }}">
<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
<input type="hidden" name="mod" value="default">
<div class="row pt-0 mt-0 mb-4">
    <div class="col-md-12">
        <div class="input-group">
            <input type="text" name="message" class="" id="update_message" placeholder="Enter comment here . . ." style="width:90%">
            <button type="submit" style="width:10%">SEND</button>
        </div>
    </div>        
</div>
</form>