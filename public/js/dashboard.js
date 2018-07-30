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
					}/* ,
					error : function (jqXHR, textStatus, errorThrown) {							
							window.location.href = '/1_atms/public/login';
					} */ //end function
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