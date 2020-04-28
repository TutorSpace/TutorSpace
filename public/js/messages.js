// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('4617c13957e71ba6c650', {
  cluster: 'us3'
});

var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
  alert(JSON.stringify(data));
});
