@extends('layouts.app')

@section('pageTitle','Home | ATMS - Primatech')

@section('content')
<div class="container">
    <div class="jumbotron text-center">
        <div class="container">
            <h1 class="display-4">Welcome to Approval and Ticket Management System</h1>
            <h2 class="mb-4">Prima Tech Phils., Inc.</h2>
            @guest
                <a class="btn btn-lg btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                <a class="btn btn-lg btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>               
            @endguest
        </div>
    </div>
</div> <!-- /container -->    
@endsection