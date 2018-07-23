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

// Create ticket form
/* $('#createticketform').on('submit', function (e) {
  e.preventDefault();
  e.stopImmediatePropagation();

  $.ajax({
    type: 'POST',
    url: "/1_tms/public/tickets",
    data: $('#createticketform').serializeArray(),    
    dataType: 'json',
    success: function (data) {
      if(data){
        $('#main_panel').load('/1_tms/public/ct'); 
      }       
    }
  }); 
  
}); */ // Create ticket form

// Load Tabs

/* $('#myticket').on('click', function(){
  $('#main_panel').load('/1_tms/public/vt');
});

$('#createticket').on('click', function(){
  $('#main_panel').load('/1_tms/public/ct');
}); */