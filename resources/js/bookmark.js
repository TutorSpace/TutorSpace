$('svg.bookmark').click(function() {
    let url;
    // if the user is bookmarked
    if($(this).hasClass('bookmark-marked')) {
        url = '/bookmark_remove';
    }
    else {
        url = '/bookmark_add';
    }

    $.ajax({
        type:'GET',
        url: url,
        data: {
            user_id: $(this).attr('data-user-id')
        },
        success: (data) => {
            $(this).toggleClass('bookmark-marked');
            let { successMsg } = data;
            toastr.success(successMsg);
        },
        error: function(error) {
            toastr.error(error);
        }
    });


});

