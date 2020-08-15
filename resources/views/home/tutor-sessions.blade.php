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
<link href='{{asset('fullcalendar/main.min.css')}}' rel='stylesheet' />
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
            <div class="row">
                <h5 class="mb-2 w-100">You Have 3 New Tutor Requests!</h5>
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
            <div class="row home__row-columns-2">
                <div class="col-lg-8">
                    <h5 class="mb-2 w-100">Calendar</h5>
                    <div id="calendar" class="w-100"></div>
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
                <h5 class="mb-2 w-100">Tutor Requests</h5>
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

                </div>
                <div class="scroll-faded">
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
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridDay timeGridThreeDay'
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
                    duration: { days: 3 },
                    buttonText: '3 day'
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
                showAvailableTimeDeleteForm(eventClickInfo.event.start, eventClickInfo.event.end, eventClickInfo.event.id);
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
                    classNames: ['bg-color-purple-primary', 'hover--pointer'],
                    @else
                    classNames: ['bg-color-blue-primary', 'hover--pointer'],
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
            url: "{{ route('availableTime.store') }}",
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
                    classNames: ['bg-color-purple-primary', '', 'hover--pointer'],
                    @else
                    classNames: ['bg-color-blue-primary', '', 'hover--pointer'],
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
