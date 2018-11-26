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