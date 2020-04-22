function fitProfileImgHeight() {
    let imgContainer = $('.about__information__img .img-container');
    var currentWidth = imgContainer.width();
    imgContainer.height(currentWidth);

}

$(document).ready(fitProfileImgHeight);

var $window = $(window).on('resize', fitProfileImgHeight).trigger('resize'); //on page load

// The tags do not need to be in the database. The autocomplete is just for recommendation
$(function () {
    var subjectTags = [
        'Calculus',
        'Mathematics',
        'Ling',
        'Business',
        'Accounting',
        'Computer Science',
        'Physics'
    ];
    $("#subject").autocomplete({
        source: subjectTags
    });


    var courseTags = [
        'EALC 150',
        'CSCI 103',
        'COMM 201',
        'BUAD 304',
        'ECON 351',
        'ECON 352'
    ];
    $("#course").autocomplete({
        source: courseTags
    });

    var characteristicTags = [
        'Friendly',
        'Patient',
        'Hospital',
        'Lovely',
        'Cute'
    ];
    $("#characteristic").autocomplete({
        source: characteristicTags
    });

});




$('.profile-nav > .nav-link').click(function() {
    for(let i = 0; i < $('.profile-nav').children().length; i++) {
        $('.profile-nav').children().eq(i).removeClass('active');
        $('.about__container').hide();
        $('.sessions__container').hide();
        $('.saved__container').hide();
        $('.reviews__container').hide();
    }

    $(this).toggleClass('active');

    if($(this)[0].id === 'nav-about') {
        $('.about__container').show();
    }
    else if($(this)[0].id === 'nav-sessions') {
        $('.sessions__container').show();
    }
    else if($(this)[0].id === 'nav-saved') {
        $('.saved__container').show();
    }
    else if($(this)[0].id === 'nav-reviews') {
        $('.reviews__container').show();
    }
});


// select all "view session button" from the upcoming section
$('.sessions__container-1 .session__container > button:last-child').click(function() {
    window.location.href = '/view_session_before';
});


// select all "view session button" from the past section
$('.sessions__container-2 .session__container > button:last-child').click(function() {
    window.location.href = '/view_session_after';
});





$( ".about__content .about__input" ).focusin(function() {
    $(this).prev().css('fill', '#2C86C4');
});

$( ".about__content .about__input" ).focusout(function() {
    $(this).prev().css('fill', 'grey');
});


$('#about__buttons__container--subjects button svg').click(removeSubject);
$('#about__buttons__container--courses button svg').click(removeCourse);
$('#about__buttons__container--characteristics button svg').click(removeCharacteristic);



function removeSubject() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let subjectId = $(this).parent().attr('data-subject-id');

    $.ajax({
        type:'POST',
        url: `/remove_fav_subject`,
        data: {
            subject_id: subjectId
        },
        success: (data) => {
            let { successMsg } = data;
            toastr.success(successMsg);
            $(this).parent().remove();
        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });
}

function removeCourse() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let courseId = $(this).parent().attr('data-course-id');

    $.ajax({
        type:'POST',
        url: `/remove_fav_course`,
        data: {
            course_id: courseId
        },
        success: (data) => {
            let { successMsg } = data;
            toastr.success(successMsg);
            $(this).parent().remove();
        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });
}

function removeCharacteristic() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let characteristicId = $(this).parent().attr('data-characteristic-id');

    $.ajax({
        type:'POST',
        url: `/remove_characteristic`,
        data: {
            characteristic_id: characteristicId
        },
        success: (data) => {
            let { successMsg } = data;
            toastr.success(successMsg);
            $(this).parent().remove();
        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });
}


// for bookmarks
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
            $(this).parent().parent().remove();

            if($('.search-card-container').children().length === 0) {
                $('.search-card-container').append('<span class="f-16">You have not saved any tutors yet</span>');
            }
        },
        error: function(error) {
            toastr.error(error);
        }
    });
});

$('.search-card img').click(function() {
    window.location.href = '/view_profile/' + $(this).attr('data-user-id');
});


// cancel session
$('.sessions__container-1 .session__container > button:not(:last-child)').click(function () {
    let sessionId = $(this).attr('data-session-id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url: `/session_cancel`,
        data: {
            session_id: sessionId
        },
        success: (data) => {
            let { successMsg } = data;
            toastr.success(successMsg);
            $(this).parent().remove();
            // because there is a "shadow-container always inside"
            if($('.upcoming-sessions-container').children().length === 1) {
                $('.upcoming-sessions-container').append('<span class="f-16">Scheduled sessions between you and a student will appear below.</span>');
            }

        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });

});

let sessionId;
let sessionContainer;

// for writing review
$('.btn-write-review').click(function() {
    $('#background-cover').height(document.documentElement.scrollHeight);
    $('#background-cover').width(document.documentElement.scrollWidth);
    $('#background-cover').show();

    let centerOffset = (document.documentElement.scrollHeight - $(window).height()) / 2;
    $('html,body').animate({
            scrollTop: centerOffset
        },
        'slow'
    );

    $('#write-review-container').height($(window).height() / 2);

    sessionId = $(this).attr('data-session-id');

    let reviewContainer = $('#write-review-container');

    let isTutor = $('#profile-container').attr('data-is-tutor');
    let currentUserName = $('#currentUserName').html();
    let selectedUserName = $(this).parent().find('.name').html();

    let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    let date = new Date($(this).parent().find('.date').html());
    date = new Intl.DateTimeFormat('en-US', options).format(date);

    let subjectCourse = $(this).parent().find('.subject-course').html();

    if(isTutor) {
        reviewContainer.find('.tutor-name').html(currentUserName);
        reviewContainer.find('.student-name').html(selectedUserName);
    }
    else {
        reviewContainer.find('.tutor-name').html(selectedUserName);
        revviewContainer.find('.student-name').html(currentUserName);
    }
    reviewContainer.find('.review-header').html('Review ' + selectedUserName + ': ');
    reviewContainer.find('.date').html(date);
    reviewContainer.find('.subject-course').html(subjectCourse);

    sessionContainer = $(this).parent();
});


// cancel button for post
$('#write-review-container .btn-cancel').click((e) => {
    e.preventDefault();
    $('#background-cover').hide();
});


// add review
$('#write-review-container').submit((e) => {
    e.preventDefault();

    let reviewMsg = $('#review-content').val();
    let rating = 0;
    $('#write-review-container .star-container').children().each(function() {
        console.log($(this)[0]);
        let use = $(this).find('use');
        if(use.attr('xlink:href') === starFilled)
            rating += 1
    });

    if(!reviewMsg || reviewMsg.trim().length === 0) {
        toastr.warning('Please enter review content!');
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $.ajax({
        type:'POST',
        url: '/post_review',
        data: {
            reviewMsg: reviewMsg,
            rating: rating,
            sessionId: sessionId
        },
        success: (data) => {
            console.log(data);
            let { successMsg } = data;
            toastr.success(successMsg);

            $('#background-cover').hide();

            sessionContainer.remove();

            if($('.sessions__container-2 .sessions__info').children().length === 0) {
                $('.sessions__container-2 .sessions__info').append('<span class="f-16">There are no past sessions yet</span>');
            }
        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });
});


let starFilled = $('#star-filled > use').attr('xlink:href');
let starOutlined = $('#star-outlined > use').attr('xlink:href');

// adding effects on the star ratings
$('.star-rating-container svg').hover(function() {
    $(this).find('use').attr('xlink:href', starFilled);

    $(this).prevAll().find('use').attr('xlink:href', starFilled);

    $(this).nextAll().find('use').attr('xlink:href', starOutlined);
});


$('.reviews-table img').click(function() {
    window.location.href = '/view_profile/' + $(this).attr('data-user-id') + '?from=profile';
});
