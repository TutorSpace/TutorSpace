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

@if(Auth::user()->is_tutor)
    @include('home.partials.availableTimeConfirmationModal')
    @include('home.partials.availableTimeDeleteConfirmationModal')
@endif

<div class="container-fluid home">
    @include('home.partials.header')

    <main class="home__content">
        @if (Auth::user()->is_tutor)
        <div class="container">
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
        </div>

        <div class="container">
            <div class="row">
                <h5 class="mb-2 w-100">Calendar</h5>
                <div id="calendar" class="w-100"></div>
            </div>
        </div>

        <div class="container">
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
        </div>

        @else
        <div class="container">
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
        </div>

        <div class="container">
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
        </div>

        <div class="container">
            <div class="row">
                <h5 class="mb-2 w-100">Bookmarked Tutors</h5>

                <div class="user-cards bookmarked-tutors">
                    @forelse (Auth::user()->bookmarkedUsers as $user)
                        @include('partials.user_card', [
                            'user' => $user
                        ])
                    @empty
                    <h6 class="">No bookmarked tutors yet</h6>
                    @endforelse
                </div>
                <div class="scroll-faded">
                </div>
            </div>
        </div>

        <div class="container-fluid recommended-tutors-bg-container">
            <div class="container">
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
                </div>
            </div>
        </div>

        <div class="container">
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

        </div>


        @endif

        <div class="container">
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
        </div>

    </main>

</div>


@endsection

@section('js')

<script>

@if(Auth::user()->is_tutor)
    let calendar;
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'bootstrap',
            initialView: 'timeGridDay',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridDay,timeGridWeek'
            },
            @if(Auth::user()->is_tutor)
                eventColor: '#6749DF',
            @else
                eventColor: '#1F7AFF',
            @endif
            height: 'auto',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectMirror: true,
            nowIndicator: true,
            slotMinTime: "06:00:00",
            slotMaxTime: "23:00:00",
            allDaySlot: false,
            selectOverlap: false,
            validRange: function (nowDate) {
                return {
                    start: nowDate
                };
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

                showAvailableTimeDeleteForm(eventClickInfo.start, eventClickInfo.end, eventClickInfo.event.id);
            },
            events: [
                @foreach(Auth::user()->availableTimes as $time)
                {
                    title: 'Available',
                    start: '{{$time->available_time_start}}',
                    end: '{{$time->available_time_end}}',
                    description: "",
                    id: "{{ $time->id }}",
                    @if(Auth::user()->is_tutor)
                    classNames: ['bg-color-purple-primary', 'fs-1-4', 'hover--pointer'],
                    @else
                    classNames: ['bg-color-blue-primary', 'fs-1-4', 'hover--pointer'],
                    @endif
                },
                @endforeach
                @foreach([] as $upcomingSession)
                {
                    @php
                        $startTime = date("H:i", strtotime($upcomingSession->start_time));
                        $endTime = date("H:i", strtotime($upcomingSession->end_time));
                    @endphp
                    title: 'Scheduled',
                    start: '{{date('Y-m-d', strtotime($upcomingSession->date))}}T{{$startTime}}',
                    // start: '2020-04-25T12:30:00',
                    end: '{{date('Y-m-d', strtotime($upcomingSession->date))}}T{{$endTime}}',
                    description: "",
                    classNames: ['orange-red']
                },
                @endforeach
            ],
        });

        calendar.render();
    });

    $('#availableTimeConfirmationModal form').submit(function(e) {
        e.preventDefault();

        let data = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: "{{ route('availableTime.post') }}",
            data: data,
            success: function success(data) {
                var successMsg = data.successMsg;
                toastr.success(successMsg);
                calendar.addEvent({
                    title: 'Available',
                    start: data.available_time_start,
                    end: data.available_time_end,
                    description: "",
                    id: data.availableTimeId,
                    @if(Auth::user()->is_tutor)
                    classNames: ['bg-color-purple-primary', 'fs-1-4', 'hover--pointer'],
                    @else
                    classNames: ['bg-color-blue-primary', 'fs-1-4', 'hover--pointer'],
                    @endif
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

@endif

    let storageUrl = "{{ Storage::url('') }}";
</script>
<script src="{{ asset('js/home/index.js') }}"></script>
@endsection
