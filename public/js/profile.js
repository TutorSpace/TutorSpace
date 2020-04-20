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
                $('.search-card-container').append('<h5>You have not saved any tutors yet</h5>');
            }
        },
        error: function(error) {
            toastr.error(error);
        }
    });
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
                $('.upcoming-sessions-container').append('<h5>There is no upcoming sessions yet</h5>');
            }

        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });

});


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
});


// cancel button for post
$('#write-review-container .btn-cancel').click((e) => {
    e.preventDefault();
    $('#background-cover').hide();
});


// add post
$('#write-review-container').submit((e) => {
    e.preventDefault();

    let reviewMsg = $('#review-content').val();

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
        },
        success: (data) => {
            console.log(data);
            let { successMsg } = data;
            toastr.success(successMsg);

            $('#background-cover').hide();

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
