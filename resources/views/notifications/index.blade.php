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
            <a class="btn btn-link" id="btn-back" href="{{ App\CustomClass\URLManager::getBackURL(route('posts.index')) }}">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Back
            </a>
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
