<div class="container">
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" id="bc_viewticket">My Tickets</a></li>
                    <li class="breadcrumb-item">View Ticket</li>
                    {{-- <li class="breadcrumb-item">Data</li> --}}
                </ol>
            </nav>
        </div>
    </div>
    <div class="row pt-1">
        <div class="col-md-3">
            <span><h3>#12345</h3></span>
        </div>
        <div class="col-md-3">
            <span></span>
        </div>
        <div class="col-md-3">
            <span></span>
        </div>
    </div>    
</div>
<script>
$('#bc_viewticket').on('click',function(){
    loadlistTicket();
});
</script>