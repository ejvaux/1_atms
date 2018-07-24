@include('inc.messages')
<div class="container" style='display:relative'>
    <div class="row pt-3">
        <div class="col-md-4">
            <form>
                <div class="form-group">
                    <label for="search">Search:</label>
                    <input type="text" class="form-control" id="search" placeholder="Enter ticket number . . .">
                </div>                    
            </form>
        </div>
    </div> 
    <div class='row'>
        <div class='col-md'>
            @if (count($tickets)>1)
                @foreach($tickets as $ticket)
                    <div class='card mb-2'>
                        <div class="card-body row pl-3 pr-0 pb-2 ">                                                     
                            <div class='col-md-10'>
                                <div class='row'>
                                    <div class='col-md'>
                                        <h5 style='overflow:hidden;text-overflow:ellipsis;white-space: nowrap ;'>
                                            <sup>
                                                @switch($ticket->status_id)
                                                    @case(1)
                                                        <span class="badge badge-danger">{{$ticket->status->name}}</span>
                                                        @break
                                                
                                                    @case(2)
                                                        <span class="badge badge-info">{{$ticket->status->name}}</span>
                                                        @break
                
                                                    @case(3)
                                                        <span class="badge badge-primary">{{$ticket->status->name}}</span>
                                                        @break
                
                                                    @case(4)
                                                        <span class="badge badge-warning">{{$ticket->status->name}}</span>
                                                        @break
                
                                                    @case(5)
                                                        <span class="badge badge-success">{{$ticket->status->name}}</span>
                                                        @break
            
                                                    @case(6)
                                                        <span class="badge badge-secondary">{{$ticket->status->name}}</span>
                                                        @break
                                                
                                                    @default
                                                        <span>Something went wrong, please try again</span>
                                                @endswitch
                                            </sup>                                    
                                            <a href='#'><span class='pl-2'>{{$ticket->subject}}</span></a>
                                        </h5>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col'></div>
                                    <div class='col-md-8'>
                                        <span class='text-muted'>Requested by 
                                            @if($ticket->user->name == Auth::user()->name)
                                                You
                                            @else
                                                {{$ticket->user->name}}
                                            @endif
                                             at {{$ticket->created_at}}.</span>
                                    </div>
                                    <div class='col-md-3 ml-auto'>
                                        <span class="badge badge-light" style="font-size:13px">{{$ticket->category->name}}</span>
                                    </div>
                                </div>                                
                            </div>
                            <div class='col-md-2 ml-auto' style="font-size:17px">
                                @switch($ticket->priority_id)
                                    @case(1)
                                        <span class="badge badge-success">{{$ticket->priority->name}}</span>
                                        @break
                                
                                    @case(2)
                                        <span class="badge badge-info">{{$ticket->priority->name}}</span>
                                        @break

                                    @case(3)
                                        <span class="badge badge-primary">{{$ticket->priority->name}}</span>
                                        @break

                                    @case(4)
                                        <span class="badge badge-warning">{{$ticket->priority->name}}</span>
                                        @break

                                    @case(5)
                                        <span class="badge badge-danger">{{$ticket->priority->name}}</span>
                                        @break
                                
                                    @default
                                        <span>Something went wrong, please try again</span>
                                @endswitch                                
                            </div>
                        </div>
                    </div>
                @endforeach                
            @else
                <p>No Tickets Found.</p>
            @endif
        </div> 
    </div>
    <div class='row mt-4'>
        <div class='col-md'>
            {{$tickets->links()}}
        </div>
    </div>    
</div>