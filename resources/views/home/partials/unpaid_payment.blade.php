@php
// convert timezone
$tz = App\CustomClass\TimeFormatter::getTZ();
$startDateTime = $transaction->session->session_time_start->setTimeZone($tz);
$endDateTime = $transaction->session->session_time_end->setTimeZone($tz);

$session_time_start = explode(' ',$startDateTime);
$session_time_end = explode(' ',$endDateTime);
$date = $session_time_start[0];
$month = Carbon\Carbon::parse($date)->format('m');
$day_date = Carbon\Carbon::parse($date)->format('d');
$year = Carbon\Carbon::parse($date)->format('y');
$startTime = Carbon\Carbon::parse($session_time_start[1])->format('H:i');
$endTime = Carbon\Carbon::parse($session_time_end[1])->format('H:i');
$day = Carbon\Carbon::parse($date)->format('D');
$sessionDurationInHour = $transaction->session->getDurationInHour();
$price = $transaction->session->calculateSessionFee();

// not accounting for actual day difference
$diffInDays = $endDateTime->format('M/d/Y') != $startDateTime->format('M/d/Y');
@endphp

<div>
    <div class="info-box">
        <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
        </svg>
        <div class="user-info">
            <img src="{{ Storage::url($transaction->session->tutor->profile_pic_url) }}" alt="profile-img">
            <a class="content" href="{{ route('view.profile', $transaction->session->tutor) }}">
                {{ $transaction->session->tutor->first_name . ' ' . $transaction->session->tutor->last_name }}
            </a>
        </div>
        <div class="date">
            <span class="title">Date</span>
            <span class="content">{{$month}}/{{$day_date}}<span class="info-box__year">/{{$year}}</span>
                {{$day}}</span>
        </div>
        <div class="time">
            <span class="title">Time ({{ App\CustomClass\TimeFormatter::getTZShortHand($tz) }} Time)</span>
            <span class="content">
                {{$startTime}} - {{$endTime}}
                @if ($diffInDays != 0)
                    (+{{$diffInDays}} day)
                @endif
            </span>
        </div>
        <div class="course">
            <span class="title">Course</span>
            <span class="content">{{ $transaction->session->course->course }}</span>
        </div>
        <div class="price">
            <span class="title">Price</span>
            <span class="content">$ {{ $price }}</span>
        </div>
        <div class="action">
            <a class="btn btn-lg btn-animation-y-sm btn-pay" href="{{ route('payment.stripe.redirect-payment', $transaction->session) }}">Pay</a>
        </div>
    </div>
</div>
