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
        'EALC',
        'CSCI',
        'COMM',
        'BUAD'
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

$('.about__buttons__container button svg').click(function() {
    alert('TODO: remove from subjects/courses/characteristics');
});


