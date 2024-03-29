<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="userid" content="{{ Auth::check() ? Auth::user()->id : ''}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle')</title>    
    @include('inc.header')     
</head>
<body>
    <div id="app" class='app'>
        <div id='nvbr'>
            @include('inc.navbar2')
        </div>  
        <main class="container-fluid my-2">            
            <div class="container-fluid" style=''>
                <div class="row">
                    <div class="col-lg-2 m-1 p-0 hidewhensmall" style='height:100vh;' id='sidebr'>
                        {{-- @include('inc.sidebar') --}}
                        <sidebar 
                        :isadmin=`{{Auth::user()->admin == 1}}`
                        :istech=`{{Auth::user()->tech == 1}}`
                        :openticket=`{{ (App\Ticket::where('status_id',1)->count()? App\Ticket::where('status_id',1)->count() : '')}}`
                        :queuedticket=`{{(App\Ticket::where('status_id',2)->where('assigned_to',Auth::user()->id)->count() ? App\Ticket::where('status_id',2)->where('assigned_to',Auth::user()->id)->count() : '')}}`
                        :approvedreviews=`{{(App\CctvReview::where('status_id',1)->count() ? App\CctvReview::where('status_id',1)->count() : '' )}}`
                        :queuedreviews=`{{( App\CctvReview::where('status_id',2)->where('assigned_to',Auth::user()->id)->count() ? App\CctvReview::where('status_id',2)->where('assigned_to',Auth::user()->id)->count() : '' )}}`
                        :vr_approval=`{{(App\VehicleRequest::where('approval_id',Auth::user()->hrvr_approval_type)->count()? App\VehicleRequest::where('approval_id',Auth::user()->hrvr_approval_type)->count() : '')}}`
                        ></sidebar>
                    </div>  
                    <div class='col-lg m-1 pt-3 border rightpanel' id="main_panel" >            
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>        
        <!-- Footer -->
        <foot></foot>
        <!-- Footer -->
    </div>
    @yield('graphs')
</body>
</html>
