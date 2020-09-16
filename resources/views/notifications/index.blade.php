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

<div class="notifications container-fluid">
    <div class="row notifications-container">
        <div class="notifications__side-bar--left">
            {{-- @include('notifications.side-bar--left') --}}
        </div>
        <div class="notifications__content">
            {{-- @include('notifications.content') --}}
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="{{ asset('js/notifications/index.js') }}"></script>

@endsection
