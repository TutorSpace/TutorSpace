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

@section('links-in-head')
{{-- fullcalendar --}}
<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
<link href='{{asset('fullcalendar/main.min.css')}}' rel='stylesheet' />
<script src='{{asset('fullcalendar/main.min.js')}}'></script>
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
                    'isNotification' => true,
                    'forTutor' => true,
                    'user' => App\User::find(1)
                ])
                @include('home.partials.tutor_request', [
                    'isNotification' => true,
                    'forTutor' => true,
                    'user' => App\User::find(1)
                ])
                @include('home.partials.tutor_request', [
                    'isNotification' => true,
                    'forTutor' => true,
                    'user' => App\User::find(1)
                ])
            </div>
        </div>

        <div class="row">
            <h5 class="mb-2 w-100">Calendar</h5>
            <div id="calendar" class="w-100"></div>
        </div>

        <div class="row">
            <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                <h5>Upcoming Sessions</h5>
                <button class="btn btn-link fs-1-4 fc-grey btn-view-all-upcoming-sessions">View All Upcoming Sessions</button>
            </div>
            <div class="info-boxes">
                @include('home.partials.session')
                @include('home.partials.session')
                @include('home.partials.session')
                @include('home.partials.session', [
                    'hidden' => true
                ])
                @include('home.partials.session', [
                    'hidden' => true
                ])
            </div>
        </div>


        @else
        <div class="row">
            <h5 class="mb-2 w-100">Congrats! Your Tutor Request has been approved!</h5>
            <div class="info-boxes">
                @include('home.partials.tutor_request', [
                    'user' => App\User::find(1),
                    'isNotification' => true,
                    'forTutor' => false,
                    'approved' => true
                ])

                @include('home.partials.tutor_request', [
                    'user' => App\User::find(1),
                    'isNotification' => true,
                    'forTutor' => false,
                    'approved' => true
                ])
                @include('home.partials.tutor_request', [
                    'user' => App\User::find(1),
                    'isNotification' => true,
                    'forTutor' => false,
                    'approved' => true
                ])
            </div>
        </div>

        <div class="row">
            <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                <h5>Upcoming Sessions</h5>
                <button class="btn btn-link fs-1-4 fc-grey btn-view-all-upcoming-sessions">View All Upcoming Sessions</button>
            </div>
            <div class="info-boxes">
                @include('home.partials.session')
                @include('home.partials.session')
                @include('home.partials.session')
                @include('home.partials.session', [
                    'hidden' => true
                ])
                @include('home.partials.session', [
                    'hidden' => true
                ])
            </div>
        </div>

        <div class="row">
            <h5 class="mb-2 w-100">Bookmarked Tutors</h5>

            <div class="user-cards bookmarked-tutors">
                @include('partials.user_card', [
                    'user' => App\User::find(2),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(4),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(2),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(3),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(2),
                ])

                @include('partials.user_card', [
                    'user' => App\User::find(2),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(4),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(2),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(3),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(2),
                ])

                @include('partials.user_card', [
                    'user' => App\User::find(2),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(4),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(2),
                ])
            </div>
            <div class="scroll-faded">
            </div>
        </div>


        <div class="row">
            <h5 class="mb-2 w-100">Recommended Tutors for You</h5>

            {{-- must always recommend 5 tutors --}}
            <div class="user-cards recommended-tutors">
                @include('partials.user_card', [
                    'user' => App\User::find(2),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(4),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(2),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(3),
                ])
                @include('partials.user_card', [
                    'user' => App\User::find(2),
                ])
            </div>
            <div>

            </div>
        </div>


        <div class="row">
            <h5 class="mb-2 w-100">Tutor Requests</h5>
            <div class="info-boxes tutor-requests">
                @include('home.partials.tutor_request', [
                    'user' => App\User::find(1),
                    'forTutor' => false,
                    'approved' => false
                ])

                @include('home.partials.tutor_request', [
                    'user' => App\User::find(1),
                    'forTutor' => false,
                    'approved' => true
                ])

                @include('home.partials.tutor_request', [
                    'user' => App\User::find(1),
                    'forTutor' => false,
                    'pending' => true
                ])

                @include('home.partials.tutor_request', [
                    'user' => App\User::find(1),
                    'forTutor' => false,
                    'pending' => true
                ])

                @include('home.partials.tutor_request', [
                    'user' => App\User::find(1),
                    'forTutor' => false,
                    'approved' => false
                ])

                @include('home.partials.tutor_request', [
                    'user' => App\User::find(1),
                    'forTutor' => false,
                    'approved' => true
                ])

                @include('home.partials.tutor_request', [
                    'user' => App\User::find(1),
                    'forTutor' => false,
                    'pending' => true
                ])

                @include('home.partials.tutor_request', [
                    'user' => App\User::find(1),
                    'forTutor' => false,
                    'pending' => true
                ])
            </div>
            <div class="scroll-faded">
            </div>
        </div>

        @endif

        <div class="row forum">
            <h5 class="w-100">Forum Activity</h5>
            <div class="col-12 col-sm-8 post-previews px-0">
                @include('forum.partials.post-preview-general')
            </div>
            <div class="col-12 col-sm-4 forum-data-container">
                <div class="forum-data">
                    <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
                    </svg>
                    <span class="title">My Posts</span>
                    <a class="number" href="#">10</a>
                </div>
                <div class="forum-data">
                    <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
                    </svg>
                    <span class="title">Participated</span>
                    <a class="number" href="#">212</a>
                </div>
                <div class="forum-data">
                    <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
                    </svg>
                    <span class="title">Followed</span>
                    <a class="number" href="#">102</a>
                </div>
            </div>
        </div>
    </main>

</div>


@endsection

@section('js')

<script>
    @if(Auth::user()->is_tutor)
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'bootstrap',
      initialDate: '2020-06-12',
      initialView: 'timeGridWeek',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      height: 'auto',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      selectable: true,
      selectMirror: true,
      nowIndicator: true,
        slotMinTime: "06:00:00",
        slotMaxTime: "23:00:00",
            allDaySlot: false,
      events: [
        {
          title: 'All Day Event',
          start: '2020-06-01',
        },
        {
          title: 'Long Event',
          start: '2020-06-07',
          end: '2020-06-10'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-06-09T16:00:00'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-06-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2020-06-11',
          end: '2020-06-13'
        },
        {
          title: 'Meeting',
          start: '2020-06-12T10:30:00',
          end: '2020-06-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2020-06-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2020-06-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2020-06-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2020-06-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2020-06-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2020-06-28'
        }
      ]
    });

    calendar.render();
  });

        // calendar = new FullCalendar.Calendar(calendarEl, {
        //     // default time should be los angeles' time
        //     timeZone: 'PDT',
        //     initialView: 'dayGridMonth',
        //     header: {
        //         left: 'prev,next today',
        //         center: 'title',
        //         right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        //     },
        //     contentHeight: 600,
        //     // events: [
        //         // to get the code from github
        //     // ],
        //     eventColor: '#97D2FB',
        //     eventRender: function (info) {
        //     },
        //     eventPositioned: function (info) {
        //         console.log("the event is placed!");
        //     },
        //     eventClick: function (eventClickInfo) {
        //         eventClickInfo.jsEvent.preventDefault(); // don't let the browser navigate
        //         if (eventClickInfo.event.url) {
        //             window.open(eventClickInfo.event.url);
        //         }
        //     },
        //     eventMouseEnter: function (mouseEnterInfo) {
        //     },
        //     eventMouseLeave: function (mouseLeaveInfo) {
        //     },
        //     allDaySlot: false,
        //     minTime: "06:00:00",
        //     // called each time a day is rendered! (including week(7 days) and month!)
        //     dayRender: function (dayInfo) {
        //         console.log("the day is rendered!");
        //         console.log(dayInfo);
        //     },
        //     validRange: function (nowDate) {
        //         return {
        //             start: nowDate
        //         };
        //     },
        //     navLinks: true,
        //     selectable: true,
        //     select: function (selectionInfo) {
        //         startTime = selectionInfo.start;
        //         endTime = selectionInfo.end;
        //         // startTime.setHours(startTime.getHours() + 7);
        //         // endTime.setHours(endTime.getHours() + 7);
        //         // showForm(selectionInfo);
        //     },
        //     unselect: function (jsEvent, view) {
        //     },
        //     selectMirror: true,
        //     selectOverlap: false,
        //     dateClick: function (info) {
        //         // alert('Clicked on: ' + info.dateStr);
        //         // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
        //         // alert('Current view: ' + info.view.type);
        //         // // change the day's background color just for fun
        //         // info.dayEl.style.backgroundColor = 'red';
        //     },
        //     nowIndicator: true,
        //     now: function () {
        //         // get the pdt time
        //         var date = new Date();
        //         var utcDate = new Date(date.toUTCString());
        //         // I have to change to -8 when it is winter time
        //         utcDate.setHours(utcDate.getHours() - 7);
        //         var usDate = new Date(utcDate);
        //         return usDate;
        //     },
        //     allDayDefault: false,
        // });
    //     calendar.render();
    // });
    @endif

    let storageUrl = "{{ Storage::url('') }}";
</script>
@include('partials.nav-auth-js')
<script src="{{ asset('js/home/index.js') }}"></script>
@endsection
