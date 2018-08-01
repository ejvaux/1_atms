<div class="container">
    <div class='row mb-2'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" id="bc_viewticket">My Tickets</a></li>
                    <li class="breadcrumb-item">Ticket Details</li>
                    {{-- <li class="breadcrumb-item">Data</li> --}}
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md">
            <h3>{!! CustomFunctions::status_format($tickets->status_id) !!} {!! CustomFunctions::priority_format($tickets->priority_id) !!}</h3>            
        </div>        
        {{-- <div class="col-md-3">
            <h3>{!! CustomFunctions::priority_format($tickets->priority_id) !!}</h3>
            <label for='priority' class='font-weight-bold'>Priority:</label>
            <input type="text" id='priority' value="{{ $tickets->priority->name }}" readonly>
        </div> --}}               
    </div>
    <div class="row mb-2">
        <div class="col-md-5">
            <h3 class="font-weight-bold">Ticket#: {{ $tickets->id }}</h3>
        </div>
        <div class="col-md-5">
            <h4 class="font-weight-bold">Waiting for Queue</h4>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for='start' class='font-weight-bold'>Start At:</label>
            <input type="text" id="start" value="{{ $tickets->start_at }}" readonly>
        </div>
        <div class="col-md-3">
            <label for='department' class='font-weight-bold'>Department:</label>
            <input type="text" id="department" value="{{ $tickets->department->name }}" readonly>
        </div>
        <div class="col-md-3">
            <label for='category' class='font-weight-bold'>Category:</label>
            <input type="text" id="category" value="{{ $tickets->category->name }}" readonly>
        </div>        
    </div>
    <div class="row mb-2">
        <div class="col-md-10 mr-auto">
            <label for='subject' class='font-weight-bold'>Subject:</label>
            <input type='text' id='subject' value="{{ $tickets->subject }}" style='width:100%' readonly>          
        </div>   
    </div>
    <div class="row mb-1">
        <div class="col-md">
            <label class='font-weight-bold'>Description:</label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <textarea rows="5" style="width:100%" readonly>{{ $tickets->message }}</textarea>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-md">
            <label class='font-weight-bold'>Updates:</label>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-12">
            @foreach($updates as $update)
            @php
                if($update->user->name == Auth::user()->name){
                    $updatetext .= "<p class='text-muted text-right mb-0 mt-3'>(" . $update->created_at . ")</p><div class='card mt-0 mb-2 p-0 ml-auto' style='width:fit-content; background-color:#AED6F1;'><div class='card-body p-2'>" . $update->message . '</div></div>';
                }
                else{
                    $updatetext .= "<p class='text-muted mb-0 mt-3'>". $update->user->name . " (" . $update->created_at . ")</p><div class='card mt-0 mb-2 p-0' style='width:fit-content; background-color:#D4E6F1;'><div class='card-body p-2'>" . $update->message . '</div></div>';
                }            
            @endphp
            @endforeach
            {{-- <textarea rows="10" style="width:100%" readonly>{{$updatetext}}</textarea> --}}
            <div class="border border-secondary px-3" id='update_div' style="width:100%; height:300px; overflow-y: auto;">{!!$updatetext!!}</div>
        </div>
    </div>
    <form id='updateform' method="POST" action="/1_atms/public/ticket_updates">
    @csrf
    <input type="hidden" id='update_ticket_id' name="ticket_id" value="{{ $tickets->id }}">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <div class="row pt-0 mt-0 mb-4">
        <div class="col-md-12">
            <div class="input-group">
                <input type="text" name="message" class="" id="" placeholder="Enter text here . . ." style="width:90%">
                <button type="submit" id="send_update" style="width:10%">SEND</button>
            </div>
        </div>        
    </div>
    </form>
</div>