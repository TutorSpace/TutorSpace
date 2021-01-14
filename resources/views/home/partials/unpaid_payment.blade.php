@php
$session_time_start = explode(' ',$transaction->session->session_time_start);
$session_time_end = explode(' ',$transaction->session->session_time_end);
$date = $session_time_start[0];
$month = Carbon\Carbon::parse($date)->format('m');
$day_date = Carbon\Carbon::parse($date)->format('d');
$year = Carbon\Carbon::parse($date)->format('y');
$startTime = Carbon\Carbon::parse($session_time_start[1])->format('H:i');
$endTime = Carbon\Carbon::parse($session_time_end[1])->format('H:i');
$day = Carbon\Carbon::parse($date)->format('D');
$hourlyRate = $transaction->session->hourly_rate;
$sessionDurationInHour = round(abs(strtotime($endTime) - strtotime($startTime)) / 3600, 2);
$price = $sessionDurationInHour * $hourlyRate;
@endphp

<form action="{{ route('payment.stripe.redirect-payment', $transaction->session) }}" method="GET">
    <div class="info-box">
        <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
        </svg>
        <div class="user-info">
            <img src="{{ Storage::url($transaction->session->tutor->profile_pic_url) }}" alt="profile-img">
            <a class="content" href="#">
                {{ $transaction->session->tutor->first_name . ' ' . $transaction->session->tutor->last_name }}
            </a>
        </div>
        <div class="date">
            <span class="title">Date</span>
            <span class="content">{{$month}}/{{$day_date}}<span class="info-box__year">/{{$year}}</span>
                {{$day}}</span>
        </div>
        <div class="time">
            <span class="title">Time</span>
            <span class="content">{{$startTime}} - {{$endTime}}</span>
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
            <button class="btn btn-lg btn-animation-y-sm btn-pay">Pay</button>
        </div>
    </div>
</form>
