@php
$tz = App\CustomClass\TimeFormatter::getTZ();
$session_time_start = explode(' ',$tutorRequest->session_time_start->setTimeZone($tz));
$session_time_end = explode(' ',$tutorRequest->session_time_end->setTimeZone($tz));
$date = $session_time_start[0];
$month = Carbon\Carbon::parse($date)->format('m');
$day_date = Carbon\Carbon::parse($date)->format('d');
$year = Carbon\Carbon::parse($date)->format('y');
$startTime = Carbon\Carbon::parse($session_time_start[1])->format('H:i');
$endTime = Carbon\Carbon::parse($session_time_end[1])->format('H:i');
$day = Carbon\Carbon::parse($date)->format('D');
$student = App\User::find($tutorRequest->student_id);
$sessionDurationInHour = $tutorRequest->getDurationInHour();
$price = $tutorRequest->calculateSessionFee();

$startDate = $tutorRequest->session_time_start->setTimeZone($tz);
$endDate = $tutorRequest->session_time_end->setTimeZone($tz);
$diffInDays = $endDate->format('M/d/Y') != $startDate->format('M/d/Y');
@endphp

<div>
    <div class="info-box" data-tutorRequest-id="{{$tutorRequest->id}}" data-goto-date="{{$tutorRequest->session_time_start->setTimeZone($tz)->format('Y-m-d')}}" data-goto-time="{{$tutorRequest->session_time_start->setTimeZone($tz)->format('H:i:s')}}" data-session-time-start="{{ $tutorRequest->session_time_start->setTimeZone($tz) }}" data-session-time-end="{{ $tutorRequest->session_time_end->setTimeZone($tz) }}">
        @if(isset($isNotification) && $isNotification)
        <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
        </svg>
        @endif
        <div class="user-info">
            <img src="{{ Storage::url($student->profile_pic_url) }}" alt="profile-img">
            <a class="content" href="{{ route('view.profile', $student) }}">
                {{ $student->first_name . " " . $student->last_name }}
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
            <span class="content">{{ $tutorRequest->course->course }}</span>
        </div>
        <div class="session-type">
            <span class="title">Type</span>
            <span class="content">{{ $tutorRequest->is_in_person ? 'In Person' : 'Online' }}</span>
        </div>
        <div class="price hidden">
            <span class="title">Price</span>
            <span class="content">$ {{ $price }}</span>
        </div>
        <div class="action">
            <button class="btn btn-lg btn-animation-y-sm btn-view-request">View</button>
        </div>
    </div>

    @if (isset($isFirstOne) && $isFirstOne)
    <div class="home__tutor-request-modal">
        <!-- Modal content -->
        <div class="tutor-request-modal__content__close">
            <div class="tutor-request-modal__close">
                <svg width="22" height="24" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="22" height="24" fill="url(#pattern0)"/>
                <defs>
                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0" transform="translate(-0.0454545) scale(0.00213068 0.00195312)"/>
                </pattern>
                <image id="image0" width="512" height="512" xlink:href="data:image/png;base64,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"/>
                </defs>
                </svg>
            </div>
            <div class="tutor-request-modal__content">
                <div class="tutor-request-modal__content__header">
                    <p class="tutor-request-modal__content__header--title">New Tutor Request</p>
                </div>
                <div class="tutor-request-modal__content__profile">
                    <div>
                        <div class="user-info">
                            <img src="{{ Storage::url($student->profile_pic_url) }}" alt="profile-img">
                            <a class="content" href="{{ route('view.profile', $student) }}">
                            </a>
                        </div>
                    </div>
                    <div class="content-box">
                        <div class="date">
                            <span class="title">Date</span>
                            <span class="content"></span>
                        </div>
                        <div class="time">
                            <span class="title">Time ({{ App\CustomClass\TimeFormatter::getTZShortHand($tz) }} Time)</span>
                            <span class="content"></span>
                        </div>
                        <div class="flex-100"></div>
                        <div class="course">
                            <span class="title">Course</span>
                            <span class="content"></span>
                        </div>
                        <div class="session-type">
                            <span class="title">Type</span>
                            <span class="content"></span>
                        </div>
                        <div class="flex-100"></div>
                        <div class="price">
                            <span class="title">Price</span>
                            <span class="content"></span>
                        </div>
                    </div>
                </div>
                <div class="tutor-request-modal__content__calendar">
                    <div class="calendar"></div>
                    <div class="calendar-note">
                        <span class="note">Note: All time shown are based on your <span class="font-weight-bold mr-0">LOCAL</span> Time Zone ({{ App\CustomClass\TimeFormatter::getTZShortHand($tz) }})</span>
                    </div>
                </div>
                <div class="tutor-request-modal__content__policy">
                    {{-- todo: add link here --}}
                    <p><span class="font-weight-bold">Cancellation Policy:</span> Users can cancel a session at least 24 hours (for students) or 12 hours (for tutors) before the session starts without a penalty. To know more details about the cancellation policy, please click here.</p>
                    {{-- todo: add link here --}}
                    <p><span class="font-weight-bold">Refund Policy:</span> TutorSpace will provide a full refund if your tutor does not show up. To know more details about the refund policy, please click here.</p>
                </div>
                <div class="tutor-request-modal__content__confirm">
                    <button
                        class="btn btn-outline-primary tutor-request-modal__content__confirm--decline btn-animation-y-sm mr-5"
                        id="btn-decline-tutor-session">
                        Decline
                    </button>
                    <button
                        class="btn btn-primary tutor-request-modal__content__confirm--confirm btn-animation-y-sm" id="btn-confirm-tutor-session">
                        Confirm Tutoring Session
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
