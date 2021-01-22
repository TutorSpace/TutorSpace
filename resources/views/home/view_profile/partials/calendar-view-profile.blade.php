<script>
let calendarOptions = {
    timeZone: 'PST',
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
    slotMinTime: "08:00:00",
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
    now: function () {
        return "{{ Carbon\Carbon::now()->toDateTimeString() }}";
    },
    selectAllow: function(selectionInfo) {
        @if(Auth::check() && Auth::user()->is_tutor)
        return false;
        @else
        let startTime = moment(selectionInfo.start);
        if(startTime.isBefore(moment())) return false;

        if(moment(selectionInfo.start).format("MM/DD/YYYY") != moment(selectionInfo.end).format('MM/DD/YYYY')) return false;

        return true;
        @endif
    },
    select: function (selectionInfo) {
        @auth
        if(moment(selectionInfo.start).format("MM/DD/YYYY") != moment(selectionInfo.end).format('MM/DD/YYYY')) {
            return false;
        }

        startTime = moment(selectionInfo.start);
        endTime = moment(selectionInfo.end);
        // if the modal appeared
        if($('.calendar-details')[0]) {
            $('#session-date').html(startTime.format("MM/DD/YYYY dddd"));
            $('#session-time').html(startTime.format("h:mma") + " - " + endTime.format("h:mma"));
            $('#hourly-rate').html(`$ ${otherUserHourlyRate} per hour`);
        } else {
            $('#tutor-profile-request-session').click();
        }
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
            start: '{{$time->available_time_start}}',
            end: '{{$time->available_time_end}}',
            description: "",
            id: "{{ $time->id }}",
            type: "available-time",
            display: "background",
            classNames: ['my-available-time', 'hover--pointer']
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
            start: '{{ $upcomingSession->session_time_start }}',
            end: '{{ $upcomingSession->session_time_end }}',
            description: "",
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
