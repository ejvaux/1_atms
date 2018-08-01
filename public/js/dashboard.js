// Alerts
function notifalert(type,msg){
  if(type=='success'){
    iziToast.success({
      title: 'System',
      message: msg,
      position: 'topCenter'
    });
  }
}

// Accordion
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

// Load Div
function loadlistTicket(){
	$.ajax({
		type		: "GET",
		url		: "/1_atms/public/it/lt",
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
function loadviewticket(url){
	$.ajax({
		type	: "GET",
		url		: url,
		success	: function(html) {					
						$("#main_panel").html(html).show('slow');
						$('#update_div').scrollTop($('#update_div')[0].scrollHeight);
        },
        error : function (jqXHR, textStatus, errorThrown) {							
                window.location.href = '/1_atms/public/login';
        } //end function
  });//close ajax
}

// Home Menu tabs
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

// IT Menu tabs
$('#admin_it').on('click',function(){
  loadcomingsoon();
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

// HR Menu tabs
$('#hr1').on('click',function(){
  loadcomingsoon();
});
$('#hr2').on('click',function(){
  loadcomingsoon();
});
$('#hr3').on('click',function(){
  loadcomingsoon();
});

// PURCHASING Menu tabs
$('#p1').on('click',function(){
  loadcomingsoon();
});
$('#p2').on('click',function(){
  loadcomingsoon();
});
$('#p3').on('click',function(){
  loadcomingsoon();
});

// View Ticket
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
					loadviewticket('/1_atms/public/it/vt/'+id);               
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
	loadlistTicket();
});

// List Ticket
$('#app').on('click','#ct_button',function(){
  $.ajax({
		type		: "GET",
		url		: "/1_atms/public/it/ct",
		success		: function(html) {					
            $("#main_panel").html(html).show('slow');
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

// Create Ticket
$('#app').on('submit','#createticketform',function(e){	
	e.preventDefault();
	e.stopImmediatePropagation();
 
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

// Pagination
$('#app').on('click','#prevpage',function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
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