@extends('layouts.app')

@section('title', 'Home')

@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection

@section('content')

@include('partials.nav')

<div class="container-fluid home">
    @include('home.partials.header')

    <main class="container home__content">
        @if (Auth::user()->is_tutor)
        <div class="row">
            <h5 class="mb-2 w-100">You Have 2 New Tutor Requests!</h5>
            <div class="info-boxes">
                @include('home.partials.tutor_request', [
                    'isNotification' => true
                ])
            </div>
        </div>

        <div class="row">
            <h5 class="mb-2 w-100">Calendar</h5>
            <div id="calendar"></div>
        </div>

        <div class="row">
            <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                <h5>All Upcoming Sessions</h5>
                <a href="#" class="fs-1-4 fc-grey">View All Upcoming Sessions</a>
            </div>
            <div class="info-boxes">
                @include('home.partials.session')
            </div>
        </div>
        @else

        @endif

        <div class="row forum">
            <h5 class="mb-2 w-100">Forum Activity</h5>
            <div class="col-8 post-previews px-0">
                @include('forum.partials.post-preview-general')
            </div>
            <div class="col-3">

            </div>
        </div>
    </main>

</div>



@include('partials.footer')

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['timeGrid', 'interaction', 'dayGridMonth'],
            // default time should be los angeles' time
            timeZone: 'PDT',
            initialView: 'timeGridWeek',
            header: {
                left: 'prev, next today',
                center: 'title',
                right: 'timeGridDay, timeGridWeek, dayGridMonth'
            },
            contentHeight: 600,
            // events: [
                // to get the code from github
            // ],
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
                // startTime.setHours(startTime.getHours() + 7);
                // endTime.setHours(endTime.getHours() + 7);
                // showForm(selectionInfo);
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
                // I have to change to -8 when it is winter time
                utcDate.setHours(utcDate.getHours() - 7);
                var usDate = new Date(utcDate);
                return usDate;
            },
            allDayDefault: false,
        });
        calendar.render();
    });
</script>
@include('partials.nav-auth-js')
<script src="{{ asset('js/home/index.js') }}"></script>
@endsection
