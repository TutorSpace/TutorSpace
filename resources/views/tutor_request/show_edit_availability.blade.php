@extends('layouts.loggedin')
@section('title', 'make tutor request')

@section('links-in-head')

<link href='{{asset('packages/core/main.css')}}' rel='stylesheet' />
<link href='{{asset('packages/daygrid/main.css')}}' rel='stylesheet' />
<link href='{{asset('packages/timegrid/main.css')}}' rel='stylesheet' />
<link href='{{asset('packages/bootstrap/main.css')}}' rel='stylesheet' />


<script src='{{asset('packages/core/main.js')}}'></script>
<script src='{{asset('packages/daygrid/main.js')}}'></script>
<script src='{{asset('packages/timegrid/main.js')}}'></script>
<script src='{{asset('packages/interaction/main.js')}}'></script>
<script src='{{asset('packages/bootstrap/main.js')}}'></script>

@endsection


@section('confirm-time-container')
<div id="confirm-time-container">
    <h4 class="mb-3">Confirm Available Time</h4>
    <h6 class="mb-5">
        Are you sure you are available from <span id="start-time"></span> to <span id="end-time"></span>?
    </h6>
    <div class="bottom-container">
        <button class="btn btn-lg btn-outline-primary btn-cancel mr-3" type="button">Cancel</button>
        <button class="btn btn-lg btn-primary btn-submit" type="submit">Submit</button>
    </div>
</div>
@endsection


@section('content')

<div class="container">
    <div>
        @if(!$from)
                <a class="btn btn-lg back-button" id="back-button" href="/home">
                    <svg>
                        <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
                    </svg>
                    Back to Home
                </a>
            @elseif($from == 'search')
                <a class="btn btn-lg back-button" id="back-button" href="/search?navInput=">
                    <svg>
                        <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
                    </svg>
                    Back to Search
                </a>
            @else
                <a class="btn btn-lg back-button" id="back-button" href="/{{$from}}">
                    <svg>
                        <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
                    </svg>
                    Back to {{ucwords($from)}}
                </a>
            @endif
    </div>

    <form action="" class="edit-availability-container" method="POST">
        @csrf
        <h4>Edit Your Availability</h4>
        <div id='calendar'></div>

    </form>


</div>



@endsection

@section('js')

{{-- <script src="{{asset('js/edit_availability.js')}}"></script> --}}

<script>

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
        events: [
            @foreach($times as $time)
            {
                title: 'Available',
                start: '{{$time->available_time_start}}',
                end: '{{$time->available_time_end}}',
                description: ""
                // classNames: ['test']
            },
            @endforeach
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
            calendar.addEvent({
                title: 'Available',
                start: startTime,
                end: endTime
            });

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

            $('#background-cover-3').hide();
            // calendar.render();

            // window.location.href = "/edit_availability";

        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });


});




</script>

@endsection
