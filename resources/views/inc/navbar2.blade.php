<div class="pos-f-t"> 
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">    
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav ml-2">
                    <li>
                        <a class="" href="http://172.16.1.13:8000">
                            {{-- <img class='' src="{{ asset('images/primatech-logo.png') }}" style="width: 146px; height: 28px"> --}}
                            <img class='' src="{{ asset('images/primatech-logo.png') }}" style="width: auto; height: 2.7rem">                        
                        </a>
                    </li>                
                </ul>
            {{-- <div class="navbar-text" style='font-size:1.1rem'> 
                @if (Auth::user()->id != 1)
                    <span class="labelfontbold">{{ Auth::user()->name }}</span>
                @else
                    <span class='medev'><bdo dir="rtl">{{ Auth::user()->name }}</bdo></span>                                        
                @endif                  
            </div>  --}} 
            
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto ml-5">
                    <notifbox
                    :markallreadlink=`{{route("markallread")}}`
                    :clear-notif-link=`{{route("clearnotif")}}`
                    {{-- :unread-notif-count="{{Auth::user()->unReadNotifications->count()}}" --}}
                    {{-- :unreadnotifs='{{json_encode(Auth::user()->unReadNotifications)}}' --}}
                    :readnotifs='{{json_encode(Auth::user()->ReadNotifications)}}'
                    :unread-notif-count="unreadNotifCount1"
                    :unreadnotifs='unreadnotifs1'
                    {{-- :readnotifs='readnotifs1' --}}
                    :user-notif-count='{{Auth::user()->Notifications->count()}}'
                    {{-- v-on:update="updatedata('{{Auth::user()->unReadNotifications->count()}}',{{json_encode(Auth::user()->unReadNotifications)}})" --}}
                    v-on:update="updatedata({{Auth::user()->unReadNotifications->count()}},
                    {{json_encode(Auth::user()->unReadNotifications)}}{{-- ,
                    {{json_encode(Auth::user()->ReadNotifications)}} --}})"
                    {{-- v-for="item in groceryList"
                    v-bind:todo="item"
                    v-bind:key="item.id" --}}
                    
                    ></notifbox>
                    {{-- <li class="nav-item dropdown" id='notificon'> 
                        @include('inc.dropdownmenu')                  
                    </li> --}}
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
                        <li class="navbar-text nb-size-2 mr-4"> 
                            @if (Auth::user()->id != 1)
                                <span class="labelfontbold">Hi! {{ Auth::user()->name }}</span>
                            @else
                                <span class='medev'><bdo dir="rtl">Hi! {{ Auth::user()->name }}</bdo></span>                                        
                            @endif                  
                        </li>                            
                        <li class="nav-item dropdown nb-size-2">  
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-user-circle"></i> <span class='hidewhensmall'>
                                    {{-- @if (Auth::user()->id != 1)
                                        <span class="labelfontbold">{{ Auth::user()->name }}</span>
                                    @else
                                        <span class='medev'><bdo dir="rtl">{{ Auth::user()->name }}</bdo></span>                                        
                                    @endif --}}
                                </span> <span class="caret"></span>
                            </a>
    
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('user/update/'.Auth::user()->id) }}">
                                    <i class="fa fa-edit"></i> {{__('Edit Profile')}}
                                </a>
                                <a class="dropdown-item" href="{{ url('user/changepass') }}">
                                    <i class="fa fa-key"></i> {{__('Change Password')}}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                </a>
    
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>                    
                    @endguest
                </ul>                   
        </div>
    </nav>
</div>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    @include('inc.sidebar')
</div>