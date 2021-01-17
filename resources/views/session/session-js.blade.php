<script>

    $('.btn-view-session').on('click',function() {
        let sessionId = $(this).closest('.info-card').attr('data-session-id') ? $(this).closest('.info-card').attr('data-session-id') : $(this).closest('.info-box').attr('data-session-id');

        JsLoadingOverlay.show(jsLoadingOverlayOptions);
        $.ajax({
            type: 'GET',
            url: "{{ url('/') . '/session/view/' }}" + sessionId,
            complete: () => {
                JsLoadingOverlay.hide();
            },
            success: (data) => {
                let { view, minTime, maxTime, date } = data;

                bootbox.dialog({
                    message: view,
                    size: 'large',
                    centerVertical: true,
                    buttons: {
                        Next: {
                            label: 'Done',
                            className: 'btn btn-primary px-4 fs-1-6',
                        },
                    }
                });

                @if(Auth::user()->is_tutor)
                let options = JSON.parse(JSON.stringify(calendarOptions));
                options.selectAllow = false;
                options.eventClick = null;
                options.headerToolbar = null;
                options.height = 250;
                options.displayEventTime = false;

                options.slotMinTime = minTime;
                options.slotMaxTime = maxTime;

                let e = new FullCalendar.Calendar($('#calendar-view-session')[0], options);
                e.render();
                setTimeout(() => {
                    e.destroy();
                    e.render();
                    // e.gotoDate('2020-10-25');
                    e.gotoDate(date);
                }, 500);
                @endif
            },
            error: (error) => {
                console.log(error);
            }
        });
    });



    $('.btn-cancel-session').on('click',function() {
        let sessionId = $(this).closest('.info-card').attr('data-session-id') ? $(this).closest('.info-card').attr('data-session-id') : $(this).closest('.info-box').attr('data-session-id');
        let name = $(this).closest('.info-card').find('.user-name').html();

        bootbox.dialog({
            message: `@include('session.session-cancel')`,
            size: 'large',
            centerVertical: true,
            buttons: {
                Cancel: {
                    label: 'Cancel Session',
                    className: 'btn btn-primary px-4 fs-1-6',
                    callback: function(e) {
                        let cancelReasonId = $($('#cancel-reason option:selected')).val();
                        JsLoadingOverlay.show(jsLoadingOverlayOptions);
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
                                toastr.error("Something went wrong when canceling the session. Please contact tutorspaceusc@gmail.com for more details.");
                            },
                            complete: () => {
                                JsLoadingOverlay.hide();
                            }
                        });
                    }
                },
            }
        });

        $('.modal-session-cancel .name').html(name);

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
                className: 'btn btn-primary px-4 fs-1-6',
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
    // console.log(calendarOptions.select);
    // JSON.parse(JSON.stringify(calendarOptions)) => will lose the function
    // let options = JSON.parse(JSON.stringify(calendarOptions));
    // console.log(options.select);
    // options.height = 250;

    calendarOptions.height = 300
    let e = new FullCalendar.Calendar($('#calendar-request-session')[0], calendarOptions);
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
                    className: 'btn btn-primary px-4 fs-1-6',
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
                        className: 'btn btn-primary px-4 fs-1-6',
                        callback: function() {
                            JsLoadingOverlay.show(jsLoadingOverlayOptions);
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
                                    if (successMsg = data.successMsg){
                                        toastr.success(successMsg);
                                        console.log(successMsg);
                                    }
                                    if (redirectMsg = data.redirectMsg){
                                        toastr.error("Please add a bank card before booking a tutor session");
                                        setTimeout(function() {
                                            window.location.href = redirectMsg;
                                        }, 2000);
                                    }
                                },
                                error: (error) => {
                                    console.log(error.responseJSON.error);
                                    toastr.error(error.responseJSON.error);
                                },
                                complete: () => {
                                    JsLoadingOverlay.hide();
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

$('.action-review').click(function() {
    let url = $(this).attr('data-route-url');

    bootbox.dialog({
        message: `@include('session.review-session')`,
        size: 'large',
        centerVertical: true,
        buttons: {
            Cancel: {
                label: 'Cancel',
                className: 'btn btn-outline-primary px-4 fs-1-6',
                callback: function(e) {}
            },
            Submit: {
                label: 'Submit',
                className: 'btn btn-primary px-4 fs-1-6',
                callback: function(e) {
                    if (!$.trim($(".modal-session-report textarea").val())) {
                        // textarea is empty or contains only white-space
                        toastr.error('Please enter the details.')
                        return false;
                    }
                    JsLoadingOverlay.show(jsLoadingOverlayOptions);

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: $('.modal-session-report').serialize(),
                        success: (data) => {
                            toastr.success(data.successMsg);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        },
                        error: function(error) {
                            toastr.error('Something went wrong. Please try again.');
                            console.log(error);
                        },
                        complete: () => {
                            JsLoadingOverlay.hide();
                        }
                    });
                }
            }
        }
    });
});

</script>
