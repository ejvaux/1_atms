<div class="container">
        <div class='row mb-2'>
            <div class='col-md'>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" id="bc_adminviewticket">Tickets</a></li>
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
                                                Waiting for Queue
                                            @else
    
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
                            <div class='col-md'>
                                <button type='' class='btn btn-secondary'>Assign Ticket</button>
                            </div>
                        </div>
                        <hr>                    
                        <div class="row mb-2">
                            <div class="col-md-1">
                                <label class='font-weight-bold'><span class='text-muted'>SUBJECT:</span></label>      
                            </div>
                            <div class="col-md">
                                <label>{{ $tickets->subject }}</label>       
                            </div>  
                        </div>
                        <div class="row mb-1">
                            <div class="col-md">
                                <label class='font-weight-bold'><span class='text-muted'>DESCRIPTION:</span></label>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                {!! $tickets->message !!}
                                {{-- <textarea rows="5" style="width:100%" readonly>{{ $tickets->message }}</textarea> --}}
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