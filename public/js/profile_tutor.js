$('.sessions__container').hide();
$('.saved__container').hide();
$('.reviews__container').hide();

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
    window.location.href = '/view_session_before_tutor.html';
});


// select all "view session button" from the past section
$('.sessions__container-2 .session__container > button:last-child').click(function() {
    window.location.href = '/view_session_after_tutor.html';
});


$('.session__container button').click(function() {
    if($(this)[0].innerHTML === "Cancel Session") {
        alert("session cancelled!");
    }
   
});