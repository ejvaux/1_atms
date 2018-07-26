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

// Menu tabs
$('#myticket').on('click',function(){
  $.ajax({
		type		: "GET",
		url		: "/1_atms/public/it/vt",
		success		: function(html) {					
						$("#main_panel").html(html).show('slow');
					} //end function
  });//close ajax 
});

$('#createticket').on('click',function(){
  $.ajax({
		type		: "GET",
		url		: "/1_atms/public/it/ct",
		success		: function(html) {					
						$("#main_panel").html(html).show('slow');
					} //end function
  });//close ajax
});

$('#contact').on('click',function(){
  $.ajax({
		type		: "GET",
		url		: "/1_atms/public/it/cu",
		success		: function(html) {					
						$("#main_panel").html(html).show('slow');
					} //end function
  });//close ajax
});