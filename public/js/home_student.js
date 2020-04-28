$('.recommended__tutors tr >:not(:last-child)').click(function() {
    window.location.href = '/view_profile/' + $(this).parent().attr('data-user-id') + '?from=home';
});


$('.tutor-container .btn-view-profile').click(function() {
    window.location.href = '/view_profile/' + $(this).attr('data-user-id') + '?from=home';
})



