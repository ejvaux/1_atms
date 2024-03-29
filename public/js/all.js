$(document).on({
    ajaxStart: function() { NProgress.configure({ showSpinner: false }); NProgress.start(); },   
    ajaxStop: function() { NProgress.done() }    
});

$('.sel2').select2({ width: '100%' });

$('.ticketrange').on('change', function(){
    $('#ticket_to').attr('min', $('#ticket_from').val());
    $('#ticket_from').attr('max', $('#ticket_to').val());
});

$('.requestrange').on('change', function(){
    $('#request_to').attr('min', $('#request_from').val());
    $('#request_from').attr('max', $('#request_to').val());
});
/* -------------------- Loaded on Pjax Success ------------------- */

function loadscript(){
	/* -------------------- Loaded Last ------------------- */
	$( document ).ready(function() {
		
	});
	$(function(){
		if($('.updatetext').is('#update_div')){
			var objDiv = document.getElementById("update_div");
			objDiv.scrollTop = objDiv.scrollHeight;
		}
	});
	$('#app').on('click','#assign_ticket',function(){	
		$('#dd_assigned_to').show();
		$('.assign_grp').hide();
	});
	$('#app').on('click','#cancel_assign',function(){
		$('#dd_assigned_to').hide();
		$('.assign_grp').show();
	});

	// Confirm password
	/* $('#app').on('submit','#changepass',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		if($('new_password').val() == $('con_password').val()){
			alert('weep');
		}
	}); */

	// Assigning Ticket
	/* $(function(){
		if($('.container').is('.admincreateticket_container')){
			initquill('test');
		}
	});	 */

	/* ------------------------- CheckAll Checkbox -------------------------------- */
	function checkAll(ele) {
		var checkboxes = document.getElementsByTagName('input');
		if (ele.checked) {
				for (var i = 0; i < checkboxes.length; i++) {
						if (checkboxes[i].type == 'checkbox') {
								checkboxes[i].checked = true;
						}
				}
		} else {
				for (var i = 0; i < checkboxes.length; i++) {
						console.log(i)
						if (checkboxes[i].type == 'checkbox') {
								checkboxes[i].checked = false;
						}
				}
		}
	}

	/* ------------------------- Timelapse -------------------------------- */
	function timelapse(dt){
		var date1 = moment(dt);
		var date2 = moment(moment().format('YYYY-MM-DD HH:mm:ss'));
		var diff = date2.diff(date1,'seconds');
		if(diff < 60){		
			return diff + " secs ago";		            
		}
		else if(diff >= 60 && diff < 3600){
			$a = Math.floor(diff / 60);
			if($a>1){
				return $a + " mins ago";
			}
			else{
				return $a + " min ago";
			} 
		}
		else if(diff >= 3600 && diff < 86400){
			$a = Math.floor(diff / 3600);
			if($a>1){
				return $a + " hours ago";
			}
			else{
				return $a + " hour ago";
			} 
		}
		else if(diff >= 86400){
			$a = Math.floor(diff / 86400);
			if($a>1){
				return $a + " days ago";
			}
			else{
				return $a + " day ago";
			} 
		}
	}

	/* ------------------------- Quill -------------------------------- */
	function initquill(txt){
		var txtarea =  document.getElementById(txt);		
		quill = new Quill(txtarea, {
			bounds: '#messagecol',
			modules: {
				toolbar: toolbarOptions
			},
			theme: 'snow'
		});
	}

	/* ------------------------------------- Alerts ---------------------------------- */
	function notifalert(type,msg){
		if(type=='success'){
			iziToast.success({
			title: 'System',
			message: msg,
			position: 'topCenter'
			});
		}
	}

	/* ----------------------------- Accordion -------------------------------- */
	var acc = document.getElementsByClassName("accordion");
	var i;
	for (i = 0; i < acc.length; i++) {
	acc[i].addEventListener("click", function() {
		this.classList.toggle("active");
		var panel = this.nextElementSibling;
		if (panel.style.maxHeight){
				panel.style.maxHeight = null;
				panel.style.border = "0";
		} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
				panel.style.borderLeft = "1px solid gray";
				panel.style.borderRight = "1px solid gray";
				panel.style.borderBottom = "1px solid gray";
		} 
	});
	};

	/* ---------------------------- Home Menu tabs ----------------------------- */
	$('#dboard').on('click',function(){
	$.ajax({
			type		: "GET",
			url		: "/1_atms/public/home/dt",
			success		: function(html) {					
							$("#main_panel").html(html).show('slow');
						},
						error : function (jqXHR, textStatus, errorThrown) {							
								window.location.href = '/1_atms/public/login';
						} //end function
	});//close ajax 
	});
	$('#admin_dash').on('click',function(){
	loadcomingsoon();
	});
	$('#admin_roles').on('click',function(){
	$.ajax({
			type		: "GET",
			url		: "/1_atms/public/admin/role",
			success		: function(html) {					
							$("#main_panel").html(html).show('slow');
						},
						error : function (jqXHR, textStatus, errorThrown) {							
								window.location.href = '/1_atms/public/login';
						} //end function
	});//close ajax 
	});
	$('#app').on('click','#admin_checkbox',function(e){
		if($(this).is(":checked")){
			$admin = 1;
		}
		else{
			$admin = 0;
		}	
		$val = $(this).val();
		/* alert('The checkbox is ' + $test + "\nUser id is " + $val); */
		if($val != $('#logged_userid').val()){
			/* alert('not same'); */			
			$.ajax({
				type: 'PUT',
				url	: '/1_atms/public/users/'+$val,
				data: {
					"_token": $('meta[name="csrf-token"]').attr('content'),
					"admin": $admin
				}, 
				datatype: 'JSON',       
				success: function(success_data) {
						iziToast.success({
								message: success_data,
								position: 'topCenter',
								timeout: 2000
						});     
				},
				error: function(data){
				var errors = data.responseJSON;
						var msg = '';
						$.each(errors['errors'], function( index, value ) {
								msg += value +"<br>"
						});
						iziToast.warning({
								message: msg,
								position: 'topCenter',
								timeout: 5000
						});
				} //end function
			});//close ajax
		}
		else{
			e.preventDefault();
			e.stopImmediatePropagation();
			iziToast.warning({
				message: 'Changing your data is not allowed',
				position: 'topCenter',
				timeout: 2000
		});
			/* alert('same'); */
		}
	});
	$('#app').on('click','#tech_checkbox',function(e){
		if($(this).is(":checked")){
			var tech = 1;
		}
		else{
			var tech = 0;
		}
		var val = $(this).val();
		$.ajax({
			type: 'PUT',
			url	: '/1_atms/public/users/'+val,
			data: {
				"_token": $('meta[name="csrf-token"]').attr('content'),
				"tech": tech
			}, 
			datatype: 'JSON',       
			success: function(success_data) {
					iziToast.success({
							message: success_data,
							position: 'topCenter',
							timeout: 2000
					});     
			},
			error: function(data){
			var errors = data.responseJSON;
					var msg = '';
					$.each(errors['errors'], function( index, value ) {
							msg += value +"<br>"
					});
					iziToast.warning({
							message: msg,
							position: 'topCenter',
							timeout: 5000
					});
			} //end function
		});//close ajax
		/* if(val != $('#logged_userid').val()){			
			
		}
		else{
			e.preventDefault();
			e.stopImmediatePropagation();
			iziToast.warning({
				message: 'Changing your data is not allowed',
				position: 'topCenter',
				timeout: 2000
			});
		} */
	});
	$('#app').on('click','#reqapp_checkbox',function(e){
		if($(this).is(":checked")){
			var approve = 1;
		}
		else{
			var approve = 0;
		}
		
		$val = $(this).val();	
			$.ajax({
				type: 'PUT',
				url	: '/1_atms/public/users/'+$val,
				data: {
					"_token": $('meta[name="csrf-token"]').attr('content'),
					"req_approver": approve
				}, 
				datatype: 'JSON',       
				success: function(success_data) {
						iziToast.success({
								message: success_data,
								position: 'topCenter',
								timeout: 2000
						});     
				},
				error: function(data){
				var errors = data.responseJSON;
						var msg = '';
						$.each(errors['errors'], function( index, value ) {
								msg += value +"<br>"
						});
						iziToast.warning({
								message: msg,
								position: 'topCenter',
								timeout: 5000
						});
				} //end function
			});//close ajax
	});
	$('#app').on('change','#levelselect',function(e){
		var val = $(this).data('userid');
		var level = $("option:selected",this).text();
		if(val != $('#logged_userid').val()){			
			$.ajax({
				type: 'PUT',
				url	: '/1_atms/public/users/'+val,
				data: {
					"_token": $('meta[name="csrf-token"]').attr('content'),
					"level": level
				}, 
				datatype: 'JSON',       
				success: function(success_data) {						
						iziToast.success({
								message: success_data,
								position: 'topCenter',
								timeout: 2000
						});
						var pr = $('#levelselect').val();
						$('#levelselect').data('prevval',pr);
				},
				error: function(data){
				var errors = data.responseJSON;
						var msg = '';
						$.each(errors['errors'], function( index, value ) {
								msg += value +"<br>"
						});
						iziToast.warning({
								message: msg,
								position: 'topCenter',
								timeout: 5000
						});
				} //end function
			});//close ajax
		}
		else{
			e.preventDefault();
			e.stopImmediatePropagation();			
			iziToast.warning({
				message: 'Changing your data is not allowed',
				position: 'topCenter',
				timeout: 2000
			});
			$(this).val($(this).data('prevval'));
		}
	});

	/* -------------------------- View Ticket ----------------------------- */
	$('#app').on('submit','#updateform',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		var id = $('#update_ticket_id').val();
		$.ajax({
				type: $(this).attr('method'),
				url	: $(this).attr('action'),
				data: $('#updateform').serialize(),
				datatype: 'JSON',       
				success: function(success_data) {
						iziToast.success({
								message: success_data,
								position: 'topCenter',
								timeout: 2000
						});
						loadviewticket('/1_atms/public/it/vt/'+id,1);		     
				},
				error: function(data){
				var errors = data.responseJSON;
				alert(data.responseText);
						var msg = '';
						$.each(errors['errors'], function( index, value ) {
								msg += value +"<br>"
						});
						iziToast.warning({
								message: msg,
								position: 'topCenter',
								timeout: 5000
						});
				} //end function
		});//close ajax				   
	});
	/* ----------------------------- List Ticket ------------------------------- */
	/* $('#app').on('click','.viewticket',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		loadviewticket($(this).attr('href'));
	}); */

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
	/* $('#app').on("keypress keyup blur",'#searchtextbox',function (event) {    
		$(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	}); */
	$('#app').on("keyup",'#searchtextbox',function(e) {
		if (e.keyCode == 13) {
			$('#search').trigger('click');
		}
	});
	$('#app').on('click','#searchuser',function(){
		var txt = $('#usersearch').val();
		var url = $(this).val();
		if(txt == ""){
			window.location = url;
		}
		else{
			window.location = url + txt;
		}									
	});
	$('#app').on("keyup",'#usersearch',function(e) {
		if (e.keyCode == 13) {
			$('#searchuser').trigger('click');
		}
	});

	/* -------------------- Admin create ticket -------------------- */
	/* $('#app').on('submit','#admincreateticket',function(){
		$('#admincreateticket_message').val(quill.root.innerHTML);
		return true;
	}); */
	/* -------------------- Default create ticket -------------------- */
	/* $('#app').on('submit','#createticketform',function(){
		$('#createticket_message').val(quill.root.innerHTML);
		return true;
	}); */

	/* -------------------- Default create ticket -------------------- */
	$('#app').on('submit','#saveEditTicket',function(){		
		var a = $('#departmentNew').val();
		var b = $('#categoryNew').val();
		var c = $('#subjectNew').val();
		var d = $('#messageNew').val();

		$('#editDepartment').val(a);
		$('#editCategory').val(b);
		$('#editSubject').val(c);
		$('#editMessage').val(d);
		/* alert(a+"-"+b+"-"+c+"-"+"-"+d); */
		return true;
	});

	/* -------------------- Change Priority ticket -------------------- */
	$('#app').on('click','#change_priority_button',function(){
		$('#change_priority').show();
		$('#change_buttons').hide();
	});

	/* --------------------Cancel Change Priority ticket -------------------- */
	$('#app').on('click','#cancel_change_priority',function(){
		$('#change_priority').hide();
		$('#change_buttons').show();
	});

	/* -------------------- Change Status ticket -------------------- */
	$('#app').on('click','#change_status_button',function(){
		$('#change_status').show();
		$('#change_buttons').hide();
	});

	/* --------------------Cancel Change Status ticket -------------------- */
	$('#app').on('click','#cancel_change_status',function(){		
		$('#change_buttons').show();
		$('#change_status').hide();
	});

	/* -------------------- Add Ticket Details -------------------- */
	$('#app').on('click','#add_ticket_details',function(){
		$('.details_edit').show();
		$('.details_display').hide();
	});

	/* --------------------Cancel Add Details ticket -------------------- */
	$('#app').on('click','#cancel_add_details',function(){
		$('.details_edit').hide();
		$('.details_display').show();
	});

	/* -------------------- Close Ticket -------------------- */
	$('#app').on('click','#close_ticket',function(e){
		/* e.preventDefault();
		e.stopImmediatePropagation(); */
		swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, close it!'
		  	}).then((result) => {
			if (result.value) {
				$('#close_ticket_form').trigger('submit');				
			}
		})
	});

	/* -------------------- Cancel Ticket -------------------- */
	$('#app').on('click','#cancel_ticket',function(e){
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
				$('#cancel_ticket_form').trigger('submit');
			}
		})
	});

	/* -------------------- Delete User -------------------- */
	$('#app').on('click','.delete_user',function(e){
		/* e.preventDefault();
		e.stopImmediatePropagation(); */
		swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
		  	}).then((result) => {
			if (result.value) {
				var idd = $(this).val();
				$('#delete_user_form'+idd).trigger('submit');
			}
		})		
	});

	/* -------------------- Edit Ticket -------------------- */
	$('#app').on('click','#edit_ticket',function(){
		$('.editticketlabel').hide();
		$(this).hide();
		$('#edit_ticket_buttons').show();
		$('.editticketinput').show();
		$('#departmentNew').val($('#departmentNewSelected').val());
		$('#categoryNew').val($('#categoryNewSelected').val());
	});
	$('#app').on('click','#cancel_edit_ticket',function(){
		$('.editticketinput').hide();
		$('#edit_ticket_buttons').hide();
		$('#edit_ticket').show();
		$('.editticketlabel').show();	
	});
	
	// Decline ticket
	$('#app').on('click','#decline_ticket',function(){
		/* decline_ticket_form */
		/* swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, decline it!'
		  }).then((result) => {
		if (result.value) {			
			$('#decline_ticket_form').trigger('submit');
		}
		}) */
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			input:'textarea',
			inputPlaceholder: 'Type your reason here...',
			inputAttributes: {
			  autocapitalize: 'off'
			},
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, decline it!',
			/* showLoaderOnConfirm: true,
			preConfirm: () => {
				return [
					document.getElementById('swal-input1').value,
					document.getElementById('swal-input2').value
				  ]
			}, */
			allowOutsideClick: () => !swal.isLoading()
		  }).then((result) => {			
			/* if(result.value == 0){
			}
			else if(result.value == null){
			}
			else if(typeof result.value == "string"){
				$('#reason').val(result.value);
				$('#decline_ticket_form').trigger('submit');
			} */
			if(result.value != null){
				/* $('#reason').val(result.value); */
				if(result.value == ""){
					$('#reason').val(null);
					$('#decline_ticket_form').trigger('submit');
				}
				else{
					$('#reason').val(result.value);
					$('#decline_ticket_form').trigger('submit');
				}
			}
		  })
	});

	// Edit ticket instructions
	$('#app').on('click','#edit_instruction',function(){
		/* edit_instruction_form */
		$('.editinstlabel').hide();
		$('.editinstinput').show();
	});
	$('#app').on('click','#cancel_editinst',function(){
		$('.editinstlabel').show();
		$('.editinstinput').hide();
	});

	$('#app').on('submit','.form_to_submit',function(){
		$('.form_submit_button').prop('disabled', true);
		$('.form_submit_button').html('Please Wait...');
	});

	// Load List
	$('#app').on('change','#sortticketdd',function(){
		// alert($(this).val());
		var m = $(this).val();
		/* alert(m); */
		if(m == 'all'){
			window.location.href = '/1_atms/public/loadticketlist/1';
			/* $.ajax({
				type		: "GET",
				url		    : "/1_atms/public/loadticketlist/1",
				success		: function(html) {					
								$("#table_list").html(html).show('slow');
							},
							error : function (jqXHR, textStatus, errorThrown) {							
									window.location.href = '/1_atms/public/login';
							} //end function
			});//close ajax */
		}
		else if(m == 'handled'){
			window.location.href = '/1_atms/public/loadticketlist/2';
			/* $.ajax({
				type		: "GET",
				url		    : "/1_atms/public/loadticketlist/2",
				success		: function(html) {					
								$("#table_list").html(html).show('slow');
							},
							error : function (jqXHR, textStatus, errorThrown) {							
									window.location.href = '/1_atms/public/login';
							} //end function
			});//close ajax */
		}
		else if(m == 'closed'){
			$.ajax({
				type		: "GET",
				url		    : "/1_atms/public/loadticketlist/3",
				success		: function(html) {					
								$("#table_list").html(html).show('slow');
							},
							error : function (jqXHR, textStatus, errorThrown) {							
									window.location.href = '/1_atms/public/login';
							} //end function
			});//close ajax
			/* window.location = '/1_atms/public/it/ctl'; */
		}
	});
	
}
loadscript();
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

/* -------------------- Upload Images -------------------- */
$('#app').on('click','#uploadbtn',function(){
    $('#uploadinput').show();
    $(this).hide();
});
$('#app').on('click','#canceluploadbtn',function(){
    $('#uploadbtn').show();
    $('#uploadinput').hide();
    $('#inputupload').val('');
});

/* -------------------- Add Images -------------------- */
$('#app').on('click','#addimagebtn',function(){
    $('#addimageinput').show();
    $('#c_attach').hide();
    $(this).hide();
});
$('#app').on('click','#canceladdimagebtn',function(){
    $('#addimagebtn').show();
    $('#c_attach').show();
    $('#addimageinput').hide();
    $('#inputaddimage').val('');
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

$('#app').on('click','#reject_request',function(){
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        input:'textarea',
        inputPlaceholder: 'Type your reason here...',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reject it!',
        allowOutsideClick: () => !swal.isLoading()
      }).then((result) => {		        
        if(result.value != null){
            if(result.value == ""){
                $('#reject_request_reason').val(null);
                $('#reject_request_form').trigger('submit');
            }
            else{
                $('#reject_request_reason').val(result.value);
                $('#reject_request_form').trigger('submit');
            }
        }
      })
});
$('#app').on('click','#allow_checkbox',function(e){
    /* alert('TEST'); */
    if($(this).is(":checked")){
        var allow = 1;
        var mod = 'allow';
    }
    else{
        var allow = 0;
        var mod = 'disallow';
    }
    var val = $(this).val();
    $.ajax({
        type: 'PUT',
        url	: '/1_atms/public/cctvreview/'+val,
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "allow": allow,
            "mod": mod
        }, 
        datatype: 'JSON',       
        success: function(success_data) {
                iziToast.success({
                        message: success_data,
                        position: 'topCenter',
                        timeout: 2000
                });     
        },
        error: function(data){
        var errors = data.responseJSON;
                var msg = '';
                $.each(errors['errors'], function( index, value ) {
                        msg += value +"<br>"
                });
                iziToast.warning({
                        message: msg,
                        position: 'topCenter',
                        timeout: 5000
                });
        } //end function
    });//close ajax    
});
$('#app').on('click','#preview_btn',function(){
    $('#imagepreview').attr('src', $(this).data('imageurl'));
    $('#preview_modal').modal('show')
});
if(!window.Notification){
    alert('Sorry, notifications are not supported')
} 
else {
    /* Notification.requestPermission(function (p) {
        if(p === 'denied'){
            alert('You have denied notifications.');
        }
        else if (p === 'granted'){
            alert('You have granted notifications.');
        }
    }); */
    Notification.requestPermission().then(function(result) {
        console.log(result);
      });
}
$('#app').on('click','#vr_approve_button',function(e){
    swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.value) {
                $('#vr_approveform').trigger('submit');
            }
        })
});

$('#app').on('click','#vr_adminedit',function(e){
    $('.hr_admin_label').hide();
    $('.hr_admin_input').show('slow');
    $('.hr_admin_input2').show('slow');
});

$('#app').on('click','#vr_admincancel',function(e){
    /* $('.hr_admin_input').find('input:text').val(''); */
    $('.hr_admin_input').hide('slow');
    $('.hr_admin_input2').hide();
    $('.hr_admin_label').show('slow');
});

$('#app').on('click','#vr_adminsave',function(e){
    $('#admin_arrange_form').trigger('submit');
});

$('#app').on('click','#vr_edit',function(e){
    $('.user_edit_label').hide();
    $('.user_edit_input').show('slow');
    $('.user_edit_input1').show('slow');   
});
$('#app').on('click','#vr_canceledit',function(e){
    $('.user_edit_input').hide('slow');
    $('.user_edit_input1').hide();
    $('.user_edit_label').show('slow');    
});
$('#app').on('click','#vr_saveedit',function(e){
    $('#vr_useredit_form').trigger('submit');
});