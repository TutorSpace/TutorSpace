$(window).click(function() {
    //Hide the menus if visible
    $('.action--toggle--list').removeClass("d-flex");
    $('.action--toggle--list').addClass("d-none");
});

$('.action--toggle').on('click', function(event) {
    event.stopPropagation();
    $('.action--toggle--list').removeClass("d-flex");
    $('.action--toggle--list').addClass("d-none");
    $(this).find('.action--toggle--list').removeClass("d-none");
    $(this).find('.action--toggle--list').addClass("d-flex");
});

$('.action-refund').click(function() {
    $.ajax({
        type: 'POST',
        url: $(this).closest('.info-box').attr('data-route-url'),
        success: (data) => {
            toastr.success(data.successMsg);
            console.log(data);
        },
        error: function(error) {
            toastr.error('Something went wrong. Please try again.');
            console.log(error);
        }
    });
});
