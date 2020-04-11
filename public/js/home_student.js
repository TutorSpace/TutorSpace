// select view session
$('.home__container__notifications__sessions .session__container > button:last-child').click(function () {
    window.location.href = '/view_session_before';
});


// select cancel session
$('.home__container__notifications__sessions .session__container > button:not(:last-child)').click(function () {
    alert('session cancelled');
});



// select view profile
$('.home__container__notifications__sessions .tutor-container > button:last-child').click(function () {
    window.location.href = '/expanded_view';
});

// select past session
$('.home__container__notifications__sessions .tutor-container > button:not(:last-child)').click(function () {
    window.location.href = '/view_session_after';
});


$('#filter-form').submit((e) => {
    e.preventDefault();

    alert('TODO: use AJAX to put the corresponding posts into the dashboard');
});


$('#add-post').click(() => {
    alert('TODO: Add Post Tab Should Appear!');
});