@extends('layouts.loggedin')
@section('title', 'view upcoming session - tutor')

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
        <h2>Tutoring Session with {{$student->full_name}}</h2>

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
                ${{$user->hourly_rate}}
            </h5>
            {{-- <div>
                <span class="labels">Location</span>
                <h5>
                    {{$session->location ?? 'On Campus'}}
                </h5>
            </div> --}}
        </div>
    </div>

    <div class="session-timer-container">
        <h4 class="mb-2">Session Timer</h4>
        <h5>When the tutor and student are ready to start their tutoring session, both must start the Session Timer to confirm each other’s presence. Remember to turn off the Session Timer when you are done being tutored. The tutor will be paid for the time that was accepted on the Tutoring Request, not the amount of time on the Session Timer.</h5>

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


    <div class="notes-for-student">
        <h4 class="mb-3">Notes for Student</h4>
        <textarea rows="6" class="form-control report-textarea"
        placeholder="Write down any notes or feedback you have for your student. They will receive them at the end of the tutoring session."></textarea>
        <div class="notes-for-student-buttons">
            <button class="btn btn-lg btn-outline-primary" id="btn-reset">Reset</button>
            <button class="btn btn-lg btn-primary" id="btn-share-notes">Share Notes</button>
        </div>
    </div>

</div>

@endsection

@section('js')

<!-- defined javascript -->
<script src="{{asset('js/view_session.js')}}"></script>


@endsection

