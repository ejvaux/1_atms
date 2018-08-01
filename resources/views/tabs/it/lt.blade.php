<div class="container-fluid">
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">My Tickets</li>
                    {{-- <li class="breadcrumb-item"><a href="#">Library</a></li>
                    <li class="breadcrumb-item">Data</li> --}}
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-3">
        <div class='col-md'>
            <button class='btn btn-secondary' type="button" id="ct_button">Create Ticket</button>
        </div>
        <div class="col-md-4 ml-auto">
            <form>
                <div class="input-group">
                    <input type="text" class="form-control" id="search" placeholder="Enter ticket number . . .">
                    <button type="button" id="refresh"><i class="fa fa-search"></i></button>
                </div>               
            </form>
        </div>
    </div> 
    <div class='row'>
        <div class='col-md'>
            @if (count($tickets)>0)
                @foreach($tickets as $ticket)
                    <div class='card mb-2'>
                        <div class="card-body row pl-3 pr-0 pb-2 ">                                                     
                            <div class='col-md-10'>
                                <div class='row'>
                                    <div class='col-md'>
                                        <h5 style='overflow:hidden;text-overflow:ellipsis;white-space: nowrap ;'>
                                            <sup>
                                                {!! CustomFunctions::status_format($ticket->status_id) !!}                                               
                                            </sup>                                    
                                            <a class="viewticket" href="/1_atms/public/it/vt/{{$ticket->id}}" ><span class='pl-2'>{{$ticket->subject}}</span></a>
                                        </h5>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-3'>
                                        <strong>#{{$ticket->id}}</strong>
                                    </div>
                                    <div class='col-md-5'>
                                        <span class='text-muted'>Submitted {{-- by 
                                            @if($ticket->user->name == Auth::user()->name)
                                                <strong>You</strong>
                                            @else
                                                <strong>{{$ticket->user->name}}</strong>
                                            @endif --}}
                                             at <i>{{$ticket->created_at}}</i>.</span>
                                    </div>
                                    <div class='col-md-3 ml-auto'>
                                        <span class="badge badge-light" style="font-size:13px">{{$ticket->category->name}}</span>
                                    </div>
                                </div>                                
                            </div>
                            <div class='col-md-2 ml-auto' style="font-size:17px">
                                {!! CustomFunctions::priority_format($ticket->priority_id) !!}                                                                
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