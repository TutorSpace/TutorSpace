@php
$tz = App\CustomClass\TimeFormatter::getTZ();
$startDateTime = $session->session_time_start->setTimeZone($tz);
$endDateTime = $session->session_time_end->setTimeZone($tz);
// not accounting for actual day difference
$diffInDays = $endDateTime->format('M/d/Y') != $startDateTime->format('M/d/Y');
$sessionDurationInHour = $session->getDurationInHour();
$price = $session->calculateSessionFee();
$hourlyRate = $session->hourly_rate;
@endphp

<div class="notification__content__header font-weight-bold">
    Session Confirmation  [{{ Illuminate\Support\Str::substr($session->id, 8) }}]
</div>
<div class="notification__content__info">

    <div class="notification__content__info__wrapper">
        <div class="notification__content__info__header bg-primary">
            @if (Illuminate\Support\Str::of($session->tutor->profile_pic_url)->contains('placeholder'))
            <div class="user-image placeholder-img">
                <span>{{ strtoupper($session->tutor->first_name[0]) . ' ' . strtoupper($session->tutor->last_name[0]) }}</span>
            </div>
            @else
            <img src="{{ Storage::url($session->tutor->profile_pic_url) }}" alt="user photo" class="user-image">
            @endif
        </div>

        <div class="container content">
            <p class="pt-3 fs-2-4 text-center fw-500">{{ $session->tutor->first_name . ' ' . $session->tutor->last_name }}</p>

            <h6 class="mt-5 color-primary">Session Details</h6>

            <div class="d-flex justify-content-between mt-2">
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Date:</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $session->session_time_start->format('m/d/y D') }}</p>
                </div>
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Time: ({{ App\CustomClass\TimeFormatter::getTZShortHand($tz) }} Time)</div>
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
                    <div class="fc-grey fs-1-4">Course:</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $session->course->course }}</p>
                </div>

                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Type:</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $session->is_in_person ? 'In Person' : 'Online' }}</p>
                </div>

                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Price:</div>
                    <p class="color-primary fs-1-5 fw-500">
                       $ {{ $price }}
                    </p>
                </div>
            </div>

            <h6 class="color-primary">Order Summary</h6>
            <p class="fc-black-2 d-flex flex-row justify-content-between fs-1-6 mt-3">Session Fee (per hour)
                <span class="color-primary">$ {{ $hourlyRate }}</span>
            </p>
            <p class="fc-black-2 d-flex flex-row justify-content-between fs-1-6 mt-3">Hours
                <span class="color-primary">x {{ $sessionDurationInHour }}</span>
            </p>
            <hr class="bc-primary mt-3"/>
            <p class="font-weight-bold fc-black-2 d-flex flex-row justify-content-between fs-1-6 mt-3">Total
                <span class="color-primary">$ {{ $price }}</span>
            </p>

            {{-- todo: add link here --}}
            <p class="fc-black-2 fs-1-6"><span class="font-weight-bold">Cancellation Policy: </span>Users can cancel a session at least 24 hours (for students) or 12 hours (for tutors) before the session starts without a penalty. To know more details about the cancellation policy, please click here.</p>

            {{-- todo: add link here --}}
            <p class="fc-black-2 fs-1-6 mt-2"><span class="font-weight-bold">Refund Policy: </span>TutorSpace will provide a full refund if your tutor does not show up. To know more details about the refund policy, please click here.</p>

            <div class="button-container">
                <a class="btn btn-primary" href="mailto:tutorspacehelp@gmail.com" target="_blank">Contact TutorSpace</a>
            </div>
        </div>
    </div>
</div>
