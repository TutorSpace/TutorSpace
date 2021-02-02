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
                            className: 'btn btn-primary px-4 fs-1-8',
                        },
                    }
                });
            },
            error: (error) => {
                console.log(error);
            }
        });
    });



    function cancelSession(sessionId, cancelReasonId){
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
                toastr.error("Something went wrong when canceling the session. Please contact tutorspacehelp@gmail.com for more details.");
            },
            complete: () => {
                JsLoadingOverlay.hide();
            }
        });
    }

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
                    className: 'btn btn-primary px-4 fs-1-8',
                    callback: function(e) {
                        let cancelReasonId = $($('#cancel-reason option:selected')).val();
                        // check if there's a penalty
                        $.ajax({
                            type: 'POST',
                            url: "{{ URL::to('/') }}" + `/session/cancel/checkShouldPenalize/${sessionId}`,
                            success: function success(data) {
                                var hasPenalty = data.hasPenalty;
                                // has penalty
                                if (hasPenalty === 'true'){
                                    // confirm popup
                                    bootbox.dialog({
                                        message: `@include('session.session-cancel-confirm')`,
                                        size: 'large',
                                        centerVertical: true,
                                        buttons: {
                                            Cancel: {
                                                label: 'Confirm',
                                                className: 'btn btn-primary px-4 fs-1-8',
                                                callback: function(e) {
                                                    cancelSession(sessionId, cancelReasonId);
                                                }
                                            },
                                        }
                                    });
                                // no penalty
                                }else{
                                    cancelSession(sessionId, cancelReasonId);
                                }
                            },
                            error: function error(error) {
                                toastr.error("Something went wrong when canceling the session. Please contact tutorspacehelp@gmail.com for more details.");
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
                className: 'btn btn-primary px-4 fs-1-8',
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
        },
        // to avoid calendar loading issue
        onShow: function(e) {
            $('.calendar').addClass('invisible');
        },
        onShown: function(e) {
            setTimeout(function () {
                $('.calendar').removeClass('invisible');
            }, 100);
        }
    });

    if(startTime) {
        $('#session-date').html(startTime.format("MM/DD/YYYY dddd"));
        $('#session-time').html(startTime.format("h:mma") + " - " + endTime.format("h:mma"));
        // not same day
        if(startTime.format("MM/DD/YYYY") != endTime.format('MM/DD/YYYY')) {
            $('#session-date').html(startTime.format("MM/DD/YYYY dddd") + ' to ' + endTime.format("MM/DD/YYYY dddd"));
            $('#session-time').html(startTime.format("MM/DD h:mma") + " - " + endTime.format("MM/DD h:mma"));
        } else {
            $('#session-date').html(startTime.format("MM/DD/YYYY dddd"));
            $('#session-time').html(startTime.format("h:mma") + " - " + endTime.format("h:mma"));
        }

        $('#hourly-rate').html(`$ ${otherUserHourlyRate} per hour`);
    }

    calendarOptions.height = 300
    let e = new FullCalendar.Calendar($('#calendar-request-session')[0], calendarOptions);
    e.render();
    setTimeout(() => {
        e.destroy();
         if (startTime && endTime){
            console.log("selected")
            e.select(startTime, endTime);
        }
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
                    className: 'btn btn-primary px-4 fs-1-8',
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
                        className: 'btn btn-primary px-4 fs-1-8',
                        callback: function() {
                            if(!$('#book-session-agreement').is(":checked")) {
                                toastr.error('Please click on the check box to agree our policies before you can schedule a tutoring session.');
                                return false;
                            }
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
                                        setTimeout(function() {
                                            window.location.reload()
                                        }, 1000);
                                    }
                                    if (redirectMsg = data.redirectMsg){
                                        toastr.error("Please add a bank card before booking a tutoring session");
                                        setTimeout(function() {
                                            window.location.href = redirectMsg;
                                        }, 1000);
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
            $('#session-fee').html('$ ' + sessionFee);
            $('#hours').html("x " + hoursDiff);
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
                className: 'btn btn-outline-primary px-4 fs-1-8',
                callback: function(e) {}
            },
            Submit: {
                label: 'Submit',
                className: 'btn btn-primary px-4 fs-1-8',
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
