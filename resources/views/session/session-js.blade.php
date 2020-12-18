<script>
    $('.btn-view-session').on('click',function() {
        bootbox.dialog({
            message: `@include('session.view-session-overview')`,
            size: 'large',
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

        // todo: modify this
        options.slotMinTime = "08:30:00";
        options.slotMaxTime = "11:30:00";

        let e = new FullCalendar.Calendar($('#calendar-view-session')[0], options);
        e.render();
        setTimeout(() => {
            e.destroy();
            e.render();
            e.gotoDate('2020-10-25'); // todo: change this
        }, 500);
        @endif
    });


    $('.btn-cancel-session').on('click',function() {
        let sessionId = $(this).closest('.info-card').attr('data-session-id') ? $(this).closest('.info-card').attr('data-session-id') : $(this).closest('.info-box').attr('data-session-id');
        console.log(sessionId);

        bootbox.dialog({
            message: `@include('session.session-cancel')`,
            size: 'large',
            centerVertical: true,
            buttons: {
                Cancel: {
                    label: 'Cancel Session',
                    className: 'btn btn-primary p-3 px-4 fs-1-4',
                    callback: function(e) {
                        let cancelReasonId = $($('#cancel-reason option:selected')).val();

                        $.ajax({
                            type: 'POST',
                            url: "{{ URL::to('/') }}" + `/session/cancel/${sessionId}`,
                            data: {
                                cancelReasonId: cancelReasonId
                            },
                            success: function success(data) {
                                var successMsg = data.successMsg;
                                toastr.success(successMsg);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            },
                            error: function error(error) {
                                toastr.error("There is an error occurred");
                            }
                        });
                    }
                },
            }
        });


    });
</script>


<script>
let startTime;
$('#tutor-profile-request-session').on('click',function() {
    bootbox.dialog({
        message: `@include('session.book-session')`,
        size: 'large',
        onEscape: true,
        centerVertical: true,
        buttons: {
            Next: {
                label: 'Next',
                className: 'btn btn-primary p-3 px-4',
                callback: () => {
                    if(startTime && endTime) {
                        session_details();
                        return true;
                    } else {
                        toastr.error('Please select a valid time first');
                        return false;
                    }
                }
            },
        }
    });

    if(startTime) {
        $('#session-date').html(startTime.format("MM/DD/YYYY dddd"));
        $('#session-time').html(startTime.format("h:mma") + " - " + endTime.format("h:mma"));
        $('#hourly-rate').html(`$ ${otherUserHourlyRate} per hour`);
    }


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
            centerVertical: true,
            buttons: {
                Next: {
                    label: 'Next',
                    className: 'btn btn-primary p-3 px-4',
                    callback: () => {
                        // no need for checking, because default select is made. Although backend validation is required.
                        session_confirm();
                    },
                },
            }
        });


        for (i = 0; i < courses.length; i++) {
            let course = courses[i];
            $('#courses').append(`
               <option value="${course.id}">${course.course}</option>
            `)
        }


        function session_confirm() {
            let course = $('#courses').val();
            let sessionType = $('#session-type').val();

            bootbox.dialog({
                message: `@include('session.session-confirm')`,
                size: 'large',
                onEscape: true,
                centerVertical: true,
                buttons: {
                    Submit: {
                        label: 'Book Session',
                        className: 'btn btn-primary p-3 px-5',
                        callback: function() {
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('session.create') }}",
                                data: {
                                    startTime: startTime.toISOString(),
                                    endTime: endTime.toISOString(),
                                    course: course,
                                    sessionType: sessionType,
                                    tutorId: otherUserId
                                },
                                success: (data) => {
                                    console.log(data);
                                    var successMsg = data.successMsg;
                                    toastr.success(successMsg);
                                    console.log(successMsg);
                                },
                                error: (error) => {
                                    console.log(error);
                                    toastr.error("There is an error occurred. Please schedule your session again or contact tutorspace at tutorspaceusc@gmail.com");
                                }
                            });
                        },
                    },
                }
            });

            let minutesDiff = endTime.diff(startTime, "minutes");
            let hoursDiff = minutesDiff / 60;
            let sessionFee = hoursDiff * otherUserHourlyRate;
            $('#session-fee').html(sessionFee);
            $('#hours').html(hoursDiff);
            $('#hourly-rate').html(otherUserHourlyRate);
        }
    }
});
</script>
