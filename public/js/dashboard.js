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
function loadViewTicket(){
	$.ajax({
		type		: "GET",
		url		: "/1_atms/public/it/vt",
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

// IT Menu tabs
$('#myticket').on('click',function(){
  loadViewTicket();
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