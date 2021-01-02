@extends('layouts.app')

@section('title', 'Notifications')

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

<script src="{{ asset('js/notification/index.js') }}"></script>

@endsection
