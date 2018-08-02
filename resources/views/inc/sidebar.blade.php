<div class="card m-0 p-0">                              
    <nav class="card-body m-0">
        <ul class="list-group list-group-flush">
            <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id='dboard' class='sidetab' href='#'>Dashboard</a><span class="badge badge-info"></span></li>
            <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="admin_dash" class='sidetab' href='#'>Admin</a><span class="badge badge-info"></span></li>
            <li class="list-group-item noborder"><a class='sidetab' href='#'>IT</a>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="admin_it" class='sidetab' href='#'>Admin</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="myticket" class='sidetab' href='#'>Tickets</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="cctv" class='sidetab' href='#'>CCTV Review</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="contact" class='sidetab' href='#'>Contac Us</a><span class="badge badge-info"></span></li>
                </ul>
            </li>
            <li class="list-group-item noborder"><a class='sidetab' href='#'>HR</a>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="hr1" class='sidetab' href='#'>Vehicle Request</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="hr2" class='sidetab' href='#'>Other Request</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="hr3" class='sidetab' href='#'>Others</a><span class="badge badge-info"></span></li>
                </ul>
            </li>
            <li class="list-group-item noborder"><a class='sidetab' href='#'>PURCHASING</a>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="p1" class='sidetab' href='#'>Purchase Request</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="p2" class='sidetab' href='#'>Other Request</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="p3" class='sidetab' href='#'>Others</a><span class="badge badge-info"></span></li>
                </ul>
            </li>
        </ul>                              
    </nav>                       
</div>
{{-- <div class="card m-0 p-0" style='height:100vh;'>                              
    <nav class="card-body m-0 p-0">
        <button type='button' id="homeButton" class='accordion'>Dashboard</button>
            <ul class="nav flex-column panel" id='home'>                                                          
                <li class="nav-item ">
                    <a class="nav-link menutab" href="#" id="dboard">
                        <span class="badge badge-danger"></span> Home
                    </a>
                </li>
                @if(Auth::check())
                    @if (Auth::user()->isAdmin())
                        <li class="nav-item ">
                            <a class="nav-link menutab" href="#" id="admin_dash">
                                <span class="badge badge-danger"></span> Admin
                            </a>
                        </li>
                    @endif
                @endif                 
            </ul>
        <button type='button' id="itButton" class='accordion'>IT</button>                
        <ul class="nav flex-column panel" id='itmenu'>
            @if(Auth::check())
                @if (Auth::user()->isAdmin())
                    <li class="nav-item ">
                        <a class="nav-link menutab" href="#" id="admin_it">
                            <span class="badge badge-danger"></span> Admin
                        </a>
                    </li>
                @endif
            @endif                                                          
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="myticket">
                    <span class="badge badge-danger"></span>Tickets
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="cctv">
                    <span class="badge badge-danger"></span> CCTV Review
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="contact">
                    <span class="badge badge-danger"></span> Contact Us
                </a>
            </li>               
        </ul>
        <button type='button' id="hrButton" class='accordion'>HR</button>
        <ul class="nav flex-column panel" id='hrmenu'>                                                          
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="hr1">
                    <span class="badge badge-danger"></span> Vehicle Request
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="hr2">
                    <span class="badge badge-danger"></span> Other Request
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="hr3">
                    <span class="badge badge-danger"></span> Other
                </a>
            </li>               
        </ul>
        <button type='button' id="hrButton" class='accordion'>PURCHASING</button>
        <ul class="nav flex-column panel" id='hrmenu'>                                                          
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="p1">
                    <span class="badge badge-danger"></span> Purchase Request
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="p2">
                    <span class="badge badge-danger"></span> Other Request
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link menutab" href="#" id="p3">
                    <span class="badge badge-danger"></span> Other
                </a>
            </li>               
        </ul>                              
    </nav>                       
</div> --}}