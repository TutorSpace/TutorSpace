@php
    $date = $session->session_time_start->format('m/d/y D');

    $hourlyRate = $session->hourly_rate;
    $sessionDurationInHour = round(abs($session->session_time_start->diffInSeconds($session->session_time_end)) / 3600, 2);
    $price = $sessionDurationInHour * $hourlyRate;
@endphp

<div class="container modal-session">
    <h6 class="text-center color-primary mt-4">Session Overview</h6>
    <p class="fc-grey mb-3 mt-3">{{ Auth::user()->is_tutor ? 'Student Name' : 'Tutor Name' }}:<span class="ml-2 fc-black-2">{{ Auth::user()->is_tutor ? $session->student->first_name : $session->student->last_name }} {{ Auth::user()->is_tutor ? $session->tutor->first_name : $session->tutor->last_name  }}</span><p>

    <div class="d-flex justify-content-between">
        <div class="d-flex flex-column">
            <p class="fc-grey fs-1-4 mb-0">Date:</p>
            <p class="fc-black-2 fs-1-4">{{ $date }}</p>
        </div>
        <div class="d-flex flex-column">
            <p class="fc-grey fs-1-4 mb-0">Time:</p>
            <p class="fc-black-2 fs-1-4">{{ $session->session_time_start->format('H:i') }} - {{ $session->session_time_end->format('H:i') }}</p>
        </div>
        <div class="d-flex flex-column">
            <p class="fc-grey fs-1-4 mb-0">Course:</p>
            <p class="fc-black-2 fs-1-4">{{ $session->course->course }}</p>
        </div>
        <div class="d-flex flex-column">
            <p class="fc-grey fs-1-2 mb-0">Format:</p>
            <p class="fc-black-2 fs-1-4">{{ $session->is_in_person ? 'In Person' : 'Online' }}</p>
        </div>
        <div class="d-flex flex-column">
            <p class="fc-grey fs-1-2 mb-0">Price:</p>
            <p class="fs-1-4">${{ $price }}</p>
        </div>
    </div>

    <div id="calendar-view-session" class="mb-5 mt-4 calendar"></div>

    <div class="mb-2 fc-black-2 d-flex flex-row justify-content-between">Session Fee (per hour)<span class="fc-theme-color">$ {{ $session->hourly_rate }}</span></div>
    <div class="fc-black-2 d-flex flex-row justify-content-between">Hours<span class="fc-theme-color">x {{ $sessionDurationInHour }}</span></div>
    <hr class="bc-primary"/>
    <div class="font-weight-bold fc-black-2 d-flex flex-row justify-content-between">Total <span class="fc-theme-color">$ {{ $price }}</span></div>

    <p class="fc-black-2 mt-4 fs-1-4"><span class="font-weight-bold">Cancellation Policy: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod </p>
    <p class="fc-black-2 mt-3 fs-1-4"><span class="font-weight-bold">Refund Policy: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. </p>
    <p class="fc-black-2 mt-3 fs-1-4"><span class="font-weight-bold">USC Integrity Policy: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit,  dolore magna aliqua. </p>
</div>
