@php

$session_time_start = explode(' ',$session->session_time_start);
$session_time_end = explode(' ',$session->session_time_end);
$date = $session_time_start[0];
$month = Carbon\Carbon::parse($date)->format('m');
$day_date = Carbon\Carbon::parse($date)->format('d');
$year = Carbon\Carbon::parse($date)->format('y');
$startTime = Carbon\Carbon::parse($session_time_start[1])->format('H:i');
$endTime = Carbon\Carbon::parse($session_time_end[1])->format('H:i');
$day = Carbon\Carbon::parse($date)->format('D');
$student = App\User::find($session->student_id);
@endphp

<div class="info-card @if(isset($hidden) && $hidden) hidden-2 @endif" data-session-id="{{ $session->id }}">
    <div class="d-flex justify-content-between align-items-center">
        <a class="user-name" href="{{ route('view.profile', $user) }}">
            {{ $user->first_name }} {{ $user->last_name }}
        </a>
        <div class="p-relative">
            <svg class="action-toggle" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
            </svg>
            <ul class="action-toggle__content">
                <li class="d-flex align-items-center justify-content-center">
                    <svg>
                        <use xlink:href="{{asset('assets/sprite.svg#icon-blocked')}}"></use>
                    </svg>
                    <button class="btn px-0 py-0 fs-1-6 btn-cancel-session" type="button">Cancel</button>
                </li>
            </ul>
        </div>
    </div>
    <div class="info-card__row">
        <div class="row-left">
            <small class="title">Date</small>
            <span class="content">{{ $month }}/{{ $day_date }}<span class="info-card__year">/{{ $year }}</span> {{ $day }}</span>
        </div>
        <div class="row-right">
            <small class="title">Course</small>
            <span class="content">{{ $session->course->course }}</span>
        </div>
    </div>
    <div class="info-card__row">
        <div class="row-left">
            <small class="title">Time</small>
            <span class="content">{{$startTime}} - {{$endTime}}</span>
        </div>
        <div class="row-right d-flex align-items-center">
            <button class="btn btn-primary btn-view btn-view-session">View</button>
        </div>
    </div>
</div>
