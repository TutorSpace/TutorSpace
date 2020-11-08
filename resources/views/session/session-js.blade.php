<script>
    $('.btn-view-session').on('click',function() {
        bootbox.dialog({
            message: `@include('session.view-session-overview')`,
            size: 'large',
            backdrop: true,
            centerVertical: true,
            buttons: {
                Next: {
                    label: 'Done',
                    className: 'btn btn-primary p-3 px-4 fs-1-4',
                },
            }
        });

        @if(Auth::user()->is_tutor)
        let options = Object.assign({}, calendarOptions);
        options.selectAllow = false;
        options.eventClick = null;
        options.headerToolbar = null;
        options.height = 'auto';
        options.slotMinTime = "08:30:00";
        options.slotMaxTime = "11:30:00";
        let e = new FullCalendar.Calendar($('#calendar-view-session')[0], options);
        e.render();
        setTimeout(() => {
            e.destroy();
            e.render();
            e.gotoDate('2020-10-25');
        }, 500);
        @endif

    });



    $('.btn-cancel-session').on('click',function() {
        bootbox.dialog({
            message: `@include('session.session-cancel')`,
            size: 'large',
            backdrop: true,
            centerVertical: true,
            buttons: {
                Cancel: {
                    label: 'Cancel Session',
                    className: 'btn btn-primary p-3 px-4 fs-1-4',
                    callback: function(e) {
                        let cancelReasonId = $($('#cancel-reason option:selected')).val();

                        $.ajax({
                            type: 'POST',
                            url: `session/cancel/${sessionId}`,
                            data: {
                                cancelReasonId: cancelReasonId
                            },
                            success: function success(data) {
                                var successMsg = data.successMsg;
                                toastr.success(successMsg);
                                console.log(successMsg);
                                // window.location.reload();
                            },
                            error: function error(error) {
                                toastr.error("There is an error occurred");
                            }
                        });
                    }
                },
            }
        });

        let sessionId = $(this).closest('.info-card').attr('data-session-id');

    });
</script>


<script>
$('#tutor-profile-request-session').on('click',function() {
    bootbox.dialog({
        message: `@include('session.book-session')`,
        size: 'large',
        onEscape: true,
        backdrop: true,
        centerVertical: true,
        buttons: {
            Next: {
                label: 'Next',
                className: 'btn btn-primary p-3 px-4',
                callback: session_details
            },
        }
    });

    let options = Object.assign({}, calendarOptions);
    options.height = 350;
    let e = new FullCalendar.Calendar($('#calendar-request-session')[0], options);
    e.render();
    setTimeout(() => {
        e.destroy();
        e.render();
    }, 500);

    function session_details() {
        bootbox.dialog({
            message: `@include('session.session-details')`,
            size: 'large',
            onEscape: true,
            backdrop: true,
            centerVertical: true,
            buttons: {
                Next: {
                    label: 'Next',
                    className: 'btn btn-primary p-3 px-4',
                    callback: session_confirm
                },
            }
        });

        function session_confirm() {
            bootbox.dialog({
                message: `@include('session.session-confirm')`,
                size: 'large',
                onEscape: true,
                backdrop: true,
                centerVertical: true,
                buttons: {
                    Submit: {
                        label: 'Book Session',
                        className: 'btn btn-primary p-3 px-5',
                        callback: function(){},
                    },
                }
            });
        }
    }
});
</script>
