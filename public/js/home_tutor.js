// select view session
$('.home__container__notifications__sessions .session__container > button:last-child').click(function () {
    window.location.href = '/view_session_before_tutor.html';
});


// select cancel session
$('.home__container__notifications__sessions .session__container > button:not(:last-child)').click(function () {
    alert('session cancelled');
});




$('.tutor-requests-table button:last-child').click(function() {
    alert('accepted tutor request');
});

$('.tutor-requests-table button:not(:last-child)').click(function() {
    alert('declined tutor request');
});
