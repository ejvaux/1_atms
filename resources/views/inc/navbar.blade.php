<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="/1_mes/">
            <img src="{{ asset('images/primatech-logo.png') }}" style="width: 146px; height: 28px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li> --}}
                @else
                    <div class="nav-item dropdown"> 
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            <span class="badge badge-danger">@if(Auth::user()->unReadNotifications->count()){{Auth::user()->unReadnotifications->count()}}@endif</span> <i class="fa fa-bell"></i> Notification</a>
                        <div class="dropdown-menu scrollable-menu" id='notificon'>                            
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
                    </div> 
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa fa-user-circle"></i> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('user/update/'.Auth::user()->id) }}">
                                {{__('Edit Profile')}}
                            </a>
                            <a class="dropdown-item" href="{{ url('user/changepass') }}">
                                {{__('Change Password')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>                    
                @endguest
            </ul>
        </div>
    </div>
</nav>