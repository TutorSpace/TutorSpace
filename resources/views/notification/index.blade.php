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
            {{-- @include('notification.content.sessions.session-cancel') --}}
            {{-- @include('notification.content.sessions.session-decline') --}}
            {{-- @include('notification.content.sessions.session-confirmation-student') --}}
            @include('notification.content.sessions.session-confirmation-tutor')


        </div>
    </div>
</div>

@endsection

