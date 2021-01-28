@php
$sessionDurationInHour = $session->getDurationInHour();
$price = $session->calculateSessionFee();
$tz = App\CustomClass\TimeFormatter::getTZ();
$diffInDays = $session->session_time_end->setTimeZone($tz)->diff($session->session_time_start->setTimeZone($tz))->days;
$hourlyRate = $session->hourly_rate;
@endphp

<div class="notification__content__header font-weight-bold">
    Session Completed [{{ Illuminate\Support\Str::substr($session->id, 8) }}]
</div>
<div class="notification__content__info">

    <div class="notification__content__info__wrapper">
        <div class="notification__content__info__header bg-primary">
            <img src="{{ Storage::url($session->tutor->profile_pic_url) }}" alt="user photo" class="user-image">
        </div>

        <div class="container content">
            <p class="pt-3 fs-2-4 text-center fw-500">{{ $session->tutor->first_name . ' ' . $session->tutor->last_name }}</p>

            <h6 class="mt-5 color-primary">Session Details</h6>

            <div class="d-flex justify-content-between mt-2">
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Date:</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $session->session_time_start->setTimeZone($tz)->format('m/d/y D') }}</p>
                </div>
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Time: ({{ App\CustomClass\TimeFormatter::getTZShortHand($tz) }} Time)</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $session->session_time_start->setTimeZone($tz)->format('H:i') }} - {{ $session->session_time_end->setTimeZone($tz)->format('H:i') }}</p>

                    @if ($diffInDays != 0)
                        (+{{$diffInDays}} day)
                    @endif
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

            <h6 class="color-primary">Price Summary</h6>
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

            <h6 class="color-primary">Rate Your Tutor</h6>

            <p class="mt-2 fs-1-6">Tutors benefit from your valuable feedback. Click <button class="btn btn-primary fs-1-6" id="btn-rate-tutor" data-route-url="{{ route('session.review', $session) }}">here</button> to rate and comment how you like this session/tutor anonymously.</p>

            <h6 class="color-primary">Having Trouble With This Session?</h6>
            {{-- todo: add link here --}}
            <p class="mt-2 fs-1-6">If you have any concerns regarding your experience in using TutorSpace, our staff are here to help. Please check Help Center first and see if you can find any immediate answer to your questions. If not, please contact us at tutorspacehelp@gmail.com, and we will get back to you in 48 hours.</p>

            <div class="button-container">
                <a class="btn btn-primary" href="mailto:tutorspacehelp@gmail.com" target="_blank">Contact TutorSpace</a>
            </div>
        </div>
    </div>
</div>
