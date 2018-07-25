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
            <div class="col-md-2 m-0 px-1" style='height:100vh;'>
                <div class="card">                              
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
                {{-- <div id="accordion">
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                          <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            IT
                          </button>
                        </h5>
                      </div>
                  
                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                          <nav>
                              test
                          </nav>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            HR
                          </button>
                        </h5>
                      </div>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <nav>
                                test
                            </nav>
                        </div>
                      </div>
                    </div>                    
                </div> --}}
            </div>
            <div class='col-md-10 m-0 pt-3 border' id="main_panel" style="background:white" >
            <?php echo $child; ?>         
            </div> 
        </div>
    </div>
</div>
@endsection
