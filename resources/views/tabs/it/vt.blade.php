@include('inc.messages')
<nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">My Tickets</li>
        {{-- <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item">Data</li> --}}
    </ol>
</nav>
<div class="container">
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
<script>
$('#ct_button').on('click',function(){
  $.ajax({
		type		: "GET",
		url		: "/1_atms/public/it/ct",
		success		: function(html) {					
            $("#main_panel").html(html).show('slow');
        },
        error : function (jqXHR, textStatus, errorThrown) {							
                window.location.href = '/1_atms/public/login';
        } //end function
  });//close ajax
});
</script>