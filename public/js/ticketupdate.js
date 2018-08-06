function ticket_update_checker(){
    
    /* alert('Boom!'); */
    
    /* $.ajax({
        type: 'POST',
        url: '/1_mes/_query/checktoken.php',
        global:false,
        success: function (data) {
          if(data=="success"){
            if(localStorage.getItem("disconnect_message") == 1){                
  
              iziToast.info({
                title: 'NOTICE:',
                message: 'Reconnected to Database Server',
                titleSize: '20px',
                messageSize: '18px',
                transitionIn: 'fadeInLeft',
                transitionOut:	'fadeOutRight',
                timeout: 10000
            });

              localStorage.setItem("disconnect_message",0);
            }
            localStorage.setItem("disconnect_message",0);
            $('#con').css('color', 'green');
            return;
          }
          else if(data=="nothing"){

              if(localStorage.getItem("disconnect_message") == 1){                
  
                iziToast.info({
                  title: 'NOTICE:',
                  message: 'Reconnected to Database Server',
                  titleSize: '20px',
                  messageSize: '18px',
                  transitionIn: 'fadeInLeft',
                  transitionOut:	'fadeOutRight',
                  timeout: 10000
              });

                localStorage.setItem("disconnect_message",0);
              }

              $('#con').css('color', 'green');
              return;
          }
          else if(data=="failed"){
            alert('A device logged in using your account. If you find this unusual please contact the system administrator immediately. ');            
            window.location.href='/1_mes/';            
                       
          }
          else{

              if(localStorage.getItem("disconnect_message") === null){
                localStorage.setItem("disconnect_message",0);
              }
              else{
                if(localStorage.getItem("disconnect_message") == 0){                
  
                  iziToast.error({
                    title: 'WARNING:',
                    message: 'Disconnected from Database Server',
                    titleSize: '20px',
                    messageSize: '18px',
                    transitionIn: 'fadeInLeft',
                    transitionOut:	'fadeOutRight',
                    timeout: 10000
                });
  
                  localStorage.setItem("disconnect_message",1);
                }
              }              
              $('#con').css('color', 'red');
              
          }        
        }
      }); */

    setTimeout(ticket_update_checker,1*1000);

  }

  ticket_update_checker();