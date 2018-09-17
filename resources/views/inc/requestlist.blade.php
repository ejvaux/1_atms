<div class='row mb-1'>
    <div class='col-lg table-responsive-lg'>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>@sortablelink('priority_id','Priority')</th>
                    <th>@sortablelink('subject','Subject')</th>
                    <th>@sortablelink('status_id','Status')</th>
                    <th>@sortablelink('created_at','Date')</th>
                    <th>@sortablelink('assigned_to','Assigned')</th>
                    <th>@sortablelink('updated_at','Updated')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($requests)>0)
                    @foreach($requests as $request)
                        <tr>
                            <th>{{ $loop->iteration + (($tickets->currentPage() - 1) * 10) }}</th>
                            <th>
                                {!! CustomFunctions::priority_format($request->priority_id) !!}<br>
                                <span style="font-size:.8rem">
                                    @if ($request->start_at == null)
                                        @if ($request->status_id == 2)
                                            On Queue
                                        @else
                                            For Queuing
                                        @endif                                                
                                    @else
                                        @if($request->finish_at == null)
                                        {!! CustomFunctions::datetimelapse($request->start_at) !!}
                                        @else
                                        {!! CustomFunctions::datetimefinished($request->start_at,$request->finish_at) !!}
                                        @endif
                                    @endif
                                </span>
                            </th>
                            <th style='width:35vw'>
                                <div class='row' style="font-size:1rem">
                                    <div class='col-lg' style='overflow:hidden;text-overflow:ellipsis; white-space: nowrap ;width:300px'>
                                        <a href="{{ url('/cr/crv/'.$request->id) }}" ><span>{{$request->subject}}</span></a>
                                    </div>                                                                                
                                </div>
                                <div class='row' style='font-size:.8rem'>
                                    <div class='col-lg'>
                                        <span class='text-muted'><i class="fa fa-user"></i> 
                                            @if($request->user->name == null)
                                                {{$request->username}}
                                            @else
                                                {{$request->user->name}}
                                            @endif
                                        </span>                                        
                                        <span class='text-muted ml-1'><i class="fa fa-building"></i>{{-- <i class="fa fa-calendar"></i> --}}
                                            @if(empty ( $request->department->name ))
                                                {{$request->department}}
                                            @else
                                                {{$request->department->name}}
                                            @endif
                                            {{-- FROM: {{ str_replace('T',' ',$request->start_time) }} TO: {{ str_replace('T',' ',$request->end_time) }} --}}
                                        </span>
                                    </div>
                                </div>                                   
                            </th>
                            <th>
                                <div class='row'>
                                    {!! CustomFunctions::r_status_color($request->status_id) !!}
                                </div>
                                <div class='row'>
                                    <span class='text-muted' style='font-size:.8rem'>#{{$request->request_id}}</span>
                                </div>
                            </th>                    
                            <th>
                                <span style='font-size:.8rem'>{!!str_replace(' ','<br>',$request->created_at)!!}</span>
                            </th>
                            <th>
                                @if($request->assigned_to != '')                                        
                                    {{$request->assign->name}}
                                @endif                                    
                            </th>
                            <th>
                                <span style='font-size:.8rem'>{!!str_replace(' ','<br>',$request->updated_at)!!}</span>
                            </th>
                        </tr>
                    @endforeach                
                @else
                    <p>No Requests Found.</p>
                @endif 
            </tbody>
        </table>
    </div>
</div>
<div class='row'>
    <div class='col-lg'>
        {!! $requests->appends(\Request::except('page'))->render() !!}
    </div>
</div>