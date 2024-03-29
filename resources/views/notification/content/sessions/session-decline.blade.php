@php
$tz = App\CustomClass\TimeFormatter::getTZ();
$startDateTime = $tutorRequest->session_time_start->setTimeZone($tz);
$endDateTime = $tutorRequest->session_time_end->setTimeZone($tz);
// not accounting for actual day difference
$diffInDays = $endDateTime->format('M/d/Y') != $startDateTime->format('M/d/Y');
$sessionDurationInHour = $tutorRequest->getDurationInHour();
$price = $tutorRequest->calculateSessionFee();
@endphp

<div class="notification__content__header font-weight-bold">
    Tutor Request Declined ({{ $tutorRequest->session_time_start->setTimeZone($tz)->format('m/d/y D') }})
</div>
<div class="notification__content__info">

    <div class="notification__content__info__wrapper">
        <div class="notification__content__info__header bg-primary">
            @if (Illuminate\Support\Str::of($tutorRequest->tutor->profile_pic_url)->contains('placeholder'))
            <div class="user-image placeholder-img">
                <span>{{ strtoupper($tutorRequest->tutor->first_name[0]) . ' ' . strtoupper($tutorRequest->tutor->last_name[0]) }}</span>
            </div>
            @else
            <img src="{{ Storage::url($tutorRequest->tutor->profile_pic_url) }}" alt="user photo" class="user-image">
            @endif
        </div>

        <div class="container content">
            <p class="pt-3 fs-2-4 text-center fw-500">{{ $tutorRequest->tutor->first_name . ' ' . $tutorRequest->tutor->last_name }}</p>

            <h6 class="mt-5 color-primary">Session Details</h6>

            <div class="d-flex justify-content-between mt-2">
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Date:</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $tutorRequest->session_time_start->setTimeZone($tz)->format('m/d/y D') }}</p>
                </div>
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Time: ({{ App\CustomClass\TimeFormatter::getTZShortHand($tz) }} Time)</div>
                    <p class="fc-black-2 fs-1-5 fw-500">
                        {{ $tutorRequest->session_time_start->setTimeZone($tz)->format('H:i') }}
                        -
                        {{ $tutorRequest->session_time_end->setTimeZone($tz)->format('H:i') }}
                        @if ($diffInDays != 0)
                            (+{{$diffInDays}} day)
                        @endif
                    </p>
                </div>
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Course:</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $tutorRequest->course->course }}</p>
                </div>

                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Type:</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $tutorRequest->is_in_person ? 'In Person' : 'Online' }}</p>
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


