/* ------------------------- Global Variable -------------------------------- */
var quill;
var toolbarOptions = [
	/* [{ 'header': [1, 2, 3, 4, 5, 6, false] }], */
	['bold', 'italic', 'underline', 'strike'],        // toggled buttons
	['blockquote', 'code-block'],
	[{ 'list': 'ordered'}, { 'list': 'bullet' }],
	[{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
	[{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
	[{ 'direction': 'rtl' }],                         // text direction
	[{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
	[{ 'align': [] }],

	['clean']                                         // remove formatting button
];

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
		$(this).hide();
	});
	$('#app').on('click','#cancel_assign',function(){
		$('#dd_assigned_to').hide();
		$('#assign_ticket').show();
	});

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
		if(val != $('#logged_userid').val()){			
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
		}
		else{
			e.preventDefault();
			e.stopImmediatePropagation();
			iziToast.warning({
				message: 'Changing your data is not allowed',
				position: 'topCenter',
				timeout: 2000
			});
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
		swal({
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
	})
	});

	$('#app').on('submit','.form_to_submit',function(){
		$('.form_submit_button').prop('disabled', true);
	});

	// Load List
	$('#app').on('change','#sortticketdd',function(){
		// alert($(this).val());
		var m = $(this).val();
		/* alert(m); */
		if(m == 'all'){
			$.ajax({
				type		: "GET",
				url		    : "/1_atms/public/loadticketlist/1",
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
				url		    : "/1_atms/public/loadticketlist/2",
				success		: function(html) {					
								$("#table_list").html(html).show('slow');
							},
							error : function (jqXHR, textStatus, errorThrown) {							
									window.location.href = '/1_atms/public/login';
							} //end function
			});//close ajax
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
	/* ------------------- Search ------------------- */
	$('#app').on('click','#search1',function(){
		var type = $('sortticketdd').val();
		var tid = $('#searchtextbox1').val();
		var url = $(this).val();
		alert(url + type + '/' + tid);
		/* if(tid == ""){
			window.location = url + type;
		}
		else{
			window.location = url + type + '/' + tid;
		} */									
	});
	/* $('#app').on("keypress keyup blur",'#searchtextbox',function (event) {    
		$(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	}); */
	$('#app').on("keyup",'#searchtextbox1',function(e) {
		if (e.keyCode == 13) {
			$('#search1').trigger('click');
		}
	});
}
loadscript();