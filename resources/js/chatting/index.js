$('.msg:first-child .box').addClass('bg-grey-light');

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
            $('.chatting__content').html(data);
        }
    });
});


