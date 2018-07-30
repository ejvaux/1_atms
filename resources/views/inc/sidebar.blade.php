<div class="card m-0 p-0" style='height:100vh;'>                              
    <nav class="card-body m-0 p-0">
        <button type='button' id="homeButton" class='accordion'>Dashboard</button>
            <ul class="nav flex-column panel" id='home'>                                                          
                <li class="nav-item ">
                    <a class="nav-link menutab" href="#" id="dboard">
                        <span class="badge badge-pill badge-danger"></span> Home
                    </a>
                </li>
                @if(Auth::check())
                    @if (Auth::user()->isAdmin())
                        <li class="nav-item ">
                            <a class="nav-link menutab" href="#" id="admin_dash">
                                <span class="badge badge-pill badge-danger"></span> Admin
                            </a>
                        </li>
                    @endif
                @endif                  
                {{-- <li class="nav-item ">
                    <a class="nav-link menutab" href="#" id="createticket">
                        <span class="badge badge-pill badge-danger"></span> Other Request
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link menutab" href="#" id="contact">
                        <span class="badge badge-pill badge-danger"></span> Other
                    </a>
                </li>  --}}              
            </ul>
        <button type='button' id="itButton" class='accordion'>IT</button>                
        <ul class="nav flex-column panel" id='itmenu'>
            @if(Auth::check())
                @if (Auth::user()->isAdmin())
                    <li class="nav-item ">
                        <a class="nav-link menutab" href="#" id="admin_it">
                            <span class="badge badge-pill badge-danger"></span> Admin
                        </a>
                    </li>
                @endif
            @endif                                                          
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="myticket">
                    <span class="badge badge-pill badge-danger"></span>Tickets
                </a>
            </li>
            {{-- <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="createticket">
                    <span class="badge badge-pill badge-danger"></span> Create Ticket
                </a>
            </li> --}}
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="cctv">
                    <span class="badge badge-pill badge-danger"></span> CCTV Review
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="contact">
                    <span class="badge badge-pill badge-danger"></span> Contact Us
                </a>
            </li>               
        </ul>
        <button type='button' id="hrButton" class='accordion'>HR</button>
        <ul class="nav flex-column panel" id='hrmenu'>                                                          
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="hr1">
                    <span class="badge badge-pill badge-danger"></span> Vehicle Request
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="hr2">
                    <span class="badge badge-pill badge-danger"></span> Other Request
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="hr3">
                    <span class="badge badge-pill badge-danger"></span> Other
                </a>
            </li>               
        </ul>
        <button type='button' id="hrButton" class='accordion'>PURCHASING</button>
        <ul class="nav flex-column panel" id='hrmenu'>                                                          
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="p1">
                    <span class="badge badge-pill badge-danger"></span> Purchase Request
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="p2">
                    <span class="badge badge-pill badge-danger"></span> Other Request
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="p3">
                    <span class="badge badge-pill badge-danger"></span> Other
                </a>
            </li>               
        </ul>                              
    </nav>                       
</div>