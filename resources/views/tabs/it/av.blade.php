@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container">
    <div class='row mb-2'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/1_atms/public/it/al">Tickets</a></li>
                    <li class="breadcrumb-item">Details</li>
                    {{-- <li class="breadcrumb-item">Data</li> --}}
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-2">
        <div class='col-md'>
            <div class="card" style='width:100%'>
                <h4 class="card-header font-weight-bold">#{{ $tickets->id }}</h4>
                <div class="card-body">
                    {{-- <div class='row mb-2'>
                        <div class='col-md'>
                            <ol class="breadcrumb bread">
                                <li class="breadcrumb-item">NEW</li>
                                <li class="breadcrumb-item">QUEUED</li>
                                <li class="breadcrumb-item">IN PROGRESS</li>
                                <li class="breadcrumb-item">PENDING</li>
                                <li class="breadcrumb-item">RESOLVED</li>
                                <li class="breadcrumb-item">CLOSED</li>
                            </ol>
                        </div>
                    </div> --}}
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
                                            {!! CustomFunctions::datetimelapse($tickets->start_at) !!}
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
                                            <label class='font-weight-bold' id='start_label'>{{ $tickets->start_at }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>                        
                    <div class='row mb-2'>
                        <div class='col-md-4'>
                            @if($tickets->assigned_to == '')
                                <button type='button' id='assign_ticket' class='btn btn-secondary'>Assign Ticket </button>
                            @else
                                <span class='font-weight-bold' style='font-size:1rem'>Assigned to {{ $tickets->assign->name }}</span> 
                            @endif
                            <span class='font-weight-bold' id='assign_label' style='font-size:1rem'></span> 
                            <form method='POST' action='/1_atms/public/tickets/{{ $tickets->id }}'>
                                @method('PUT')
                                @csrf
                                <div class='input-group' id='dd_assigned_to' style='display:none'>
                                    <select type="text" class="form-control" id="assigned_to" name="assigned_to" placeholder="" required>
                                        <option value="">- Select Tech -</option>                            
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    <button type='submit' class='btn btn-secondary'>Assign</button>
                                    <button type='button' id='cancel_assign' class='btn btn-warning'>Cancel</button>
                                </div>                                                                          
                            </form>                                                                                    
                        </div>                                                  
                    </div>
                    <hr>                    
                    <div class="row mb-2">
                        <div class="col-md-1">
                            <label class='font-weight-bold'><span class='text-muted'>SUBJECT:</span></label>      
                        </div>
                        <div class="col-md" style='max-height: 15vh; overflow:hidden; overflow-y: scroll'>
                            <p>{{ $tickets->subject }}</p>       
                        </div>  
                    </div>
                    <div class="row mb-1">
                        <div class="col-md">
                            <label class='font-weight-bold'><span class='text-muted'>DESCRIPTION:</span></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" style='max-height: 40vh; overflow:hidden; overflow-y: scroll'>
                            <p>{!! $tickets->message !!}</p>                            
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
                        /* $updatetext .= "<p class='text-muted mb-0 mt-3'>". $update->user->name . " (" . $update->created_at . ")</p><div class='card mt-0 mb-2 p-0' style='width:fit-content; background-color:#D4E6F1;'><div class='card-body p-2'>" . $update->message . '</div></div>'; */                                     
                    @endphp
                    @endforeach
                    <div class="px-3" id='update_div' style="width:100%; height:300px; overflow-y: auto;">{!!$updatetext!!}</div>
                </div>
            </div>
        </div>  
    </div>  
    <form id='adminupdateform' method="POST" action="/1_atms/public/ticket_updates">
    @csrf
    <input type="hidden" id='admin_update_ticket_id' name="ticket_id" value="{{ $tickets->id }}">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <div class="row pt-0 mt-0 mb-4">
        <div class="col-md-12">
            <div class="input-group">
                <input type="text" name="message" class="" id="update_message" placeholder="Enter text here . . ." style="width:90%">
                <button type="submit" id="send_update" style="width:10%">SEND</button>
            </div>
        </div>        
    </div>
    </form>
</div>
@endsection