const { success } = require("toastr");

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

    $.ajax({
        type:'POST',
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
        }
    });
});

if ($('.bookmarked-tutors').prop('scrollHeight') > $('.bookmarked-tutors').prop('clientHeight')) {
    //if 'true', the content overflows the tab: we show the hidden link
    $('.bookmarked-tutors + .scroll-faded').css('display', 'block');
}

if ($('.tutor-requests').prop('scrollHeight') > $('.tutor-requests').prop('clientHeight')) {
    //if 'true', the content overflows the tab: we show the hidden link
    $('.tutor-requests + .scroll-faded').css('display', 'block');
}

if ($('.info-cards').prop('scrollHeight') > $('.info-cards').prop('clientHeight')) {
    //if 'true', the content overflows the tab: we show the hidden link
    $('.info-cards + .scroll-faded').css('display', 'block');
}

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
    $('.home__tutor-request-modal').toggle();
    calendarPopUp.render();
})

$('.tutor-request-modal__close').click(function() {
    $('.home__tutor-request-modal').toggle();
})
