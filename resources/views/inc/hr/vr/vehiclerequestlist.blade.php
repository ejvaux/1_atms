<div class='row mb-1'>
    <div class='col-lg table-responsive-lg'>
        <table class="table">
            <thead class="thead-light">
                <tr class="labelfontbold">
                    <th>#</th>
                    <th>@sortablelink('created_at','Date Prepared')</th>
                    <th>@sortablelink('purpose','Destination/Purpose')</th>
                    <th>@sortablelink('created_by','Requested by')</th>
                    <th>@sortablelink('requested_date','Requested Datetime')</th>
                    <th>@sortablelink('approval_id','Approval')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($vrequests)>0)                
                    @foreach ($vrequests as $vrequest)
                        @if (Auth::user()->isadmin() || Auth::user()->hrvr_approval_type == 0)
                            <tr>
                        @else
                            @if (($vrequest->created_by != Auth::user()->id) || ((Auth::user()->hrvr_approval_type) == $vrequest->approval_id))
                                <tr style="background-color:#E8F8F5; border-left: 4px solid green">
                            @endif
                        @endif
                        {{-- @if($vrequest->approval_id == $vrequestapprovaltypes->count() )
                            <tr >
                        @elseif ($vrequest->created_by == Auth::user()->id)
                            <tr>
                        @elseif (($vrequest->created_by != Auth::user()->id) || ((Auth::user()->hrvr_approval_type) == $vrequest->approval_id))
                            <tr style="background-color:#E8F8F5; border-left: 4px solid green">                        
                        @endif --}}                        
                            <th>{{ $loop->iteration + (($vrequests->currentPage() - 1) * 10) }}</th>
                            <th>
                                {{ date('Y-m-d',strtotime($vrequest->created_at)) }}<br>
                                {{ date('H:i:s',strtotime($vrequest->created_at)) }}
                            </th>
                            <th>
                                <div class='row' style="font-size:1rem">
                                    <div class='col-md' style='overflow:hidden;text-overflow:ellipsis; white-space: nowrap ;width:380px'>
                                        <a href=" {{ url('/hr/vrv/'.$vrequest->id) }} ">{{ $vrequest->purpose }}</a>
                                    </div>                                                                                                                  
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <span class='text-muted' style='font-size:.8rem'>{{ $vrequest->vehicle_request_serial }}</span>
                                    </div>
                                </div>                              
                            </th>
                            <th>
                                <div class="row">
                                    <div class="col-md">
                                        {{ $vrequest->createdBy->name }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        {{ $vrequest->department->name }}
                                    </div>
                                </div>
                            </th>
                            <th>                                
                                <div class="row">
                                    <div class="col-md">
                                        {{ $vrequest->requested_date }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <span style='font-size:.8rem'>{{ $vrequest->departure_time }} to {{ $vrequest->arrival_time }}</span>
                                    </div>
                                </div>                                
                            </th>
                            <th>
                                {{-- @if ($vrequest->approval_id)
                                    <span class="font-weight-bold text-success">
                                        @for ($i = 0; $i < $vrequest->approval_id; $i++)
                                        &#x2714
                                        @endfor                             
                                    </span>
                                @else
                                    <span>                                        
                                        &#10134
                                    </span>
                                @endif  --}}
                                @if ($vrequest->approval_id < $vrequestapprovaltypes->count())
                                    <span class='text-secondary'>For {{ $vrequestapprovaltypes->where('id',$vrequest->approval_id)->first()->name }}</span>
                                @else
                                    <span class='text-success'>Approved</span>
                                @endif
                                
                            </th>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="6">
                            <h5 class="text-center text-muted">No Vehicle Request Found.</h5>
                        </th>
                    </tr>                    
                @endif
                 
            </tbody>
        </table>
    </div>
</div>
<div class='row'>
    <div class='col-lg'>
        {!! $vrequests->appends(\Request::except('page'))->render() !!}
    </div>
</div>