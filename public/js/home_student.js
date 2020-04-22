// select view profile
$('.tutor-container .btn-view-profile').click(function () {
    window.location.href = '/expanded_view';
});

// select past session
$('.tutor-container .btn-view-past-session').click(function () {
    window.location.href = '/view_session_after';
});

$('.recommended__tutors tr >:not(:last-child)').click(function() {
    alert('TODO: going to the view profile page');
});



