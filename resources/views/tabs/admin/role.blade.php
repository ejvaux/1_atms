@extends('layouts.app2')

@section('pageTitle','Admin | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class='container'>
    <input type='hidden' value='{{Auth::user()->id}}' id='logged_userid'>    
    <div class='row'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    <li class="breadcrumb-item text-muted">Roles</li>
                </ol>
            </nav>
        </div>        
    </div>
    <div class='row mb-2'>        
        <div class="col-md-4">
            <form>
                <div class="input-group">
                    <input type="text" class="form-control" id="usersearch" placeholder="Search user . . .">
                    <button type="button" id="searchuser" value="/1_atms/public/admin/role/"><i class="fa fa-search"></i></button>
                </div>               
            </form>
        </div>
        {{-- <div class='col-md-3'>
            <button type='button' class='btn btn-secondary'>Add Tech</button>
        </div> --}}
    </div>
    <div class='row mb-2'>
        <div class='col-md table-responsive'>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        {{-- <th>ADMIN</th>
                        <th>TECH</th>
                        <th>REQ_APPRVR</th>
                        <th>LEVEL</th> --}}
                        <th>USER ROLES</th>
                        {{-- <th>DEL</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @if (count($users)>0)
                        @foreach($users as $user)
                            <tr>
                                <th>{{ $loop->iteration + (($users->currentPage() - 1) * 20) }}</th>
                                <th>
                                    {{$user->name}}
                                </th>
                                <th>
                                    {{$user->email}}
                                </th>
                                <th>
                                    <button class="btn btn-primary" v-on:click='openrolemodal({{$user->id}})'>Edit Role</button>
                                </th>
                                {{-- <th>
                                    @if ($user->admin == true)                                    
                                        <input id='admin_checkbox' value='{{$user->id}}' type='checkbox' checked>                                   
                                    @else
                                        <input id='admin_checkbox' value='{{$user->id}}' type='checkbox'>
                                    @endif
                                </th>
                                <th>
                                    @if ($user->tech == true)
                                        <input class=" tech_checkbox" id='tech_checkbox' value='{{$user->id}}' type='checkbox' checked>
                                    @else
                                        <input class=" tech_checkbox" id='tech_checkbox' value='{{$user->id}}' type='checkbox'>
                                    @endif
                                </th> --}}
                                {{-- <th>
                                    @if ($user->req_approver == true)
                                        <input id='reqapp_checkbox' value='{{$user->id}}' type='checkbox' checked>
                                    @else
                                        <input id='reqapp_checkbox' value='{{$user->id}}' type='checkbox'>
                                    @endif
                                </th> --}}
                                {{-- <th>                                    
                                    <input type='hidden' value='{{$user->level}}' id='oldselval{{$user->id}}'>
                                    <select id='levelselect' data-userid='{{$user->id}}' data-prevval='{{$user->level}}'>
                                        <option value='0'@if($user->level == 0) selected @endif>0</option>
                                        <option value='1'@if($user->level == 1) selected @endif>1</option>
                                        <option value='2'@if($user->level == 2) selected @endif>2</option>
                                        <option value='3'@if($user->level == 3) selected @endif>3</option>
                                    </select>
                                </th> --}}                                
                                {{-- <th>
                                    @if($user->id != Auth::user()->id)
                                        <form id='delete_user_form{{ $user->id }}' method='POST' action='/1_atms/public/users/{{ $user->id }}'>
                                            @method('DELETE')
                                            @csrf          
                                            <button type='button' id='delete_user' class='btn btn-danger p-0 px-2 m-0 delete_user' value="{{ $user->id }}">X</button>
                                        </form>
                                    @endif
                                </th> --}}
                            </tr>
                        @endforeach                
                    @else
                        <p>No Users Found.</p>
                    @endif 
                </tbody>
            </table>
        </div>
    </div>
    <div class='row'>
        <div class='col-md'>
            {{$users->links()}}
        </div>
    </div>
    <usermodal 
    :userd='userdata'
    :approvaltypes='{{$hr_vr_approval_types}}'
    :loggeduserid='{{Auth::user()->id}}'
    :departments='{{$departments}}'
    ></usermodal>
</div>
@endsection