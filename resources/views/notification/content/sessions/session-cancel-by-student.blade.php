@php
$tz = App\CustomClass\TimeFormatter::getTZ();
$startDateTime = $session->session_time_start->setTimeZone($tz);
$endDateTime = $session->session_time_end->setTimeZone($tz);
// not accounting for actual day difference
$diffInDays = $endDateTime->format('M/d/Y') != $startDateTime->format('M/d/Y');
$sessionDurationInHour = $session->getDurationInHour();
$price = $session->calculateSessionFee();
@endphp

<div class="notification__content__header font-weight-bold">
    Session Cancelled [{{ Illuminate\Support\Str::substr($session->id, 8) }}]
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

            <p class="mt-5 fs-1-8">
                Your session has been <span class="font-weight-bold text-danger">CANCELED</span>. @if($tooLate) You will be charged <span class="font-weight-bold text-danger">$5</span> for this cancelation. @endif
            </p>

            <h6 class="color-primary">
                Session Details
            </h6>

            <div class="d-flex justify-content-between mt-2">
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Date:</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $session->session_time_start->setTimeZone($tz)->format('m/d/y D') }}</p>
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

            <div class="button-container">
                <a class="btn btn-primary" href="mailto:tutorspacehelp@gmail.com" target="_blank">Contact TutorSpace</a>
            </div>
        </div>
    </div>
</div>

