@php
    $date = $session->session_time_start->setTimeZone($tz)->format('m/d/y D');
    $sessionDurationInHour = $session->getDurationInHour();
    $price = $session->calculateSessionFee();
    $hourlyRate = $session->hourly_rate;

    $startDateTime = $session->session_time_start->setTimeZone($tz);
    $endDateTime = $session->session_time_end->setTimeZone($tz);
    // not accounting for actual day difference
    $diffInDays = $endDateTime->format('M/d/Y') != $startDateTime->format('M/d/Y');
@endphp

<div class="container modal-session">
    <h6 class="text-center color-primary mt-3">Session Overview</h6>

    <div class="d-flex justify-content-between mt-3">
        <div class="d-flex flex-column">
            <p class="fc-grey fs-1-4 mb-0">{{ Auth::user()->is_tutor ? 'Student Name' : 'Tutor Name' }}:</p>
            <p class="fc-black-2 fs-1-5 fw-500">{{ Auth::user()->is_tutor ? $session->student->first_name : $session->tutor->first_name }} {{ Auth::user()->is_tutor ? $session->student->last_name : $session->tutor->last_name  }}</p>
        </div>
        <div class="d-flex flex-column">
            <p class="fc-grey fs-1-4 mb-0">Date:</p>
            <p class="fc-black-2 fs-1-5 fw-500">{{ $date }}</p>
        </div>
        <div class="d-flex flex-column">
            <p class="fc-grey fs-1-4 mb-0">Time: ({{ App\CustomClass\TimeFormatter::getTZShortHand($tz) }} Time)</p>
            <p class="fc-black-2 fs-1-5 fw-500">
                {{ $session->session_time_start->setTimeZone($tz)->format('H:i') }}
                -
                {{ $session->session_time_end->setTimeZone($tz)->format('H:i') }}
                @if ($diffInDays != 0)
                    (+{{$diffInDays}} day)
                @endif
            </p>
        </div>
        <div class="d-flex flex-column">
            <p class="fc-grey fs-1-4 mb-0">Course:</p>
            <p class="fc-black-2 fs-1-5 fw-500">{{ $session->course->course }}</p>
        </div>
        <div class="d-flex flex-column">
            <p class="fc-grey fs-1-2 mb-0">Type:</p>
            <p class="fc-black-2 fs-1-5 fw-500">{{ $session->is_in_person ? 'In Person' : 'Online' }}</p>
        </div>
        {{-- <div class="d-flex flex-column">
            <p class="fc-grey fs-1-2 mb-0">Price:</p>
            <p class="fs-1-5 fw-500">${{ $price }}</p>
        </div> --}}
    </div>

    <div class="mb-2 fc-black-2 d-flex flex-row justify-content-between">Session Fee (per hour)<span class="fc-theme-color">$ {{ $session->hourly_rate }}</span></div>
    <div class="fc-black-2 d-flex flex-row justify-content-between">Hours<span class="fc-theme-color">x {{ $sessionDurationInHour }}</span></div>
    <hr class="bc-primary"/>
    <div class="font-weight-bold fc-black-2 d-flex flex-row justify-content-between">Total <span class="fc-theme-color">$ {{ $price }}</span></div>

    <p class="fc-black-2 mt-4 fs-1-4"><span class="font-weight-bold">Cancellation Policy: </span>Users can cancel a session at least 24 hours (for students) or 12 hours (for tutors) before the session starts without a penalty. To know more details, please check
        <a href="{{route('cancellation-policy.show')}}" class="color-primary" target="_blank">Cancellation Policy</a>.
    </p>

    <p class="fc-black-2 mt-3 fs-1-4"><span class="font-weight-bold">Refund Policy: </span>TutorSpace will provide a full refund if your tutor does not show up. To know more details, please check
        <a href="{{route('refund-policy.show')}}" class="color-primary" target="_blank">Refund Policy</a>.
    </p>

    <p class="fc-black-2 mt-3 fs-1-4"><span class="font-weight-bold">USC Integrity Policy: </span>Students’ and tutors’ behavior should always align with the USC Integrity Policy. To know more details, please check
        <a href="{{route('usc-integrity-policy.show')}}" class="color-primary" target="_blank">USC Integrity Policy</a>.
    </p>

</div>
