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
                                    <div class='row'>
                                        <div class='col-md'>
                                            <label class='font-weight-bold'>{{ $tickets->finish_at }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        <div class='col-md'></div>
                        <div class='col-md-6'>                        
                            @if($tickets->attach != null)
                                <a class='btn btn-secondary' id='c_attach' href="{{ url('/it/tda/'.$tickets->id) }}" >See Attachments</a>                           
                            @else                            
                                <span class='text-muted font-weight-bold'>No attachment.</span>                                                       
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
</form>
@else
    <div class='alert alert-danger'><h3>Ticket not found or it doesn't exists.</h3></div>
@endif