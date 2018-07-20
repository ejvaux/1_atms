$('#createticketform').on('submit', function (e) {
  e.preventDefault();
  e.stopImmediatePropagation();

  $.ajax({
    type: 'POST',
    url: "action('TicketsController@store')",
    data: $('#createticketform').serializeArray(),
    success: function (data) {         
      if(data==true){
        $('#createticketform').trigger('reset');
        
        iziToast.success({
          title: 'OK',
          message: 'Successfully inserted record!',
        });
      }
      else{
        alert(data);          
      }
    }
  }); 
  
});