@extends('layouts.app')

@section('pageTitle','Change Password | ATMS - Primatech')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('inc.messages')
            <div class="card">
                <div class="card-header">{{__('Change Password')}}</div>

                <div class="card-body">
                    <form method="POST" id='changepass' action="{{ url('users/changepass/'.Auth::user()->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="curr_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                            <div class="col-md-6">
                                <input id="curr_password" type="password" class="form-control" name="curr_password" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new_password" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="con_password" type="password" class="form-control" name="new_password" required>
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
