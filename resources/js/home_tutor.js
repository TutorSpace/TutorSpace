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


$('.home__tutor-requests tr').click(function() {
    let studentId = $(this).parent().parent().attr('data-student-id');
    window.location.href = "/messages/" + studentId;
});


let calendar;

let startTime;
let endTime;
let date;

function getMinutesFormat(date) {
    if (date.getMinutes() < 10) {
        return "0" + date.getMinutes();
    }
    return date.getMinutes();
}

function showForm(info) {
    startTime = startTime.yyyymmdd() + " " + startTime.getHours() + ":" + getMinutesFormat(startTime);
    endTime = endTime.yyyymmdd() + " " + endTime.getHours() + ":" + getMinutesFormat(endTime);

    $('#start-time').html(startTime);
    $('#end-time').html(endTime);

    $('#background-cover-3').height(document.documentElement.scrollHeight);
    $('#background-cover-3').width(document.documentElement.scrollWidth);
    $('#background-cover-3').show();

    let centerOffset = (document.documentElement.scrollHeight - $(window).height()) / 2;
    $('html,body').animate({
            scrollTop: centerOffset
        },
        'slow'
    );
}

$('.btn-cancel').click(function () {
    $('#background-cover-3').hide();
});

$('.btn-submit').click(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: `/edit_availability`,
        data: {
            startTime: startTime,
            endTime: endTime
        },
        success: (data) => {
            let {
                successMsg
            } = data;
            toastr.success(successMsg);

            window.location.href = '/home';
        },
        error: function (error) {
            console.log(error);
            toastr.error(error);
        }
    });
});
