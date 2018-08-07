/* ------------------------- Global Variable -------------------------------- */
var quill;
var lastpage;

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

/* ------------------------------- Load Div ------------------------------ */
function loadadminviewticket(url,form = 0){
	$.ajax({
		type	: "GET",
		url		: url,
		success	: function(html) {					
						$("#main_panel").html(html).show('slow');
						$('#update_div').scrollTop($('#update_div')[0].scrollHeight);
						if(form == 1){							
							$('#update_message').focus();   
						}
        },
        error : function (jqXHR, textStatus, errorThrown) {							
                window.location.href = '/1_atms/public/login';
        } //end function
  });//close ajax
}
function loadlistTicket(purl = "/1_atms/public/it/lt"){
	$.ajax({
		type		: "GET",
		url		: purl,
		success		: function(html) {					
						$("#main_panel").html(html).show('slow');
					},
					error : function (jqXHR, textStatus, errorThrown) {							
							window.location.href = '/1_atms/public/login';
					} //end function
  });//close ajax 
}
function loadcomingsoon(){
	$.ajax({
		type		: "GET",
		url		: "/1_atms/public/comingsoon",
		success		: function(html) {					
						$("#main_panel").html(html).show('slow');
					},
					error : function (jqXHR, textStatus, errorThrown) {							
							window.location.href = '/1_atms/public/login';
					} //end function
  });//close ajax 
}
function loadviewticket(url,form = 0){
	$.ajax({
		type	: "GET",
		url		: url,
		success	: function(html) {					
						$("#main_panel").html(html).show('slow');
						$('#update_div').scrollTop($('#update_div')[0].scrollHeight);
						if(form == 1){							
							$('#update_message').focus();   
						}
        },
        error : function (jqXHR, textStatus, errorThrown) {							
                window.location.href = '/1_atms/public/login';
        } //end function
  });//close ajax
}

function loadadminlistticket(purl = "/1_atms/public/it/al"){
	$.ajax({
		type		: "GET",
		url		: purl,
		success		: function(html) {					
						$("#main_panel").html(html).show('slow');
					},
					error : function (jqXHR, textStatus, errorThrown) {							
							window.location.href = '/1_atms/public/login';
					} //end function
  });//close ajax
}

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
					}/* ,
					error : function (jqXHR, textStatus, errorThrown) {							
							window.location.href = '/1_atms/public/login';
					} */ //end function
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

/* --------------------------- IT Menu tabs ---------------------------- */
$('#admin_it').on('click',function(){
  loadadminlistticket();
});
$('#myticket').on('click',function(){
  loadlistTicket();
});
$('#contact').on('click',function(){
  $.ajax({
		type		: "GET",
		url		: "/1_atms/public/it/cu",
		success		: function(html) {					
						$("#main_panel").html(html).show('slow');
					},
					error : function (jqXHR, textStatus, errorThrown) {							
							window.location.href = '/1_atms/public/login';
					} //end function
  });//close ajax
});
$('#cctv').on('click',function(){
  loadcomingsoon();
});

/* --------------------- HR Menu tabs -------------------------- */
$('#hr1').on('click',function(){
  loadcomingsoon();
});
$('#hr2').on('click',function(){
  loadcomingsoon();
});
$('#hr3').on('click',function(){
  loadcomingsoon();
});

/* ------------------------- PURCHASING Menu tabs --------------------------- */
$('#p1').on('click',function(){
  loadcomingsoon();
});
$('#p2').on('click',function(){
  loadcomingsoon();
});
$('#p3').on('click',function(){
  loadcomingsoon();
});

/* -------------------------- Admin List Ticket ----------------------------- */
$('#app').on('click','#ct_adminbutton',function(){
	$.ajax({
		type	: "GET",
		url		: "/1_atms/public/it/ac",
		success	: function(html) {					
				$("#main_panel").html(html).show('slow');
				initquill('test');
		},
		error : function (jqXHR, textStatus, errorThrown) {							
				window.location.href = '/1_atms/public/login';
		} //end function
	});//close ajax
});

/* -------------------------- Admin View Ticket ----------------------------- */

$('#app').on('click','#bc_adminviewticket',function(){
	loadadminlistticket(lastpage);
});
$('#app').on('click','.adminviewticket',function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	loadadminviewticket($(this).attr('href'));
});
$('#app').on('submit','#adminupdateform',function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	var id = $('#admin_update_ticket_id').val();
	$.ajax({
			type: $(this).attr('method'),
			url	: $(this).attr('action'),
			data: $('#adminupdateform').serialize(),
			datatype: 'JSON',       
			success: function(success_data) {
					iziToast.success({
							message: success_data,
							position: 'topCenter',
							timeout: 2000
					});
					loadadminviewticket('/1_atms/public/it/av/'+id,1);		     
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
$('#app').on('click','#assign_ticket',function(){
	$('#dd_assigned_to').show();
	$(this).hide();
});
$('#app').on('submit','#assign_tech',function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	var username = $('#assigned_to :selected').text();
	var user = $('#assigned_to').val();
	var val = $('#assign_to_ticketid').val();
	var dte = moment().format('YYYY-MM-DD HH:mm:ss');
	/* alert(moment().format('YYYY-MM-DD HH:mm:ss')); */
	/* alert($user +" || " + $val); */
	$.ajax({
		type: 'PUT',
		url	: '/1_atms/public/tickets/'+val,
		data: {
			"_token": $('meta[name="csrf-token"]').attr('content'),
			"assigned_to": user,
			"start_at": dte,
			"status_id": 2
		}, 
		datatype: 'JSON',       
		success: function(success_data) {
				iziToast.success({
						message: success_data,
						position: 'topCenter',
						timeout: 2000
				});
				loadadminviewticket('/1_atms/public/it/av/'+val);
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
$('#app').on('click','#bc_viewticket',function(){
	loadlistTicket(lastpage);
});

/* ----------------------------- List Ticket ------------------------------- */
$('#app').on('click','#ct_button',function(){
  $.ajax({
		type		: "GET",
		url		: "/1_atms/public/it/ct",
		success		: function(html) {					
						$("#main_panel").html(html).show('slow');
						initquill('test');
        },
        error : function (jqXHR, textStatus, errorThrown) {							
                window.location.href = '/1_atms/public/login';
        } //end function
  });//close ajax
});
$('#app').on('click','.viewticket',function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    loadviewticket($(this).attr('href'));
});

/* ----------------------- Create Ticket ---------------------- */
$('#app').on('submit','#createticketform',function(e){	
	e.preventDefault();
	e.stopImmediatePropagation();
	var desc = $('#message');
	desc.val(quill.root.innerHTML);
	$.ajax({
	type: "POST",
			url	: "/1_atms/public/tickets",
			data: $('#createticketform').serialize(),
			datatype: 'JSON',       
	success: function(success_data) {
					iziToast.success({
							message: success_data,
							position: 'topCenter',
							timeout: 2000
					});
					$('#createticketform').trigger('reset');
					quill.setContents([{ insert: '\n' }]);
					/* $("#main_panel").html(html).show('slow');   */                      
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

/* ----------------------- Pagination --------------------------- */
$('#app').on('click','#prevpage',function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	lastpage = $(this).attr('href');
	$.ajax({
	type	: "GET",
	url		: $(this).attr('href'),
			success	: function(html) {					
									$("#main_panel").html(html).show('slow');
							},
							error : function (jqXHR, textStatus, errorThrown) {							
											window.location.href = '/1_atms/public/login';
							} //end function
	});//close ajax
});
$('#app').on('click','#nextpage',function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	lastpage = $(this).attr('href');
	$.ajax({
	type	: "GET",
	url		: $(this).attr('href'),
			success	: function(html) {					
									$("#main_panel").html(html).show('slow');
							},
							error : function (jqXHR, textStatus, errorThrown) {							
											window.location.href = '/1_atms/public/login';
							} //end function
	});//close ajax
});
$('#app').on('click','.pagenumber',function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	lastpage = $(this).attr('href');
	$.ajax({
	type	: "GET",
	url		: $(this).attr('href'),
			success	: function(html) {					
									$("#main_panel").html(html).show('slow');
							},
							error : function (jqXHR, textStatus, errorThrown) {							
											window.location.href = '/1_atms/public/login';
							} //end function
	});//close ajax
});