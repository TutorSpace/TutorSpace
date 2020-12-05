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

$('.msg').click(function() {
    $('.msg .box').removeClass('bg-grey-light');
    $(this).find('.box').addClass('bg-grey-light');
    let otherUserId = $(this).attr('data-user-id');
    $.ajax({
        type:'GET',
        url: '/chatting/get-messages',
        data: {
            'userId': otherUserId
        },
        success: (data) => {
            $(this).removeClass('unread');
            $('.chatting__content').html(data);
            scrollToBottom();
            appendSendMsgFunc();
        }
    });

    // subscribe to the channel
    let channelName = currentUserId < otherUserId ? `private-message.${currentUserId}-${otherUserId}` : `private-message.${otherUserId}-${currentUserId}`;
    var channel = pusher.subscribe(channelName);
    channel.bind('NewMessage', function(data) {
        let {from, to, message, created_at} = data;
        let currentlyViewingId = $('.msg .box').closest('.msg').attr('data-user-id');

        let currentViewing = currentlyViewingId == from || currentlyViewingId == to;

        if(currentViewing) {
            if(from == currentlyViewingId && to == currentUserId) {
                appendOtherMessage(message, 'Now');
            } else if(from == currentUserId && to == currentlyViewingId) {
                appendMyMessage(message, 'Now');
            }
            scrollToBottom();


        } else {
            // todo: upadte the unread status accordingly
        }

        let otherUserId = from == currentUserId ? to : from;
        $(`.msg[data-user-id=${otherUserId}] .content-2`).html(message);
        $(`.msg[data-user-id=${otherUserId}] .time`).html('Now');
    });
});


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
            // appendMyMessage($('#msg-to-send').val(), 'Now');
            $('#msg-to-send').val('');
        }
        return false;
    });
}

function appendMyMessage(message, time) {
    // append my own message
    let el =
    `<div class="message message--self">
        <div class="time-container">
            ${time}
        </div>
        <div class="message-content-container">
            ${message}
        </div>
    </div>`;

    $('.chatting__content__messages').append(el);
}

function appendOtherMessage(message, time) {
    // append other's message
    let el =
    `<div class="message message--other">
        <div class="img-container">
            <img src="${$('.message--other img').attr('src')}" alt="user img">
        </div>
        <div class="message-content-container">
            <span class="content">
                ${message}
            </span>
        </div>
        <div class="time-container">
            ${time}
        </div>
    </div>`;

    $('.chatting__content__messages').append(el);
}



