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
                                <div class="card border-secondary" style="width: 12rem;">
                                    <ul class="list-group list-group-flush text-center">
                                        <li class="list-group-item p-1"><h3><span class='badge badge-danger badge-outlined'>REJECTED</span></h3></li>                                            
                                        <li class="list-group-item p-0 font-weight-bold">
                                            @if (!empty($request->approver->name))
                                                {{ $request->approver->name }}
                                            @else
                                                N/A
                                            @endif
                                        </li>                                               
                                        <li class="list-group-item p-0 font-weight-bold">
                                            @if (!empty($request->approved_at))
                                                {{ $request->approved_at }}
                                            @else
                                                No date
                                            @endif                                                    
                                        </li>
                                    </ul>
                                </div>                            
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
                                                                             
                                    </div>                                    
                                </div>
                                <div class='row'>
                                    <div class='col-md '>
                                        <label class='font-weight-bold editrequestlabel'>{{ $request->locationname->name }}</label>
                                        
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md '>                                        
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
                    <div class="col-md-2">
                        <label class='font-weight-bold'><span class='text-muted'>REASON:</span></label>
                    </div>
                    <div class="col-md-10" id='editmessagecol' style='max-height: 30vh; overflow:hidden; overflow-y: scroll'>
                        <span class='editrequestlabel'>{!! $request->reason !!}</span>                        
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