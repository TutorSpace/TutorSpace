// accept tutor request
$('.tutor-requests-table button:last-child').click(function(e) {
    e.stopPropagation();

    let tutorRequestId = $(this).attr('data-tutor-request-id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url: '/tutor_request_accept',
        data: {
            tutor_request_id: tutorRequestId
        },
        success: (data) => {
            if(data.errorMsg) {
                toastr.error(data.errorMsg);
            }
            else {
                toastr.success(data.successMsg);
            }
            window.location.href = '/home';

        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });
});

// reject tutor request
$('.tutor-requests-table button:not(:last-child)').click(function(e) {
    e.stopPropagation();

    let tutorRequestId = $(this).attr('data-tutor-request-id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url: '/tutor_request_reject',
        data: {
            tutor_request_id: tutorRequestId
        },
        success: (data) => {
            toastr.success(data.successMsg);
            window.location.href = '/home';
        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });
});


$('.home__tutor-requests tr').click(() => {
    alert('TODO: go to messages page and view the request');
});


