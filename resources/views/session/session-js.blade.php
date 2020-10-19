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
                    className: 'btn btn-primary p-3 px-5',
                },
            }
        });

        function session_details() {
            bootbox.dialog({
                message: `@include('session.view-session-overview')`,
                size: 'large',
                backdrop: true,
                centerVertical: true,
                buttons: {
                    Cancel: {
                        label: 'Cancel Session',
                        className: 'btn btn-outline-primary mr-2 p-3 px-5',
                        callback: session_cancel
                    },
                    Next: {
                        label: 'Done',
                        className: 'btn btn-primary p-3 px-5',
                        callback: function(){}
                    },
                }
            });
        }
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
                    className: 'btn btn-primary p-3 px-5',
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
                className: 'btn btn-primary p-3 px-5',
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
                    className: 'btn btn-primary p-3 px-5',
                    callback: session_confirm
                },
            }
        });
    }
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
});
</script>
