function scrollToBottom() {
    $('.chatting__content__messages').scrollTop($('.chatting__content__messages')[0].scrollHeight);
}

function appendSendMsgFunc() {
    // sending messages
    $('#msg-form').submit(function() {
        if($('#msg-to-send').val()) {
            $.ajax({
                type:'POST',
                url: '/chatting/send-msg',
                data: $('#msg-form').serialize(),
                success: (data) => {
                    console.log(data);
                }
            });
        }
        return false;
    });
}

function appendMyMessage() {
    // append my own message
    let el = `<div class="message message--self">
        <div class="time-container">
            Now
        </div>
        <div class="message-content-container">
            ${$('#msg-to-send').val()}
        </div>
    </div>`;

    $('.chatting__content__messages').append(el);
    scrollToBottom();

    $('#msg-to-send').val('');
}

$('.msg').click(function() {
    $('.msg .box').removeClass('bg-grey-light');
    $(this).find('.box').addClass('bg-grey-light');

    $.ajax({
        type:'GET',
        url: '/chatting/get-messages',
        data: {
            'userId': $(this).attr('data-user-id')
        },
        success: (data) => {
            $(this).removeClass('unread');
            $('.chatting__content').html(data);
            scrollToBottom();
            appendSendMsgFunc();
        }
    });
});


// ================= for chatting =======================
var pusher = new Pusher('d8a4fc3115898457a40f', {
    cluster: 'us3',
    authEndpoint: '/broadcasting/auth',
    encrypted: true,
    auth: {
        headers: {
            'X-CSRF-Token': $("meta[name=csrf-token]").attr('content')
        }
    }
});

var channel = pusher.subscribe('private-message.1-2');
channel.bind('NewMessage', function(data) {
    alert(JSON.stringify(data));
});
