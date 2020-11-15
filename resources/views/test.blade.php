<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('d8a4fc3115898457a40f', {
        cluster: 'us3',
        authEndpoint: '/broadcasting/auth',
        encrypted: true,
        auth: {
            headers: {
                'X-CSRF-Token': "{{ csrf_token() }}"
            }
        }
    });

    var channel = pusher.subscribe('private-message.1-2');
    channel.bind('NewMessage', function(data) {
        alert("here");
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
