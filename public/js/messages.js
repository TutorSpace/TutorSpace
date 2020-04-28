$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('4617c13957e71ba6c650', {
    cluster: 'us3'
    });

    var channel = pusher.subscribe('chatting-channel');
    channel.bind('new-message', function(data) {
        alert(JSON.stringify(data));
    });




})
