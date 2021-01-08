<script>
let calendarOptions = {
    // timeZone: 'PST',
    themeSystem: 'bootstrap',
    initialView: 'timeGridDay',
    headerToolbar: {
        left: 'prev title next',
        center: '',
        right: 'today timeGridDay timeGridThreeDay'
    },
    eventColor: 'rgb(213, 208, 223)',
    height: 'auto',
    navLinks: true, // can click day/week names to navigate views
    selectable: true,
    selectMirror: true,
    nowIndicator: true,
    slotMinTime: "08:00:00",
    slotMaxTime: "24:00:00",
    allDaySlot: false,
    selectOverlap: false,
    validRange: function (nowDate) {
        return {
            start: nowDate
        };
    },
    // editable: true,
    expandRows: true,
    views: {
        timeGridThreeDay: {
            type: 'timeGrid',
            duration: { days: 5 },
            buttonText: '5 days'
        }
    },
    now: function () {
        return "{{ Carbon\Carbon::now()->toDateTimeString() }}";
    },
    selectAllow: function(selectionInfo) {
        let startTime = moment(selectionInfo.start);
        if(startTime.isBefore(moment()))
            return false;
        return true;
    },
    select: function (selectionInfo) {
        let startTime = selectionInfo.start;
        let endTime = selectionInfo.end;
        showAvailableTimeForm(startTime, endTime);
    },
    eventClick: function (eventClickInfo) {
        eventClickInfo.jsEvent.preventDefault(); // don't let the browser navigate
        if (eventClickInfo.event.url) {
            window.open(eventClickInfo.event.url);
        }
        if(eventClickInfo.event.extendedProps.type == 'available-time') {
            showAvailableTimeDeleteForm(eventClickInfo.event.start, eventClickInfo.event.end, eventClickInfo.event.id);
        }

    },
    eventTimeFormat: {
        hour: 'numeric',
        minute: '2-digit',
        meridiem: 'short'
    },
    events: [
        @foreach(Auth::user()->availableTimes as $time)
        {
            textColor: 'transparent',
            start: '{{$time->available_time_start}}',
            end: '{{$time->available_time_end}}',
            description: "",
            id: "{{ $time->id }}",
            type: "available-time",
            classNames: ['my-available-time', 'hover--pointer']
        },
        @endforeach

        @foreach(Auth::user()->upcomingSessions as $upcomingSession)
        {
            title: '{{ $upcomingSession->course->course }}',
            @if($upcomingSession->is_in_person)
            extendedProps: {
                "type": "upcoming-session--inperson"
            },
            classNames: ['inperson-session'],
            @else
            extendedProps: {
                "type": "upcoming-session--online"
            },
            classNames: ['online-session'],
            @endif
            start: '{{ $upcomingSession->session_time_start }}',
            end: '{{ $upcomingSession->session_time_end }}',
            description: "",
        },
        @endforeach
    ],
};

let calendar;
let calendarPopUp;
let calendarPopUpOptions = Object.assign({}, calendarOptions);
calendarPopUpOptions.height = 300;
calendarPopUpOptions.selectAllow = false;
calendarPopUpOptions.eventClick = null;

document.addEventListener('DOMContentLoaded', function() {
    // for the large calendar
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, calendarOptions);
    calendar.render();

    // for the calendar in tutor request
    var calendarElPopUp = $('.tutor-request-modal__content__calendar .calendar')[0];
    calendarPopUp = new FullCalendar.Calendar(calendarElPopUp, calendarPopUpOptions);
});


$('#availableTimeConfirmationModal form').submit(function(e) {
    e.preventDefault();
    let data = $(this).serialize();
    $.ajax({
        type: 'POST',
        url: "{{ route('availableTime.store') }}",
        data: data,
        success: function success(data) {
            var successMsg = data.successMsg;
            toastr.success(successMsg);
            calendar.addEvent({
                textColor: 'transparent',
                start: data.available_time_start,
                end: data.available_time_end,
                description: "",
                id: data.availableTimeId,
                type: "available-time",
                classNames: ['my-available-time', 'hover--pointer']
            });
            $('#availableTimeConfirmationModal').modal('hide');
        },
        error: function error(_error) {
            console.log(_error);
            toastr.error("There is an error when submitting your availability. Please try again.");
        }
    });
});
$('#availableTimeDeleteConfirmationModal form').submit(function(e) {
    e.preventDefault();
    let data = $(this).serialize();
    $.ajax({
        type: 'DELETE',
        url: "{{ route('availableTime.delete') }}",
        data: data,
        success: function success(data) {
            var successMsg = data.successMsg;
            toastr.success(successMsg);
            calendar.getEventById(data.availableTimeId).remove();
            $('#availableTimeDeleteConfirmationModal').modal('hide');
        },
        error: function error(_error) {
            console.log(_error);
            toastr.error("There is an error when canceling your availability. Please try again.");
        }
    });
});


</script>
