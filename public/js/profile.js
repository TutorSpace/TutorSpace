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
        'HTML/CSS',
        'Calculus',
        'Algebra',
        'Chemistry',
        'Biology',
        'Computer Science',
        'Computer Security',
        'Writing',
        'French',
        'Economics',
        'International Relations',
        'Art History',
        'Psychology',
        'Linguistics',
        'Design',
        'Mathematics',
        'UX/UI Design',
        'Korean',
        'DSP',
        'Backend',
        'Backend Development',
        'Robotics',
        'Python'
    ];
    $("#subject").autocomplete({
        source: subjectTags
    });


    var courseTags = [
        'ITP 104',
        'ITP 115',
        'ITP 125',
        'ITP 301',
        'ITP 304',
        'ITP 325',
        'CSCI 103',
        'CSCI 104',
        'MATH 125',
        'MATH 225',
        'MATH 245',
        'ECON 203',
        'ECON 205',
        'WRIT 150',
        'WRIT 340',
        'PSYC 100',
        'MUSC 255',
        'LING 210',
        'LING 115',
        'FREN 220',
        'DES 302',
        'IR 210',
        'AHIS 230',
        'BISC 120',
        'BISC 220',
        'CRIT 150',
        'CTWR 412',
        'COMM 104',
        'AME 201',
        'AME 301',
        'SFA 111',
        'EALC 150',
        'CTWR 411',
        'DES 102',
        'CRIT 350',
        'EE 243',
        'MATH 114',
        'BUAD 304',
        'ITP 303',
        'CSCI 201',
        'CSCI 360',
        'ITP 380',
        'CSCI 170',
        'CSCI 270'
    ];
    $("#course").autocomplete({
        source: courseTags
    });

    var characteristicTags = [
        'Friendly',
        'Patient',
        'Hospital',
        'Lovely',
        'Cute',
        'Attentive',
        'Enthusiastic',
        'Responsible',
        'Hilarious',
        'Caring',
        'Outgoing',
        'Lovely Boy!',
        'Extroverted',
        'Hardworking'
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
    window.location.href = `/view_session/${$(this).attr('data-session-id')}?from=profile`;
});


// select all "view session button" from the past section
$('.sessions__container-2 .session__container > button:last-child').click(function() {
    window.location.href = `/view_session/${$(this).attr('data-session-id')}?from=profile`;
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
    window.location.href = '/view_profile/' + $(this).attr('data-user-id') + '?from=profile';
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

    // $('#write-review-container').height($(window).height() / 2);

    sessionId = $(this).attr('data-session-id');

    let reviewContainer = $('#write-review-container');

    let isTutor = $('#profile-container').attr('data-is-tutor');
    let currentUserName = $('#currentUserName').html();
    let selectedUserName = $(this).parent().find('.name').html();

    let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    let date = new Date($(this).parent().find('.date').html());
    date = new Intl.DateTimeFormat('en-US', options).format(date);

    let subjectCourse = $(this).parent().find('.subject-course').html();

    if(isTutor == 1) {
        reviewContainer.find('.tutor-name').html(currentUserName);
        reviewContainer.find('.student-name').html(selectedUserName);
    }
    else {
        reviewContainer.find('.tutor-name').html(selectedUserName);
        reviewContainer.find('.student-name').html(currentUserName);
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
    $('textarea').val('');
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
            $('textarea').val('');

            // dont remove the past session after reviewing it!

            // sessionContainer.remove();

            // if($('.sessions__container-2 .sessions__info').children().length === 0) {
            //     $('.sessions__container-2 .sessions__info').append('<span class="f-16">There are no past sessions yet</span>');
            // }
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
