if(!window.Notification){
    alert('Sorry, notifications are not supported')
} 
else {
    /* Notification.requestPermission(function (p) {
        if(p === 'denied'){
            alert('You have denied notifications.');
        }
        else if (p === 'granted'){
            alert('You have granted notifications.');
        }
    }); */
    Notification.requestPermission().then(function(result) {
        console.log(result);
      });
}