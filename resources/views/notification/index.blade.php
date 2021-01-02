@extends('layouts.app')

@section('title', 'Notifications')

@section('links-in-head')
{{-- fullcalendar --}}
<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
<script src='{{asset('fullcalendar/main.min.js')}}'></script>
@endsection

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

<div class="notification container-fluid">
    <div class="row notification-container">
        <div class="notification__side-bar--left">
            @include('notification.side-bar--left')
        </div>
        <div class="notification__content">
            {{-- @include('notification.content.sessions.session-complete-tutor') --}}
            {{-- @include('notification.content.sessions.session-complete-student') --}}
            @include('notification.content.sessions.session-cancel-student')
        </div>
    </div>
</div>

@endsection

@section('js')
@include('home.partials.calendar-tutor', ['user' => Auth::user()])
<script>
    let options = Object.assign({}, calendarOptions);
    options.selectAllow = false;
    options.eventClick = null;
    options.headerToolbar = null;
    options.height = 'auto';

    // todo: modify this
    options.slotMinTime = "08:30:00";
    options.slotMaxTime = "11:30:00";

    let e = new FullCalendar.Calendar($('#calendar')[0], options);
    e.render();
    setTimeout(() => {
        e.destroy();
        e.render();
        e.gotoDate('2020-10-25'); // todo: change this
    }, 500);
</script>

@endsection
