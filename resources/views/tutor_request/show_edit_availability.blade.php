@extends('layouts.loggedin')
@section('title', 'make tutor request')

@section('links-in-head')

<link href='{{asset('packages/core/main.css')}}' rel='stylesheet' />
<link href='{{asset('packages/daygrid/main.css')}}' rel='stylesheet' />
<link href='{{asset('packages/timegrid/main.css')}}' rel='stylesheet' />
<link href='{{asset('packages/bootstrap/main.css')}}' rel='stylesheet' />


<script src='{{asset('packages/core/main.js')}}'></script>
<script src='{{asset('packages/daygrid/main.js')}}'></script>
<script src='{{asset('packages/timegrid/main.js')}}'></script>
<script src='{{asset('packages/interaction/main.js')}}'></script>
<script src='{{asset('packages/bootstrap/main.js')}}'></script>

@endsection


@section('confirm-time-container')
<div id="confirm-time-container">
    <h4 class="mb-3">Confirm Available Time</h4>
    <h6 class="mb-5">
        Are you sure you are available from <span id="start-time"></span> to <span id="end-time"></span>?
    </h6>
    <div class="bottom-container">
        <button class="btn btn-lg btn-outline-primary btn-cancel mr-3" type="button">Cancel</button>
        <button class="btn btn-lg btn-primary btn-submit" type="submit">Submit</button>
    </div>
</div>
@endsection


@section('content')

<div class="container">
    <div>
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
    </div>

    <form action="" class="edit-availability-container" method="POST">
        @csrf
        <h4>Edit Your Availability</h4>
        <div id='calendar'></div>

    </form>


</div>



@endsection

@section('js')

<script src="{{asset('js/edit_availability.js')}}"></script>

@endsection
