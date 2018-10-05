@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container">    
    <div class='row mb-2'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::previous() }}">Tickets</a></li>
                    <li class="breadcrumb-item">Details</li>
                </ol>
            </nav>
        </div>
    </div>
    @include('inc.viewticket');
    {{-- @if(count($tickets)>0)
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
                                    <h4 class="font-weight-bold" id='timelapse_label'>
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
                                    <div class='row'>
                                        <div class='col-md'>
                                            <label class='font-weight-bold'><span class='text-muted'>Finish At:</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-9'>                                    
                                    <div class='row'>
                                        <div class='col-md'>
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
                                        <div class='col-md'>
                                            <label class='font-weight-bold editticketlabel '>{{ $tickets->category->name }}</label>
                                            <input type='hidden' id='categoryNewSelected' value='{{ $tickets->category_id }}'>
                                            <select type="text" class="form-control-sm editticketinput border" id="categoryNew" name="category_id" style='display:none'  required>
                                                <option value="">- Select Category -</option>                            
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md'>
                                            <label class='font-weight-bold' id='start_label'>{{ $tickets->start_at }}</label>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md'>
                                            <label class='font-weight-bold' id='start_label'>{{ $tickets->finish_at }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>                        
                    <div class='row mb-2'>
                        <div class='col-md-6'>
                            @if($tickets->assigned_to == '')
                                <button type='button' id='assign_ticket' class='btn btn-secondary'>Assign Ticket</button>
                                <button type='button' id='decline_ticket' class='btn btn-warning' style='display:inline;'>Decline Ticket</button>
                                <form class='form_to_submit' id='decline_ticket_form' method='POST' action='/1_atms/public/declined_ticket/transfer/{{ $tickets->id }}'>
                                    @csrf
                                    <input type='hidden' name='status_id' value='{{ $tickets->status_id }}'>
                                    <input type='hidden' name='mod' value='default'>
                                    <input type='hidden' name='url' value='/it/ctlv/{{ $tickets->id }}'>                                    
                                </form>
                            @else
                                @if($tickets->status_id == 2)
                                    <button type='button' id='assign_ticket' class='btn btn-secondary'>Reassign Ticket </button>
                                @elseif($tickets->status_id == 5)
                                    <form class='form_to_submit' id='close_ticket_form' method='POST' action='/1_atms/public/closed_ticket/transfer/{{ $tickets->id }}'>
                                        @csrf
                                        <input type='hidden' name='status_id' value='{{ $tickets->status_id }}'>
                                        <input type='hidden' name='mod' value='default'>
                                        <input type='hidden' name='url' value='/it/ctlv/{{ $tickets->id }}'>            
                                        <button type='button' id='close_ticket' class='btn btn-danger mt-2' style='display:inline;'>Close Ticket</button>
                                    </form>
                                @endif
                                <span class='font-weight-bold' style='font-size:1rem'>Assigned to {{ $tickets->assign->name }}</span> 
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
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    <button type='submit' class='btn btn-secondary form_submit_button'>Assign</button>
                                    <button type='button' id='cancel_assign' class='btn btn-warning'>Cancel</button>
                                </div>                                                                          
                            </form>                                                                                                               
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
                                <button type='button' id='cancel_ticket' class='btn btn-danger' style='display:inline;'>Cancel Ticket</button>
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
                            <span class='editticketlabel'>{{ $tickets->subject }}</span>                        
                            <textarea id='subjectNew' name='subject' class='form-control editticketinput' style='display:none; width:100%'>{{ $tickets->subject }}</textarea>    
                        </div>  
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-2">
                            <label class='font-weight-bold'><span class='text-muted'>DESCRIPTION:</span></label>
                        </div>
                        <div class="col-md-10" style='max-height: 40vh; overflow:hidden; overflow-y: scroll'>
                            <span class='editticketlabel'>{!! $tickets->message !!}</span>
                            <textarea type="text" class="form-control editticketinput" rows="8" id="messageNew" name="message" placeholder="" style='display:none; width:100%'>{!! $tickets->message !!}</textarea>
                        </div>
                    </div>                    
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <label class='font-weight-bold'><span class='text-muted'>ROOT CAUSE:</span></label>      
                        </div>                    
                        <div class="col-md " style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>                            
                            <p class='details_display'>{{ $tickets->root }}</p>       
                        </div>  
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <label class='font-weight-bold'><span class='text-muted'>ACTION:</span></label>      
                        </div>                    
                        <div class="col-md" style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>                           
                            <p class='details_display'>{{ $tickets->action }}</p>       
                        </div>  
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <label class='font-weight-bold'><span class='text-muted'>RESULT:</span></label>      
                        </div>                    
                        <div class="col-md" style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>                            
                            <p class='details_display'>{{ $tickets->result }}</p>       
                        </div>  
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <label class='font-weight-bold'><span class='text-muted'>RECOMMENDATION:</span></label>      
                        </div>                    
                        <div class="col-md" style='max-height: 20vh; overflow:hidden; overflow-y: scroll'>                            
                            <p class='details_display'>{{ $tickets->recommend }}</p>       
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div class="row mb-0">
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
                    <div class="px-3" id='update_div' style="width:100%; height:300px; overflow-y: auto;">{!!$updatetext!!}</div>
                </div>
            </div>
        </div>  
    </div>  
    <form class='form_to_submit' id='adminupdateform' method="POST" action="/1_atms/public/ticket_updates">
    @csrf
    <input type="hidden" id='admin_update_ticket_id' name="ticket_id" value="{{ $tickets->id }}">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">    
    </form>
    @else
        <div class='alert alert-danger'><h3>Ticket not found or, Already cancelled or closed.</h3></div>
    @endif --}}
</div>
@endsection