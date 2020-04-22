@extends('layouts.loggedin')
@section('title', 'view upcoming session - student')

@section('content')
<div class="container black">
    @if(!$from)
        <a class="btn btn-lg back-button" id="back-button" href="/home">
            <svg>
                <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
            </svg>
            Back to Home
        </a>
    @elseif($from == 'search')
        <a class="btn btn-lg back-button" id="back-button" href="/search?navInput=">
            <svg>
                <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
            </svg>
            Back to Search
        </a>
    @else
        <a class="btn btn-lg back-button" id="back-button" href="/{{$from}}">
            <svg>
                <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
            </svg>
            Back to {{ucwords($from)}}
        </a>
    @endif
    <div class="view-tutor-session__header">
        <h2>Tutoring Session with {{$tutor->full_name}}</h2>
        <a class="btn btn-lg btn-outline-primary" id="report-button" href="/report/{{$tutor->id}}">Report a Problem</a>
    </div>

    <div class="session-details-container">
        <h4 class="mb-2">Session Details</h4>
        <div class="session-details">
            <span class="labels">Date</span>
            <span class="labels">Subject / Course</span>
            <h5>
                {{date('m/d/Y', strtotime($session->date))}}
            </h5>
            <h5>
                {{$session->courseSubject()}}
            </h5>
            <span class="labels">Time</span>
            <span class="labels">Hourly Rate</span>
            <h5>{{$session->start_time}} - {{$session->end_time}}</h5>
            <h5>
                ${{$tutor->hourly_rate}}
            </h5>
            <div>
                <span class="labels">Location</span>
                <h5>
                    {{$session->location ?? 'On Campus'}}
                </h5>
            </div>

            {{-- <span class="labels">Location</span>
            <span class="labels">Payment Account</span>
            <h5>OHE 215</h5>
            <select class="form-control form-control-lg">
                <option selected></option>
                <option>Ketchup</option>
                <option>Relish</option>
            </select> --}}

        </div>
    </div>

    <div class="session-timer-container">
        <h4 class="mb-2">Session Timer</h4>
        <h5>When the tutor and student are ready to start their tutoring session, both must start the Session Timer to
            confirm each other’s presence. Remember to turn off the Session Timer when you are done being tutored. The
            tutor will be paid for the time that was accepted on the Tutoring Request, not the amount of time on the
            Session Timer.</h5>

        <div class="row session-timer">
            <div class="col-4 session-timer-left">
                <button class="btn btn-lg btn-primary" id="start-timer">Start</button>
                {{-- <button class="btn btn-lg btn-outline-primary" id="clear-timer">Clear</button> --}}
                <button class="btn btn-lg btn-outline-primary" id="stop-timer">Stop</button>
            </div>
            <div class="col-8 session-timer-right">
                <span id="timer">
                    <span id="hour">00</span>:<span id="minute">00</span>:<span id="second">00</span>
                </span>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<!-- defined javascript -->
<script src="{{asset('js/view_session.js')}}"></script>


@endsection
