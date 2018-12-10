{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TEST NOTIF</title>
</head>
<body>
    <a href="#" id='rp'>Request Permission</a>
    <a href="#" id='tri'>Trigger</a>
    <script>
        var rp = document.getElementById('rp');
        var tri = document.getElementById('tri');

        rp.addEventListener('click', function(e) {
            e.preventDefault();

            if(!window.Notification){
                alert('Sorry, notifications are not supported')
            } 
            else {
                Notification.requestPermission(function (p) {
                    if(p === 'denied'){
                        alert('You have denied notifications.');
                    }
                    else if (p === 'granted'){
                        alert('You have granted notifications.');
                    }
                });
            }
        });

        // simulate an event
        tri.addEventListener('click', function(e){
            var notify;
            e.preventDefault();

            if(Notification.permission === 'default'){
                alert('Please allow notifications before doing this.')
            }
            else{
                notify = new Notification('Message alert.',{
                    body: 'This is the body.',
                    icon: 'http://localhost/1_atms/public/images/ptpi.png'
                });
            }
        });
        const wait = time => new Promise((resolve) => setTimeout(resolve, time));

        wait(3000).then(() => console.log('Hello!')); // 'Hello!' --}}

        /* if('serviceWorker' in navigator){
            navigator.serviceWorker
                .register('http://localhost/1_atms/sw.js', { scope: 'http://localhost/1_atms/' })
                .then(function(registration){
                    console.log('Service Worker Registered');                
                })
                .catch(function(err){
                    console.log('Service worker failed to register', err);
                })
        } */
        /* if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('http://localhost/1_atms/sw.js').then(function(registration) {
                // Registration was successful
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                // registration failed :(
                console.log('ServiceWorker registration failed: ', err);
                });
        });
        } */
    </script>
</body>
</html>