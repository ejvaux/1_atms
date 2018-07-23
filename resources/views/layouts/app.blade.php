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
    <script>
        $(window).load(function() {
            NProgress.start();
            NProgress.inc();
        });        
    </script>       
</head>
<body>
    <div id="app">
        @include('inc.navbar')  
        <main class="container py-4">
            @yield('content')
        </main>
    </div>
    <script>
        $(document).ready(function() {
            NProgress.done();
        });
    </script>
</body>
</html>
