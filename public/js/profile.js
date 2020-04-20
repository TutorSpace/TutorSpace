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


$('.session__container button').click(function() {
    if($(this)[0].innerHTML === "Cancel Session") {
        alert("TODO: session cancelled!");
    }

});

$('.btn-write-review').click(function() {
    alert('TODO: go to write review page');
});


$( ".about__content .about__input" ).focusin(function() {
    $(this).prev().css('fill', '#2C86C4');
});

$( ".about__content .about__input" ).focusout(function() {
    $(this).prev().css('fill', 'grey');
});


$('svg.bookmark').click(function() {
    alert('TODO: remove from bookmarked');
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


