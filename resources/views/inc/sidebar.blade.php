<div class="card m-0 p-0" style="font-size:13px">                              
    <nav class="card-body m-0 pl-1 mr-0 pr-0">
        <ul class="list-group list-group-flush">
            {{-- <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/dashboard'>DASHBOARD</a><span class="badge badge-info"></span></li> --}}
            @if(Auth::check())
                @if (Auth::user()->isAdmin())
                    <li class="list-group-item noborder"><a class='sidetab' href='#'>ADMIN</a><span class="badge badge-info"></span>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/admin/role'>ROLES</a><span class="badge badge-info"></span></li>
                            {{-- <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="hr2" class='sidetab' href='#'>OTHER REQUEST</a><span class="badge badge-info"></span></li>
                            <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="hr3" class='sidetab' href='#'>OTHERS</a><span class="badge badge-info"></span></li> --}}
                        </ul>
                    </li>
                @endif
            @endif            
            <li class="list-group-item noborder"><a class='sidetab' href='#'>IT</a>
                <ul class="list-group list-group-flush">
                    @if(Auth::check())
                        @if (Auth::user()->isAdmin())
                            <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/it/al'>TICKETS</a><span class="badge badge-info"></span></li>
                            <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='{{url('/it/rp')}}'>REPORTS</a><span class="badge badge-info"></span></li>
                        @else
                            <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/it/lt'>TICKETS</a><span class="badge badge-info"></span></li>
                        @endif
                    @endif                    
                    {{-- <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a id="myticket" class='sidetab' href='#'>TICKETS</a><span class="badge badge-info"></span></li> --}}
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/it/cu'>CCTV REVIEW</a><span class="badge badge-info"></span></li>
                    {{-- <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/cr/crl'>CCTV REVIEW</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/it/cu'>CONTACT US</a><span class="badge badge-info"></span></li> --}}
                </ul>
            </li>
            {{-- <li class="list-group-item noborder"><a class='sidetab' href='#'>HR</a>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/comingsoon'>VEHICLE REQUEST</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/comingsoon'>OTHER REQUEST</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/comingsoon'>OTHERS</a><span class="badge badge-info"></span></li>
                </ul>
            </li>
            <li class="list-group-item noborder"><a class='sidetab' href='#'>PURCHASING</a>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/comingsoon'>PURCHASE REQUEST</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/comingsoon'>OTHER REQUEST</a><span class="badge badge-info"></span></li>
                    <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/comingsoon'>OTHERS</a><span class="badge badge-info"></span></li>
                </ul>
            </li> --}}
        </ul>                              
    </nav>                       
</div>