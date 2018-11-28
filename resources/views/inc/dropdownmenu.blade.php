<a href="#" class="nav-link" data-toggle="dropdown">
    @if(Auth::user()->unReadNotifications->count()>0)
        <span class="badge badge-danger">{{Auth::user()->unReadnotifications->count()}}</span>
    @else
        <span class="badge badge-info"></span>
    @endif
    <i class="fa fa-bell"></i> <span class='hidewhensmall labelfontbold'> Notification</span>
</a>
<div class="dropdown-menu scrollable-menu">                            
    @if(Auth::user()->Notifications->count())
        <a class="dropdown-item" href='{{ route("markallread")}}'><span class='font-weight-bold'>- Mark all as Read -</span></a>
        <a class="dropdown-item" href='{{ route("clearnotif")}}'><span class='font-weight-bold'>- Clear notifications -</span></a>
        @foreach (Auth::user()->unReadNotifications as $notification)  
            <a class="dropdown-item notiflink" href='/1_atms/public/markread/{{$notification->id}}/{{$notification->data["mod"]}}/{{$notification->data["tid"]}}'><span><span class="badge badge-danger" >NEW</span>{{-- <i class="fa fa-circle" style='font-size:.45rem'></i> --}} {!!$notification->data['message']!!}</span></a>
        @endforeach
        @foreach (Auth::user()->ReadNotifications as $notification)  
            <a class="dropdown-item notiflink" href='/1_atms/public/markread/{{$notification->id}}/{{$notification->data["mod"]}}/{{$notification->data["tid"]}}'><span class='text-muted'>{!!$notification->data['message']!!}</span></a>
        @endforeach                               
    @else
        <div class="dropdown-footer text-center text-muted">
            No new notification
        </div> 
    @endif                                                                               
</div> 