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
        @include('inc.navbar')  
        <main class="container-fluid py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
