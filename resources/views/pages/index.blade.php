@extends('layouts.app')

@section('pageTitle','TMS - Primatech')

@section('content')
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1 class="display-3">Welcome</h1>
        <h4 class='mb-3'>Ticket Management System - Prima Tech Phils., Inc.</h4>
        {{-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p> --}}
        @guest
            <a class="btn btn-primary btn-lg" href="{{ route('login') }}">{{ __('Login') }}</a>
            <a class="btn btn-primary btn-lg" href="{{ route('register') }}">{{ __('Register') }}</a>
            
        @endguest
    </div>
</div>

    <div class="container">
    <!-- Example row of columns -->
    {{-- <div class="row">
        <div class="col-md-4">
        <h2>Heading</h2>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
        <h2>Heading</h2>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
        <h2>Heading</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
        </div>
    </div>

    <hr> --}}

    </div> <!-- /container -->

{{-- <footer class="container">
    <p>&copy; Prima Tech Phils., Inc. 2017-2018</p>
</footer> --}}
    
@endsection