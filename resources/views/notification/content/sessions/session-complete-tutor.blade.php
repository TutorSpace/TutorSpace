@php
$tz = App\CustomClass\TimeFormatter::getTZ();
$startDateTime = $session->session_time_start->setTimeZone($tz);
$endDateTime = $session->session_time_end->setTimeZone($tz);
$diffInDays = $endDateTime->diff($startDateTime)->days;

$hourlyRate = $session->hourly_rate;
$sessionDurationInHour = round(abs($session->session_time_start->diffInSeconds($session->session_time_end)) / 3600, 2);
$price = $sessionDurationInHour * $hourlyRate;
@endphp

<div class="notification__content__header font-weight-bold">
    Session Completed [{{ Illuminate\Support\Str::substr($session->id, 8) }}]
</div>
<div class="notification__content__info">

    <div class="notification__content__info__wrapper">
        <div class="notification__content__info__header bg-primary"></div>

        <div class="container content">
            <h6 class="color-primary">You would receive your payment in 7 days</h6>
            <p class="fs-1-6 mt-2">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis illo vero itaque, culpa magni
                dolorum optio. Adipisci soluta doloremque, omnis magnam amet velit sed ducimus nobis dolores! Tempora,
                sequi! Molestiae?
            </p>

            <div class="mt-5 color-primary d-flex align-items-center">
                <h6>Tutor Growth Plan:</h6>
                <h6 class="fs-1-8 ml-5">
                    {{ $sessionDurationInHour }} Hour(s) * 10 = <span class="font-weight-bold fc-notification">{{ $sessionDurationInHour * 10 }} Experience Points!</span>
                </h6>
            </div>

            <h6 class="mt-5 color-primary">Session Details</h6>

            <div class="d-flex justify-content-between mt-2">
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Date:</div>
                    <p class="fc-black-2 fs-1-5 fw-500">{{ $session->session_time_start->setTimeZone($tz)->format('m/d/y D') }}</p>
                </div>
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Time:</div>
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

            <h6 class="color-primary">Price Summary</h6>

            <p class="fc-black-2 d-flex flex-row justify-content-between fs-1-6 mt-3">Session Income
                <span class="color-primary">$ {{ $transactionDetails['amount'] / 100 }}</span>
            </p>
            <p class="fc-black-2 d-flex flex-row justify-content-between fs-1-6 mt-3">Session Bonus
                <span class="color-primary">$ {{ $transactionDetails['bonus'] / 100 }}</span>
            </p>
            <p class="fc-black-2 d-flex flex-row justify-content-between fs-1-6 mt-3">Service Fee (10%)
                <span class="color-primary">($ {{ $transactionDetails['application_fee'] / 100 }})</span>
            </p>

            <hr class="bc-primary mt-3"/>
            <p class="font-weight-bold fc-black-2 d-flex flex-row justify-content-between fs-1-6 mt-3">Total
                <span class="color-primary">$ {{ $transactionDetails['tutor_receive'] / 100 }}</span>
            </p>

            <h6 class="color-primary">Having Trouble with this session?</h6>

            <p class="mt-2 fs-1-6">Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque in repudiandae iste fuga illo consectetur facere quidem dolorum. Laborum molestiae ipsam fuga assumenda totam corrupti aut culpa accusamus ut velit.</p>

            <div class="button-container">
                <a class="btn btn-primary" href="mailto:tutorspacehelp@gmail.com">Contact TutorSpace</a>
            </div>
        </div>
    </div>

    {{-- <p class="fc-grey text-center mt-5 fs-1-6">TutorSpace Team <br /> Email: <a class="color-primary" href="mailto:tutorspacehelp@gmail.com">tutorspacehelp@gmail.com</a></p> --}}
</div>
