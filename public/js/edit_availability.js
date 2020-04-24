Date.prototype.yyyymmdd = function() {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
            (mm>9 ? '' : '0') + mm,
            (dd>9 ? '' : '0') + dd
            ].join('-');
};

let calendar;

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['timeGrid', 'dayGrid', 'interaction', 'bootstrap'],

        // default time should be los angeles' time
        timeZone: 'PDT',
        defaultView: 'timeGridWeek',
        header: {
            left: 'prev, next today',
            center: 'title',
            right: 'timeGridDay, timeGridWeek, dayGridMonth'
        },
        // contentHeight: 800,
        events: [{
                title: 'testing event',
                start: '2020-04-23T12:30:00',
                end: '2020-04-23T13:30:00',
                description: "testing description"
                // classNames: ['test']
            },

        ],
        eventColor: '#97D2FB',
        eventRender: function (info) {

        },
        eventPositioned: function (info) {
            console.log("the event is placed!");

        },
        eventClick: function (eventClickInfo) {
            eventClickInfo.jsEvent.preventDefault(); // don't let the browser navigate
            if (eventClickInfo.event.url) {
                window.open(eventClickInfo.event.url);
            }
        },
        eventMouseEnter: function (mouseEnterInfo) {

        },
        eventMouseLeave: function (mouseLeaveInfo) {

        },


        allDaySlot: false,
        minTime: "06:00:00",

        // called each time a day is rendered! (including week(7 days) and month!)
        dayRender: function (dayInfo) {
            // alert("here");
            console.log("the day is rendered!");
            console.log(dayInfo);
        },
        validRange: function (nowDate) {
            return {
                start: nowDate
            };
        },
        navLinks: true,
        selectable: true,
        select: function (selectionInfo) {
            startTime = selectionInfo.start;
            endTime = selectionInfo.end;
            startTime.setHours( startTime.getHours() + 7 );
            endTime.setHours( endTime.getHours() + 7 );

            // we don't need to check same day for edit availability!
            // if(startTime.getDate() !== endTime.getDate() || startTime.getMonth() != endTime.getMonth() || startTime.getYear() != entTime.getYear()) {
            //     toastr.error("Please select the time range of the same day!");
            // }


            showForm(selectionInfo);

        },
        unselect: function (jsEvent, view) {

        },
        selectMirror: true,
        selectOverlap: false,
        dateClick: function (info) {
            // alert('Clicked on: ' + info.dateStr);
            // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            // alert('Current view: ' + info.view.type);
            // // change the day's background color just for fun
            // info.dayEl.style.backgroundColor = 'red';
        },
        nowIndicator: true,
        now: function () {
            // get the pdt time
            var date = new Date();
            var utcDate = new Date(date.toUTCString());

            // i have to change to -8 when it is winter time
            utcDate.setHours(utcDate.getHours() - 7);
            var usDate = new Date(utcDate);
            return usDate;
        },
        allDayDefault: false,





    });

    calendar.render();
});


let startTime;
let endTime;
let date;

function getMinutesFormat(date) {
    if(date.getMinutes() < 10) {
        return "0" + date.getMinutes();
    }
    return date.getMinutes();
}

function showForm(info) {

    startTime = startTime.yyyymmdd() + " " + startTime.getHours() + ":" + getMinutesFormat(startTime);
    endTime = endTime.yyyymmdd() + " " + endTime.getHours() + ":" + getMinutesFormat(endTime);

    $('#start-time').html(startTime);
    $('#end-time').html(endTime);



    $('#background-cover-3').height(document.documentElement.scrollHeight);
    $('#background-cover-3').width(document.documentElement.scrollWidth);
    $('#background-cover-3').show();

    let centerOffset = (document.documentElement.scrollHeight - $(window).height()) / 2;
    $('html,body').animate({
            scrollTop: centerOffset
        },
        'slow'
    );



}

$('.btn-cancel').click(function() {
    $('#background-cover-3').hide();
});






$('.btn-submit').click(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $.ajax({
        type:'POST',
        url: `/edit_availability`,
        data: {
            startTime: startTime,
            endTime: endTime
        },
        success: (data) => {
            let { successMsg } = data;
            toastr.success(successMsg);
            calendar.render();
        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });


});


