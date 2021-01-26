<script>
let calendarOptions = {
    timeZone: 'local',
    themeSystem: 'bootstrap',
    initialView: 'timeGridDay',
    headerToolbar: {
        left: 'prev title next',
        center: '',
        right: 'today timeGridDay timeGridFiveDay'
    },
    eventColor: 'rgb(213, 208, 223)',
    height: 'auto',
    navLinks: true, // can click day/week names to navigate views
    selectable: true,
    selectMirror: true,
    nowIndicator: true,
    slotMinTime: "00:00:00",
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
        timeGridFiveDay: {
            type: 'timeGrid',
            duration: { days: 5 },
            buttonText: '5 days'
        }
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
            start: moment.utc('{{$time->available_time_start}}').format('YYYY-MM-DD'),
            end: moment.utc('{{$time->available_time_end}}').format('YYYY-MM-DD'),
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
            start: moment.utc('{{$upcomingSession->session_time_start}}').format('YYYY-MM-DD'),
            end:  moment.utc('{{$upcomingSession->session_time_emd}}').format('YYYY-MM-DD'),
            description: "",
        },
        @endforeach
    ],
};

let calendar;
let calendarPopUp;
let calendarPopUpOptions = JSON.parse(JSON.stringify(calendarOptions));
calendarPopUpOptions.selectAllow = false;
calendarPopUpOptions.eventClick = null;

document.addEventListener('DOMContentLoaded', function() {
    // for the large calendar
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, calendarOptions);
    calendar.render();
});


$('#availableTimeConfirmationModal form').submit(function(e) {
    e.preventDefault();
    let data = $(this).serialize();
    JsLoadingOverlay.show(jsLoadingOverlayOptions);
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
        },
        complete: () => {
            JsLoadingOverlay.hide();
        }
    });
});
$('#availableTimeDeleteConfirmationModal form').submit(function(e) {
    e.preventDefault();
    let data = $(this).serialize();

    JsLoadingOverlay.show(jsLoadingOverlayOptions);
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
        },
        complete: () => {
            JsLoadingOverlay.hide();
        }
    });
});


</script>
