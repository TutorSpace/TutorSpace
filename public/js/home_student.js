// select view session
$('.home__container__notifications__sessions .session__container > button:last-child').click(function () {
    window.location.href = '/view_session_before_student.html';
});


// select cancel session
$('.home__container__notifications__sessions .session__container > button:not(:last-child)').click(function () {
    alert('session cancelled');
});



// select view profile
$('.home__container__notifications__sessions .tutor-container > button:last-child').click(function () {
    window.location.href = '/expanded_view_tutor.html';
});

// select past session
$('.home__container__notifications__sessions .tutor-container > button:not(:last-child)').click(function () {
    window.location.href = '/view_session_after_student.html';
});