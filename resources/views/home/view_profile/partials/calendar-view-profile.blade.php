<script>
let calendarOptions = {
    timeZone: 'local',
    themeSystem: 'bootstrap',
    initialView: 'timeGridFiveDay',
    headerToolbar: {
        left: 'prev title next',
        center: '',
        right: 'today timeGridDay timeGridFiveDay'
    },
    eventColor: 'rgb(213, 208, 3)',
    height: 400,
    navLinks: true, // can click day/week names to navigate views
    selectable: true,
    selectMirror: true,
    nowIndicator: true,
    slotMinTime: "00:00:00",
    slotMaxTime: "24:00:00",
    allDaySlot: false,
    selectOverlap: function(event) {
        return event.display === 'background';
    },
    validRange: function (nowDate) {
        return {
            start: nowDate
        };
    },
    // editable: true,
    expandRows: true,
    views: {
        timeGridFiveDay: {
            type: 'timeGrid',
            duration: { days: 5 },
            buttonText: '5 days'
        }
    },
    selectAllow: function(selectionInfo) {
        @if(Auth::check() && Auth::user()->is_tutor)
        return false;
        @else
        let startTime = moment(selectionInfo.start);
        if(startTime.isBefore(moment().add(2, 'hours'))) {
            toastr.error('Tutoring session must be scheduled 2 hours ahead of start time.');
            return false;
        }

        return true;
        @endif
    },
    select: function (selectionInfo) {
        @auth
        startTime = moment(selectionInfo.start);
        endTime = moment(selectionInfo.end);
        // if the modal appeared
        if($('.calendar-details')[0]) {
            // not same day
            if(moment(selectionInfo.start).format("MM/DD/YYYY") != moment(selectionInfo.end).format('MM/DD/YYYY')) {
                $('#session-date').html(startTime.format("MM/DD/YYYY dddd") + ' to ' + endTime.format("MM/DD/YYYY dddd"));
                $('#session-time').html(startTime.format("MM/DD h:mma") + " - " + endTime.format("MM/DD h:mma"));
            } else {
                $('#session-date').html(startTime.format("MM/DD/YYYY dddd"));
                $('#session-time').html(startTime.format("h:mma") + " - " + endTime.format("h:mma"));
            }

            $('#hourly-rate').html(`$ ${otherUserHourlyRate} per hour`);
        } else {
            $('#tutor-profile-request-session').click();
        }
        startTime = moment.utc(selectionInfo.start);
        endTime = moment.utc(selectionInfo.end);
        @else
        $('.overlay-student').show();
        @endauth
    },
    eventClick: function (eventClickInfo) {
        eventClickInfo.jsEvent.preventDefault(); // don't let the browser navigate
        if (eventClickInfo.event.url) {
            window.open(eventClickInfo.event.url);
        }
    },
    eventTimeFormat: {
        hour: 'numeric',
        minute: '2-digit',
        meridiem: 'short'
    },
    events: [
        @foreach($user->availableTimes as $time)
        {
            textColor: 'transparent',
            start: moment.utc('{{$time->available_time_start}}').format(),
            end: moment.utc('{{$time->available_time_end}}').format(),
            description: "",
            display: "background",
            classNames: ['my-available-time']
        },
        @endforeach

        @foreach($user->upcomingSessions as $upcomingSession)
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
            start: moment.utc('{{$upcomingSession->session_time_start}}').format(),
            end:  moment.utc('{{$upcomingSession->session_time_emd}}').format(),
        },
        @endforeach

        @foreach($user->pendingTutorRequests as $request)
        {
            title: 'Your Tutor Request',
            start: moment.utc('{{$request->session_time_start}}').format(),
            end: moment.utc('{{$request->session_time_end}}').format(),
            description: "",
            display: "background",
            classNames: ['tutor-request--view-profile', 'text-center']
        },
        @endforeach
    ],
};

let calendar;

document.addEventListener('DOMContentLoaded', function() {
    // for the large calendar
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, calendarOptions);
    calendar.render();
});


</script>
