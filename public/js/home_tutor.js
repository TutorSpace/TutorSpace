$('.tutor-requests-table button:last-child').click(function(e) {
    e.stopPropagation();

    let tutorRequestId = $(this).attr('data-tutor-request-id');
    window.location.href = `/tutor_request_accept?tutor_request_id=${tutorRequestId}`;

});

$('.tutor-requests-table button:not(:last-child)').click(function(e) {
    e.stopPropagation();

    let tutorRequestId = $(this).attr('data-tutor-request-id');
    window.location.href = `/tutor_request_reject?tutor_request_id=${tutorRequestId}`;
});


$('.home__tutor-requests tr').click(() => {
    alert('TODO: go to messages page and view the request');
});


