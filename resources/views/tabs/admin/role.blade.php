<div class='container'>
    <div class='row mb-2'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Roles</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class='row'>
        <div class='col-md'>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>ADMIN</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($users)>0)
                        @foreach($users as $user)
                            <tr>
                                <th>
                                    {{$user->id}}
                                </th>
                                <th>
                                    {{$user->name}}
                                </th>
                                <th>
                                    {{$user->email}}
                                </th>
                                <th>
                                    @if ($user->admin == true)
                                        <input id='admin_checkbox' value='{{$user->id}}' type='checkbox' checked>
                                    @else
                                        <input id='admin_checkbox' value='{{$user->id}}' type='checkbox'>
                                    @endif
                                </th>
                            </tr>
                        @endforeach                
                    @else
                        <p>No Users Found.</p>
                    @endif 
                </tbody>
            </table>
        </div>
    </div>
</div>