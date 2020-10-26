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
    eventColor: 'rgb(213, 208, 3)',
    height: 'auto',
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
        // showAvailableTimeForm(startTime, endTime);
    },
    eventClick: function (eventClickInfo) {
        eventClickInfo.jsEvent.preventDefault(); // don't let the browser navigate
        if (eventClickInfo.event.url) {
            window.open(eventClickInfo.event.url);
        }
        if(eventClickInfo.event.extendedProps.type == 'available-time') {
            // showAvailableTimeDeleteForm(eventClickInfo.event.start, eventClickInfo.event.end, eventClickInfo.event.id);
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
