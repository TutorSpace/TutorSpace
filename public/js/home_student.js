// select view profile
$('.tutor-container .btn-view-profile').click(function () {
    window.location.href = '/expanded_view';
});

// select past session
$('.tutor-container .btn-view-past-session').click(function () {
    window.location.href = '/view_session';
});

$('.recommended__tutors tr >:not(:last-child)').click(function() {

    window.location.href = '/view_profile/' + $(this).parent().attr('data-user-id') + '?from=home';
});


$('.tutor-container .btn-view-profile').click(function() {
    window.location.href = '/view_profile/' + $(this).attr('data-user-id') + '?from=home';
})



