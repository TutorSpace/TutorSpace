@extends('layouts.app')

@section('title', "$user->first_name's Profile")

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
<script src='{{asset('fullcalendar/main.min.js')}}'></script>
@endsection

@section('content')

@include('partials.nav')

<main class="container p-relative view-profile">
    <div class="row">
        <a class="btn btn-back" href="{{ App\CustomClass\URLManager::getBackURL(route('search.index')) }}">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
            </svg>
            <span>Back</span>
        </a>
    </div>
    <div class="row">
        <div class="view-profile--left col-3">
            @if ($user->is_tutor)
            @include('home.view_profile.partials.tutor-user-info', [
                'user' => $user
            ])
            @else
            @include('home.view_profile.partials.student-user-info', [
                'user' => $user
            ])
            @endif
        </div>

        <div class="view-profile--right col-9">
            @if($displayForumActivities)
            @include('home.view_profile.partials.forum')
            @else
            <div class="calendar-container">
                <div class="heading">
                    <span class="fs-1-8 fc-grey">Book a Tutor Session</span>
                    <span class="hourly-rate">
                        <span class="color-primary fs-2">
                            $ {{ $user->hourly_rate }}</span>
                            <span class="fs-1-4 fc-grey">
                                /hour
                            </span>
                        </span>
                </div>
                <div id="calendar"></div>
                <div class="calendar-note">
                    <span class="available-time">Available Time</span>
                    <span class="note">Note: All time in the calender are based on PST.</span>
                </div>
            </div>

            <div class="reviews">
                <div class="d-flex justify-content-between align-items-center">
                    @php
                    $reviewCount = $user->aboutReviews->count();
                    @endphp
                    <span class="heading fs-1-8 fc-grey">Session Reviews ({{ $reviewCount }})</span>
                </div>
                <div class="info-boxes">
                    @php
                    $reviews = $user->aboutReviews;
                    $today = \Carbon\Carbon::today();
                    @endphp
                    @foreach($reviews as $review)
                        @include('home.view_profile.partials.review', [
                            'review' => $review,
                            'dateCreated' => $review->created_at ?? $today
                    ])
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

</main>


@endsection

@section('js')
<script>
    let otherUserId = "{{ $user->id }}";
    let otherUserHourlyRate = "{{ $user->hourly_rate }}";

    let courses = [
        @foreach($user->courses as $course)
        {
            id: "{{ $course->id }}",
            course: "{{ $course->course }}"
        },
        @endforeach
    ]
</script>

@if ($user->is_tutor)
    @include('home.view_profile.partials.calendar-view-profile')
@endif

@auth
@include('session.session-js')
@endauth

<script src="{{ asset('js/view_profile/index.js') }}"></script>

<script>
@auth
$('#btn-invite').click(function() {
    $.ajax({
        type:'POST',
        url: "{{ route('invite-to-be-tutor', $user) }}",
        success: (data) => {
            if(data.successMsg) toastr.success(data.successMsg);
            else toastr.error(data.errorMsg);
        },
        error: function(error) {
            toastr.error('Something went wrong!');
            console.log(error);
        }
    });
});
@else
$('#btn-invite, #tutor-profile-request-session, #btn-chat').click(function() {
    $('.overlay-student').show();
});
@endauth
</script>
@endsection
