<div class="container">
    <div class='row'>
        <div class='col-lg'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Tickets</li>
                    {{-- <li class="breadcrumb-item">Ticket Details</li> --}}
                    {{-- <li class="breadcrumb-item">Data</li> --}}
                </ol>
            </nav>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-lg'>
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary">All</button>
                <button type="button" class="btn btn-secondary">Queued</button>
                <button type="button" class="btn btn-secondary">Handled</button>
                <button type="button" class="btn btn-secondary">Closed</button>
            </div>
        </div>
        <div class="col-lg-4 ml-auto">
            <form>
                <div class="input-group">
                    <input type="text" class="form-control" id="adminsearch" placeholder="Enter ticket number . . .">
                    <button type="button" id="refresh"><i class="fa fa-search"></i></button>
                </div>               
            </form>
        </div>
    </div>
    <div class='row mb-1'>
        <div class='col-lg table-responsive-lg'>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Priority</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Assigned to</th>
                        <th>Updated</th>
                        <th><input type='checkbox' onchange='checkAll(this)'></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($tickets)>0)
                        @foreach($tickets as $ticket)
                            <tr>
                                <th>
                                    {!! CustomFunctions::priority_format($ticket->priority_id) !!}
                                </th>
                                <th style='width:400px'>
                                    <div class='row' style="font-size:15px">
                                        <div class='col-lg' style='overflow:hidden;text-overflow:ellipsis; white-space: nowrap ;width:300px'>
                                            <a class="adminviewticket" href="/1_atms/public/it/av/{{$ticket->id}}" ><span>{{$ticket->subject}}</span></a>
                                        </div>                                                                                
                                    </div>
                                    <div class='row' style='font-size:11px'>
                                        <div class='col-lg'>
                                            <span class='text-muted'><i class="fa fa-user"></i> {{$ticket->user->name}}</span>                                        
                                            <span class='text-muted ml-1'><i class="fa fa-folder"></i> {{$ticket->category->name}}</span>
                                        </div>
                                    </div>                                   
                                </th>
                                <th>
                                    <div class='row'>
                                        {!! CustomFunctions::status_color($ticket->status_id) !!}
                                    </div>
                                    <div class='row'>
                                        <span class='text-muted' style='font-size:11px'>#{{$ticket->id}}</span>
                                    </div>
                                </th>                    
                                <th>
                                    {!!str_replace(' ','<br>',$ticket->created_at)!!}
                                </th>
                                <th>
                                    {{$ticket->assigned_to}}
                                </th>
                                <th>
                                    {!!str_replace(' ','<br>',$ticket->updated_at)!!}
                                </th>
                                <th>
                                    <input type='checkbox'>
                                </th>
                            </tr>
                        @endforeach                
                    @else
                        <p>No Tickets Found.</p>
                    @endif 
                </tbody>
            </table>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg'>
            {{$tickets->links()}}
        </div>
    </div>
</div>