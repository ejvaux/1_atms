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
                                <a class='btn btn-secondary' id='c_attach' href="{{ url('/it/dtda/'.$tickets->id) }}" >See Attachments</a>                           
                            @else                            
                                <span class='text-muted font-weight-bold'>No attachment.</span>                                                       
                            @endif
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <div class='col-md-2'>
                            <label class='font-weight-bold text-muted'>REASON:</label>
                        </div>
                        <div class='col-md'>
                            <p>{{ $tickets->reason }}</p>
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
                </div>
            </div>
        </div>
    </div>         
</form>
@else
    <div class='alert alert-danger'><h3>Ticket not found or it doesn't exists.</h3></div>
@endif