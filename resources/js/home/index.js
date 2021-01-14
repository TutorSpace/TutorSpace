let colorHash = new ColorHash({
    hue: [ {min: 70, max: 90}, {min: 180, max: 210}, {min: 270, max: 285} ]
});

$.each($('.tag'), (idx, ele) => {
    var color = colorHash.rgb($(ele).html());

    var d = 0;
    // Counting the perceptive luminance - human eye favors green color...
    let luminance = ( 0.299 * color[0] + 0.587 * color[1] + 0.114 * color[2])/255;

    if (luminance > 0.5)
        d = 0; // bright colors - black font
    else
        d = 255; // dark colors - white font

    $(ele).css("background-color", `rgb(${color[0]}, ${color[1]}, ${color[2]})`);
    $(ele).css("color", `rgb(${d}, ${d}, ${d})`);
});


// upload photo
$('#upload-profile-pic').click(function() {
    $('#input-profile-pic').click();
});

$("#input-profile-pic").change(function() {
    var fileInput = $(this)[0];
    var file = fileInput.files[0];
    var formData = new FormData();
    formData.append('profile-pic', file);

    JsLoadingOverlay.show(jsLoadingOverlayOptions);
    $.ajax({
        type: 'POST',
        url: $('#profile-pic-form').attr('action'),
        data: formData,
        contentType: false,
        processData: false,
        success: (data) => {
            toastr.success('Successfully uploaded the image!');
            $('#profile-image').attr('src', storageUrl + data.imgUrl);
            $('.nav-right__profile-img').attr('src', storageUrl + data.imgUrl);
        },
        error: function(error) {
            toastr.error('Something went wrong. Please try again.');
            console.log(error);
        },
        complete: () => {
            JsLoadingOverlay.hide();
        }
    });
});


// calendar
window.showAvailableTimeForm = (startTime, endTime) => {
    $('#availableTimeConfirmationModal input[name="start-time"]').val(moment(startTime).format("YYYY-MM-DD HH:mm:00"));
    $('#availableTimeConfirmationModal input[name="end-time"]').val(moment(endTime).format("YYYY-MM-DD HH:mm:00"));

    startTime = moment(startTime).format("HH:mm on MM/DD/YYYY dddd");
    endTime = moment(endTime).format("HH:mm on MM/DD/YYYY dddd");


    $('#availableTimeConfirmationModal .start-time').html(startTime);
    $('#availableTimeConfirmationModal .end-time').html(endTime);
    $('#availableTimeConfirmationModal').modal('show');
}

window.showAvailableTimeDeleteForm = (startTime, endTime, availableTimeId) => {
    $('#availableTimeDeleteConfirmationModal input[name="available-time-id"]').val(availableTimeId);

    startTime = moment(startTime).format("HH:mm on MM/DD/YYYY dddd");
    endTime = moment(endTime).format("HH:mm on MM/DD/YYYY dddd");


    $('#availableTimeDeleteConfirmationModal .start-time').html(startTime);
    $('#availableTimeDeleteConfirmationModal .end-time').html(endTime);
    $('#availableTimeDeleteConfirmationModal').modal('show');
}

$('.action-toggle').click(function() {
    $(this).next('.action-toggle__content').toggle();
});


// tutor request popup
$('.btn-view-request').click(function() {
    $('.home__tutor-request-modal .tutor-request-modal__content__profile .user-info .content').text($(this).closest('.info-box').find('.user-info .content').text());
    $('.home__tutor-request-modal .tutor-request-modal__content__profile .date .content').text($(this).closest('.info-box').find('.date .content').text());
    $('.home__tutor-request-modal .tutor-request-modal__content__profile .time .content').text($(this).closest('.info-box').find('.time .content').text());
    $('.home__tutor-request-modal .tutor-request-modal__content__profile .course .content').text($(this).closest('.info-box').find('.course .content').text());
    $('.home__tutor-request-modal .tutor-request-modal__content__profile .session-type .content').text($(this).closest('.info-box').find('.session-type .content').text());
    $('.home__tutor-request-modal .tutor-request-modal__content__profile .price .content').text($(this).closest('.info-box').find('.price .content').text());

    $('#btn-confirm-tutor-session').attr('data-tutorRequest-id', $(this).closest('.info-box').attr("data-tutorRequest-id"));
    $('#btn-decline-tutor-session').attr('data-tutorRequest-id', $(this).closest('.info-box').attr("data-tutorRequest-id"));

    $('.home__tutor-request-modal').toggle();

    let options = JSON.parse(JSON.stringify(calendarPopUpOptions));

    options.slotMinTime = $(this).closest('.info-box').attr('data-min-time');
    options.slotMaxTime = $(this).closest('.info-box').attr('data-max-time');

    let sessionTimeStart = $(this).closest('.info-box').attr('data-session-time-start');
    let sessionTimeEnd = $(this).closest('.info-box').attr('data-session-time-end');

    options.events.push({
        title: 'Current Tutor Request',
        classNames: ['tutor-request'],
        start: sessionTimeStart,
        end: sessionTimeEnd,
        description: "",
        type: "tutor-request",
    });

    options.height = 250;

    options.displayEventTime = false;

    // for the calendar in tutor request
    let calendarElPopUp = $('.tutor-request-modal__content__calendar .calendar')[0];

    calendarPopUp = new FullCalendar.Calendar(calendarElPopUp, options);

    calendarPopUp.render();
    calendarPopUp.gotoDate($(this).closest('.info-box').attr('data-date'));
})

$('.tutor-request-modal__close').click(function() {
    $('.home__tutor-request-modal').toggle();
})



$('.btn-view-all-notifications').click(function() {
    $(this).closest('.home__side-bar__notifications').find('.notifications--sidebar [data-to-hide="true"]').toggleClass("hidden");
    if($(this).html().includes('View')) {
        $(this).html('Hide')
    }
    else {
        $(this).html('View All')
    }
});

$('.btn-view-all-bookmarked-users').click(function() {
    $('.home__side-bar__bookmarked-users').find('.bookmarked-users [data-to-hide="true"]').toggleClass("hidden");
    if($(this).html().includes('View')) {
        $(this).html('Hide')
    }
    else {
        $(this).html('View All')
    }
});


$('#btn-confirm-tutor-session').click(function() {
    var tutorRequestId = $(this).attr("data-tutorRequest-id");

    JsLoadingOverlay.show(jsLoadingOverlayOptions);
    $.ajax({
        type: 'POST',
        url: `/tutor-request/accept/${tutorRequestId}`,
        success: function success(data) {
            let { successMsg, errorMsg } = data;
            if(successMsg) {
                toastr.success(successMsg);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
            else if(errorMsg) toastr.error(errorMsg);
        },
        error: (error) => {
            console.log(error);
            toastr.error("Something went wrong when accepting the tutor request.");
        },
        complete: () => {
            JsLoadingOverlay.hide();
        }
    });
})

$('#btn-decline-tutor-session').click(function() {
    var tutorRequestId = $(this).attr("data-tutorRequest-id");

    JsLoadingOverlay.show(jsLoadingOverlayOptions);
    $.ajax({
        type: 'DELETE',
        url: `/tutor-request/${tutorRequestId}`,
        success: function success(data) {
            let { successMsg, errorMsg } = data;
            if(successMsg) {
                toastr.success(successMsg);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
            else if(errorMsg) toastr.error(errorMsg);
        },
        error: (error) => {
            console.log(error);
            toastr.error("Something went wrong when declining the tutor request.");
        },
        complete: () => {
            JsLoadingOverlay.hide();
        }
    });
})


