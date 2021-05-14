<!DOCTYPE html>

<head>
     <title>Pusher Test</title>
     <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
     <script>
     // Enable pusher logging - don't include this in production
     Pusher.logToConsole = true;

     var pusher = new Pusher('413ecacd820970cac574', {
          cluster: 'ap2'
     });

     var channel = pusher.subscribe('my-channel');
     channel.bind('App\\Events\\MyEvent', function(data) {
          console.log(data)
          alert(JSON.stringify(data));
     });
     </script>
</head>

<body>
     <h1>Pusher Test</h1>
     <p>
          Try publishing an event to channel <code>my-channel</code>
          with event name <code>my-event</code>.
     </p>
</body>