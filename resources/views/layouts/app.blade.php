<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle')</title>

    @include('inc.header')         
</head>
<body>    
    <input type='hidden' value='{{Auth::user()->id}}' id='logged_userid'>
    <div id="app" class='app'>
        @include('inc.navbar')  
        <main class="container-fluid py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
