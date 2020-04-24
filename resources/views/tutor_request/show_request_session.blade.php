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
    <h4 class="mb-4">Confirm Tutor Request</h4>
    <div class="info-container">
        <div class="info-row">
            <small class="descriptor">Tutor Name</small>
            <small class="descriptor">Student Name</small>
            <span class="text tutor-name">{{$tutor->full_name}}</span>
            <span class="text student-name">{{$user->full_name}}</span>
        </div>
        <div class="info-row">
            <small class="descriptor">Date</small>
            <small class="descriptor">Subject / Course</small>
            <span class="text date"></span>
            <select class="custom-select custom-select-lg mt-2" name="course-subject" id="course-subject">
                <option selected="true" disabled="disabled">Select</option>
                @if(count($interestedCourses) === 0 && count($interestedSubjects) === 0)
                <option disabled="disabled">Please first add interested courses/subjects in profile page.</option>
                @else
                @foreach ($interestedCourses as $interestedCourse)
                <option value="course-{{$interestedCourse->id}}">{{$interestedCourse->course}}</option>
                @endforeach
                @foreach ($interestedSubjects as $interestedSubject)
                <option value="subject-{{$interestedSubject->id}}">{{$interestedSubject->subject}}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="info-row">
            <small class="descriptor">Start Time</small>
            <small class="descriptor">End Time</small>
            <span class="text start-time"></span>
            <span class="text end-time"></span>
        </div>
        <div class="info-row">
            <small class="descriptor">Hourly Rate</small>
            <small class="descriptor"></small>
            <span class="text hourly-rate">${{$tutor->hourly_rate}} / hr</span>
            <span class="text"></span>
        </div>
    </div>
    <div class="message-content-container">
        <h5 class="message-header">Message to Tutor</h5>
        <textarea name="message" id="message" placeholder="Add a short message to the tutor about the session or yourself" rows="3">

        </textarea>
    </div>
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

    <div class="edit-availability-container">
        <h4>{{$tutor->full_name}}'s Availability</h4>
        <p class="mt-2 f-14">Click on time slot you would like to be tutored in. The time slots with blue background indicates the tutor's preferred tutoring time. But you can still select any other time in case if the tutor is still willing to tutor that time.</p>
        <div id='calendar'></div>

    </div>


</div>



@endsection

@section('js')

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
                description: "",
                rendering: 'background',
                classNames: ['color-blue-light']
            },
            @endforeach
            @foreach($upcomingSessions as $upcomingSession)
            {
                @php
                    $startTime = date("H:i", strtotime($upcomingSession->start_time));
                    $endTime = date("H:i", strtotime($upcomingSession->end_time));

                @endphp
                title: 'Not Available',
                // start: '{{date('Y-m-d', strtotime($upcomingSession->date))}}T10:00:00',
                start: '{{date('Y-m-d', strtotime($upcomingSession->date))}}T{{$startTime}}',
                // start: '2020-04-25T12:30:00',
                end: '{{date('Y-m-d', strtotime($upcomingSession->date))}}T{{$endTime}}',
                description: "",
                classNames: ['orange-red']
            },
            @endforeach
        ],
        eventColor: '#97D2FB',
        eventRender: function (info) {

        },
        eventPositioned: function (info) {
            // console.log("the event is placed!");

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
            // console.log("the day is rendered!");
            // console.log(dayInfo);
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

            // we need to check same day for edit availability!
            if(startTime.getDate() !== endTime.getDate() || startTime.getMonth() != endTime.getMonth() || startTime.getYear() != endTime.getYear()) {
                toastr.error("Please select the time range of the same day!");
                return;
            }

            // Must select a time that is at least 30 minutes > current time!
            var now = new Date();
            now.setMinutes(now.getMinutes() + 30);
            if(startTime < now) {
                toastr.error("Please select a starting time that is at least 30 minutes after the current time!");
                calendar.unselect();
                return;
            }

            // Must select a time that is within two weeks!
            now = new Date();
            now.setDate(now.getDate() + 14);
            if(startTime > now) {
                toastr.error("Please make a tutor request that is within two weeks in the future!");
                calendar.unselect();
                return;
            }

            showForm(selectionInfo);


        },
        unselect: function (jsEvent, view) {

        },
        selectMirror: true,
        selectOverlap: function(event) {
            return event.rendering === 'background';
        },
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
let start_time;
let end_time;

function getMinutesFormat(date) {
    if(date.getMinutes() < 10) {
        return "0" + date.getMinutes();
    }
    return date.getMinutes();
}

function showForm(info) {
    date = startTime.yyyymmdd();
    $('.info-container .date').html(date);

    let startHour = startTime.getHours();
    let startMinutes = startTime.getMinutes();
    if(startHour < 12) {
        if(startMinutes == 30) {
            start_time = startHour + ":30" + "am";
        }
        else {
            start_time = startHour + "am";
        }
    }
    else if(startHour == 12) {
        if(startMinutes == 30) {
            start_time = startHour + ":30" + "pm";
        }
        else {
            start_time = "12pm";
        }
    }
    else {
        if(startMinutes == 30) {
            start_time = startHour - 12 + ":30" + "pm";
        }
        else {
            start_time = startHour - 12 + "pm";
        }
    }
    let endHour = endTime.getHours();
    let endMinutes = endTime.getMinutes();
    if(endHour < 12) {
        if(endMinutes == 30) {
            end_time = endHour + ":30" + "am";
        }
        else {
            end_time = endHour + "am";
        }
    }
    else if(endHour == 12) {
        if(endMinutes == 30) {
            end_time = endHour + ":30" + "pm";
        }
        else {
            end_time = "12pm";
        }
    }
    else {
        if(endMinutes == 30) {
            end_time = endHour - 12 + ":30" + "pm";
        }
        else {
            end_time = endHour - 12 + "pm";
        }
    }

    $('.info-container .start-time').html(start_time);
    $('.info-container .end-time').html(end_time);



    startTime = startTime.yyyymmdd() + " " + startTime.getHours() + ":" + getMinutesFormat(startTime);
    endTime = endTime.yyyymmdd() + " " + endTime.getHours() + ":" + getMinutesFormat(endTime);



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

    let inputCourseSubject = $('#course-subject option:selected').val();
    if(inputCourseSubject === 'Select') {
        toastr.warning('Please select which subject/course your want to be tutored in!');
        return;
    }
    let message = $('#message').val();
    if($.trim(message) == '') {
        toastr.warning("Please enter a message!")
        return;
    }

    $.ajax({
        type:'POST',
        url: `/tutor_request`,
        data: {
            tutor_session_date: date,
            start_time: start_time,
            end_time: end_time,
            tutor_id: {{$tutor->id}},
            subjectCourse: inputCourseSubject,
            message: message
        },
        success: (data) => {
            let { successMsg } = data;
            toastr.success(successMsg);

            location.reload();
        },
        error: function(data) {
            console.log(data);
            if(data.status === 422) {
                let { message } = data.responseJSON;
                toastr.error(message);
            }
        }
    });
});

</script>

@endsection
