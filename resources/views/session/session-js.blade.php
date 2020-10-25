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
                },
            }
        });
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
    }
});
</script>
