<ul class="nav justify-content-center">
    <li class="nav-item mx-1">
        <a href="{{url('/it/rp/today')}}" class="nav-link btn btn-outline-secondary">Day</a>
    </li>
    <li class="nav-item mx-1">
        <a href="{{url('/it/rp/week')}}" class="nav-link btn btn-outline-secondary">Week</a>
    </li>
    <li class="nav-item mx-1">
        <a href="#" class="nav-link btn btn-outline-secondary disabled">Month</a>
    </li>
    <li class="nav-item mx-1">
        <a href="#" class="nav-link btn btn-outline-secondary disabled">Year</a>
    </li>
    <li class="nav-item mx-1 ">
        <div class="dropdown">  
            <a class="nav-link btn btn-outline-secondary dropdown-toggle  disabled" href="#" role="button" data-toggle="dropdown">
                Custom Date Range
            </a>            
            <div class="dropdown-menu dropdown-menu-right">
                <div class='dropdown-header'>
                    <input class='' type='date'> -
                    <input class='' type='date'>
                    <button class='btn btn-primary py-0'>Go!</button>
                </div>
            </div>
        </div>
    </li>
</ul>