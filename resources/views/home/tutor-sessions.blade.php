@extends('layouts.app')

@section('title', 'Dashboard - Tutor Sessions')

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
<script src='{{asset('fullcalendar/main.min.js')}}'></script>
@endsection

@section('content')

@include('partials.nav')

@if(Auth::user()->is_tutor)
    @include('home.partials.availableTimeConfirmationModal')
    @include('home.partials.availableTimeDeleteConfirmationModal')
@endif

<div class="container-fluid home p-relative">
    @include('home.partials.menu_bar')
    <main class="home__content">
        <div class="container home__header-container">
            <div class="heading-container">
                <p class="heading">Tutor Sessions</p>
                <span>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed enim blanditiis ipsam nesciunt quia culpa eaque eligendi
                </span>
            </div>
            @include('home.partials.header')
        </div>

        <div class="container">
            <div class="row home__row-columns-2">
                <div class="col-lg-8">
                    <h5 class="mb-2 w-100 calendar-heading">Calendar</h5>
                    <div id="calendar" class="w-100"></div>
                    <div class="calendar-note">
                        <span>Available Time</span>
                    </div>
                </div>
                <div class="col-lg-4 info-cards">
                    <div class="d-flex align-items-center justify-content-between mb-1 flex-100">
                        <h5 class="mb-0 ws-no-wrap">Upcoming Sessions</h5>
                        <button class="btn btn-link fs-1-2 fc-grey btn-view-all-info-cards ws-no-wrap">View All</button>
                    </div>
                    @include('home.partials.upcoming_session_card')
                    @include('home.partials.upcoming_session_card')
                    @include('home.partials.upcoming_session_card')
                    @include('home.partials.upcoming_session_card', [
                        'hidden' => true
                    ])
                    @include('home.partials.upcoming_session_card', [
                        'hidden' => true
                    ])
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <h5 class="mb-2 w-100">Past Sessions</h5>
                <div class="info-boxes tutor-requests">
                    @include('home.partials.past_session', [
                        'user' => App\User::find(1)
                    ])

                    @include('home.partials.past_session', [
                        'user' => App\User::find(2)
                    ])

                    @include('home.partials.past_session', [
                        'user' => App\User::find(3)
                    ])

                    @include('home.partials.past_session', [
                        'user' => App\User::find(4)
                    ])

                    @include('home.partials.past_session', [
                        'user' => App\User::find(3)
                    ])

                    @include('home.partials.past_session', [
                        'user' => App\User::find(4)
                    ])

                </div>
                <div class="scroll-faded">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                    <h5>Reviews (5)</h5>
                    <button class="btn btn-link fs-1-4 fc-grey btn-view-all-info-boxes">View All</button>
                </div>
                <div class="info-boxes">
                    @include('home.partials.review', [
                        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium molestiae, ullam hic modi sequi amet, id non voluptatum, repudiandae dicta perspiciatis nihil ab labore cupiditate odio nisi iure minima praesentium?'
                    ])
                    @include('home.partials.review', [
                        'content' => 'He is very nice!'
                    ])
                    @include('home.partials.review', [
                        'content' => 'I love his CSCI 201 course! Best private tutor ever!'
                    ])
                    @include('home.partials.review', [
                        'hidden' => true,
                        'content' => 'No, he is not good'
                    ])
                    @include('home.partials.review', [
                        'hidden' => true,
                        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium molestiae, ullam hic modi sequi amet, id non voluptatum, repudiandae dicta'
                    ])
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
            // timeZone: 'PST',
            themeSystem: 'bootstrap',
            initialView: 'timeGridDay',
            headerToolbar: {
                left: 'prev title next',
                center: '',
                right: 'today timeGridDay timeGridThreeDay'
            },
            eventColor: 'rgb(213, 208, 223)',
            height: 'auto',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectMirror: true,
            nowIndicator: true,
            slotMinTime: "08:00:00",
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
                showAvailableTimeForm(startTime, endTime);
            },
            eventClick: function (eventClickInfo) {
                eventClickInfo.jsEvent.preventDefault(); // don't let the browser navigate
                if (eventClickInfo.event.url) {
                    window.open(eventClickInfo.event.url);
                }
                console.log(eventClickInfo.event);
                if(eventClickInfo.event.extendedProps.type == 'available-time') {
                    showAvailableTimeDeleteForm(eventClickInfo.event.start, eventClickInfo.event.end, eventClickInfo.event.id);
                }

            },
            events: [
                @foreach(Auth::user()->availableTimes as $time)
                {
                    textColor: 'transparent',
                    start: '{{$time->available_time_start}}',
                    end: '{{$time->available_time_end}}',
                    description: "",
                    id: "{{ $time->id }}",
                    type: "available-time",
                    classNames: ['my-available-time', 'hover--pointer']
                },
                @endforeach

                @foreach(Auth::user()->upcomingSessions as $upcomingSession)
                {
                    @php
                        $startTime = date("H:i", strtotime($upcomingSession->session_time_start));
                        $endTime = date("H:i", strtotime($upcomingSession->session_time_end));
                    @endphp
                    @if($upcomingSession->is_in_person)
                    title: 'In Person',
                    extendedProps: {
                        "type": "upcoming-session--inperson"
                    },
                    classNames: ['inperson-session'],
                    @else
                    title: 'Online',
                    extendedProps: {
                        "type": "upcoming-session--online"
                    },
                    classNames: ['online-session'],
                    @endif
                    start: '{{date('Y-m-d', strtotime($upcomingSession->date))}}T{{$startTime}}',
                    end: '{{date('Y-m-d', strtotime($upcomingSession->date))}}T{{$endTime}}',
                    description: "",
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
