<a href="#" class="nav-link" data-toggle="dropdown">
    <span> 
        <i class="fa fa-bell nb-size"></i>
        @if(Auth::user()->unReadNotifications->count()>0)
            <span class="badge-pill badge-danger badge-top">{{Auth::user()->unReadnotifications->count()}}</span>
        @else
            <span class="badge badge-info"></span>
        @endif
    </span>
</a>
{{-- <div class="dropdown-menu scrollable-menu">                            
    @if(Auth::user()->Notifications->count())
        <a class="dropdown-item" href='{{ route("markallread")}}'><span class='font-weight-bold'>- Mark all as Read -</span></a>
        <a class="dropdown-item" href='{{ route("clearnotif")}}'><span class='font-weight-bold'>- Clear notifications -</span></a>
        @foreach (Auth::user()->unReadNotifications as $notification)  
            <a class="dropdown-item notiflink" href='/1_atms/public/markread/{{$notification->id}}/{{$notification->data["mod"]}}/{{$notification->data["tid"]}}'><span><span class="badge badge-danger" >NEW</span>{!!$notification->data['message']!!}</span></a>
        @endforeach
        @foreach (Auth::user()->ReadNotifications as $notification)  
            <a class="dropdown-item notiflink" href='/1_atms/public/markread/{{$notification->id}}/{{$notification->data["mod"]}}/{{$notification->data["tid"]}}'><span class='text-muted'>{!!$notification->data['message']!!}</span></a>
        @endforeach
    @else
        <div class="dropdown-footer text-center text-muted">
            No new notification
        </div> 
    @endif                                                                         
</div> --}}
{{-- <div class='dropdown-menu  scrollable-menu'> --}}
<ul class='dropdown-menu'>
    <li class="dropdown-header border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md">
                    <strong>Notifications</strong>
                </div>
                <div class="col-md mr-auto pr-0 m-0 text-right">
                    <span class='font-weight-bold'><a  href='{{ route("markallread")}}'>Mark all as Read</a></span>
                </div>
            </div>
        </div>                
    </li>
    <li>
        <div class="notif-box">
            <ul class='p-0 notif-box-2'>
                @if(Auth::user()->Notifications->count())                    
                    @foreach (Auth::user()->unReadNotifications as $notification)
                        <li class='border-bottom border-top p-0'>
                            <a class="dropdown-item notiflink" href='/1_atms/public/markread/{{$notification->id}}/{{$notification->data["mod"]}}/{{$notification->data["tid"]}}'>                                
                                <div class="notice notice-success m-0">
                                    <strong>{!!$notification->data['header']!!}</strong><br>
                                    {!!$notification->data['msg']!!}<br>
                                    <span class='text-muted notif-lapsed-time'>{{ CustomFunctions::datetimelapse($notification->created_at) }}</span>
                                </div>                                                                                                    
                            </a>
                        </li>
                    @endforeach
                    @foreach (Auth::user()->ReadNotifications as $notification) 
                        <li class='border-bottom border-top p-0'>
                            <a class="dropdown-item notiflink" href='/1_atms/public/markread/{{$notification->id}}/{{$notification->data["mod"]}}/{{$notification->data["tid"]}}'>
                                <div class="notice m-0">
                                    <strong>{!!$notification->data['header']!!}</strong><br>
                                    {!!$notification->data['msg']!!}<br>
                                    <span class='text-muted' notif-lapsed-time>{{ CustomFunctions::datetimelapse($notification->created_at) }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @else
                    <div class="text-center text-muted m-3" style='font-size: 1rem;'>
                        No new notification
                    </div> 
                @endif               
            </ul>
        </div>
    </li>
    <li class=' text-center pt-2 border-top'>
        <a href='{{ route("clearnotif")}}'><span class='font-weight-bold p-0'>Clear notifications</span></a>
    </li>
</ul>