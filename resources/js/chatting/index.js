function scrollToBottom() {
    $('.chatting__content__messages').scrollTop($('.chatting__content__messages')[0].scrollHeight);
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
        }
    });
});


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
    return false;
});
