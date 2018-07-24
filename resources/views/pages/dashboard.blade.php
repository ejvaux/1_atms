@extends('layouts.app')

@section('pageTitle','Dashboard | TMS - Primatech')

@section('content')
<div class="container">
    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item active">
            <a class="nav-link active" id="view-tab" data-toggle="tab" href="#view" role="tab" >My Tickets</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="create-tab" data-toggle="tab" href="#create" role="tab" >Create Ticket</a>
        </li>        
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" >Contact</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="create" role="tabpanel">@include('tabs.ct')</div>
        <div class="tab-pane fade show active" id="view" role="tabpanel">@include('tabs.vt')</div>
        <div class="tab-pane fade" id="contact" role="tabpanel">Under Construction</div>
    </div> --}}

    <div class="container-fluid" style='height:100vh'>
        <div class="row">
            <div class="col-md-2 m-0 p-1" style='height:100vh'>
                <div class="card" style='height:100vh'>                              
                        <nav class="card-body">                        
                            <ul class="nav flex-column">                            
                                <li class="nav-item">
                                    <a class="nav-link js-Pjax" href="{{ url("/dashboard") }}" id="myticket">
                                      <span class="badge badge-pill badge-danger"></span> My Tickets
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-Pjax" href="{{ url("/dashboard/ct") }}" id="createticket">
                                      <span class="badge badge-pill badge-danger"></span> Create Ticket
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-Pjax" href="{{ url("/dashboard/cu") }}" id="contact">
                                      <span class="badge badge-pill badge-danger"></span> Contact Us
                                    </a>
                                </li>               
                            </ul>                                      
                        </nav>                       
                </div>
            </div>
            <div class='col-md-10 m-0 pt-3 border' id="main_panel" style="background:white" >
            <?php echo $child; ?>         
            </div> 
        </div>
    </div>
</div>
@endsection
