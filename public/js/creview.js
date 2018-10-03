$('#app').on('click','#cancel_request',function(e){
    /* e.preventDefault();
    e.stopImmediatePropagation(); */
    swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
          }).then((result) => {
        if (result.value) {
            $('#cancel_request_form').trigger('submit');
        }
    })
});
$('#app').on('click','#edit_request',function(){
    $('.editrequestlabel').hide();
    $(this).hide();
    $('#edit_request_buttons').show();
    $('.editrequestinput').show();
    $('#departmentNew').val($('#departmentNewSelected').val());
    $('#locationNew').val($('#locationNewSelected').val());
    $('#start_timeNew').val($('#start_timecurrent').val());
    $('#end_timeNew').val($('#end_timecurrent').val());

});
$('#app').on('click','#cancel_edit_request',function(){
    $('.editrequestinput').hide();
    $('#edit_request_buttons').hide();
    $('#edit_request').show();
    $('.editrequestlabel').show();	
});
$('#app').on('submit','#saveEditRequest',function(){		
    var a = $('#departmentNew').val();
    var b = $('#subjectNew').val();
    var c = $('#messageNew').val();
    var d = $('#start_timeNew').val();
    var e = $('#end_timeNew').val();
    var f = $('#locationNew').val();
    
    $('#editDepartment').val(a);
    $('#editSubject').val(b);
    $('#editMessage').val(c);
    $('#editStart').val(d);
    $('#editEnd').val(e);
    $('#editLocation').val(f);
    /* alert(a+"-"+b+"-"+c+"-"+"-"+d); */
    return true;
});
$('#app').on('change','#sortrequestdd',function(){
    /* alert($(this).val()); */
    var m = $(this).val();
    if(m == 'all'){
        $.ajax({
			type		: "GET",
			url		    : "/1_atms/public/loadlist/1",
			success		: function(html) {					
							$("#table_list").html(html).show('slow');
						},
						error : function (jqXHR, textStatus, errorThrown) {							
								window.location.href = '/1_atms/public/login';
						} //end function
	    });//close ajax
    }
    else if(m == 'handled'){
        $.ajax({
			type		: "GET",
			url		    : "/1_atms/public/loadlist/2",
			success		: function(html) {					
							$("#table_list").html(html).show('slow');
						},
						error : function (jqXHR, textStatus, errorThrown) {							
								window.location.href = '/1_atms/public/login';
						} //end function
	    });//close ajax
    }
});
$('#app').on('click','#assign_request',function(){	
    $('#req_assigned_to').show();
    $(this).hide();
});
$('#app').on('click','#req_cancel_assign',function(){
    $('#req_assigned_to').hide();
    $('#assign_request').show();
});

/* -------------------- Change Priority Request -------------------- */
$('#app').on('click','#req_change_priority_button',function(){
    $('#req_change_priority').show();
    $('#req_change_buttons').hide();
});

/* --------------------Cancel Change Priority Request -------------------- */
$('#app').on('click','#req_cancel_change_priority',function(){
    $('#req_change_priority').hide();
    $('#req_change_buttons').show();
});

/* -------------------- Change Status Request -------------------- */
$('#app').on('click','#req_change_status_button',function(){
    $('#req_change_status').show();
    $('#req_change_buttons').hide();
});

/* --------------------Cancel Change Status Request -------------------- */
$('#app').on('click','#req_cancel_change_status',function(){		
    $('#req_change_buttons').show();
    $('#req_change_status').hide();
});

/* ------------------- Search ------------------- */
$('#app').on('click','#search',function(){	
    var tid = $('#searchtextbox').val();
    var url = $(this).val();
    if(tid == ""){
        window.location = url;
    }
    else{
        window.location = url + tid;
    }									
});
$('#app').on("keyup",'#searchtextbox',function(e) {
    if (e.keyCode == 13) {
        $('#search').trigger('click');
    }
});

/* -------------------- Add Request Details -------------------- */
$('#app').on('click','#add_review_details',function(){
    $('.review_details_edit').show();
    $('.review_details_display').hide();
});

/* --------------------Cancel Request Details -------------------- */
$('#app').on('click','#cancel_request_details',function(){
    $('.review_details_edit').hide();
    $('.review_details_display').show();
});

/* -------------------- Resolving Request -------------------- */
/* $('#app').on('submit','#req_change_status_form',function(e){		
    e.preventDefault();
    e.stopImmediatePropagation();
    alert('test');
    if($('#req_change_status_id').val() != 5){
        $('#req_start_at').val('');        
    }
    alert($('#req_change_status_id').val());
    alert($('#req_finish_at').val());
    return true;
}); */

