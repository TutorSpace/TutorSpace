@php
$hourlyRate = $session->hourly_rate;
$sessionDurationInHour = round(abs($session->session_time_start->diffInSeconds($session->session_time_end)) / 3600, 2);
$price = $sessionDurationInHour * $hourlyRate;
@endphp

<div class="notification__content__header font-weight-bold">
    Session Cancelled ({{ $session->session_time_start->format('m/d/y D') }})
</div>
<div class="notification__content__info">

    <div class="notification__content__info__wrapper">
        <div class="notification__content__info__header bg-primary">
            <img src="{{ Storage::url($session->student->profile_pic_url) }}" alt="user photo" class="user-image">
        </div>

        <div class="container content">
            <p class="pt-3 fs-2-4 text-center fw-500">{{ $session->student->first_name . ' ' . $session->student->last_name }}</p>

            <p class="mt-5 fs-1-8">
                Your session has been <span class="font-weight-bold text-danger">CANCELED</span> by {{ $session->student->first_name . ' ' . $session->student->last_name }}. Session details:
            </p>

            <div class="d-flex justify-content-between mt-4">
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Date:</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $session->session_time_start->format('m/d/y D') }}</p>
                </div>
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Time:</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $session->session_time_start->format('H:i') }} - {{ $session->session_time_end->format('H:i') }}</p>
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
                <a class="btn btn-primary" href="mailto:tutorspaceusc@gmail.com" target="_blank">Contact TutorSpace</a>
            </div>
        </div>
    </div>
</div>

