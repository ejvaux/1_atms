@extends('layouts.app')

@section('pageTitle','Edit Profile | ATMS - Primatech')

@section('content')
<div class="container">
    <div class="row justify-content-center">        
        <div class="col-md-8">
            @include('inc.messages')
            <div class="card">
                <div class="card-header">{{__('Edit User Profile')}}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('users/'.Auth::user()->id) }}">
                        @csrf
                        @method('PUT')
                        <input type='hidden' name='mod' value='edit'>
                        <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{__('Name')}}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required >                                
                            </div>
                        </div>                        

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                                <a class="btn btn-warning" href='{{ url("/dashboard") }}'>
                                    {{ __('Home') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
