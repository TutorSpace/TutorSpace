@php
$hourlyRate = $session->hourly_rate;
$sessionDurationInHour = round(abs($session->session_time_start->diffInSeconds($session->session_time_end)) / 3600, 2);
$price = $sessionDurationInHour * $hourlyRate;
@endphp

<div class="notification__content__header font-weight-bold">
    Refund Request Declined
</div>
<div class="notification__content__info">

    <div class="notification__content__info__wrapper">
        <div class="notification__content__info__header bg-primary"></div>

        <div class="container content">
            <h6 class="color-primary">
                We are sorry to inform you that your refund request has been declined.
            </h6>
            <p class="fs-1-6 mt-2">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis illo vero itaque, culpa magni
                dolorum optio. Adipisci soluta doloremque, omnis magnam amet velit sed ducimus nobis dolores! Tempora,
                sequi! Molestiae?
            </p>


            <div class="d-flex justify-content-between mt-2">
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
