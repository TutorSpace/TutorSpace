@php
    $tz = App\CustomClass\TimeFormatter::getTZ();
    $diffInDays = $session->session_time_end->setTimeZone($tz)->diff($session->session_time_start->setTimeZone($tz))->days;
@endphp
<div>
    <div class="info-box" data-session-id="{{ $session->id }}">
        <div class="user-info">
            <img src="{{ Storage::url(Auth::user()->is_tutor ? $session->student->profile_pic_url : $session->tutor->profile_pic_url) }}" alt="profile-img">
            @if (Auth::user()->is_tutor)
            <a class="content" href="{{ route('view.profile', $session->student) }}">
                {{ $session->student->first_name }}
                {{ $session->student->last_name }}
            </a>
            @else
            <a class="content" href="{{ route('view.profile', $session->tutor) }}">
                {{ $session->tutor->first_name }}
                {{ $session->tutor->last_name }}
            </a>
            @endif
        </div>
        <div class="date">
            <span class="title">Date</span>
            <span class="content">
                {{ Carbon\Carbon::parse($session->session_time_start)->format('m/d')->setTimeZone($tz) }}<span class="info-box__year">{{ Carbon\Carbon::parse($session->session_time_start)->format('/y')->setTimeZone($tz) }}</span>
                {{ Carbon\Carbon::parse($session->session_time_start)->format('D')->setTimeZone($tz) }}
            </span>
        </div>
        <div class="time">
            <span class="title">Time</span>
            <span class="content">
                {{ Carbon\Carbon::parse($session->session_time_start)->format('H:i')->setTimeZone($tz) }}
                -
                {{ Carbon\Carbon::parse($session->session_time_end)->format('H:i')->setTimeZone($tz) }}
                @if ($diffInDays != 0)
                    (+{{$diffInDays}} day)
                @endif
            </span>
        </div>
        <div class="course">
            <span class="title">Course</span>
            <span class="content">{{ $session->course->course }}</span>
        </div>
        <div class="session-type">
            <span class="title">Type</span>
            <div class="content">{{ $session->is_in_person ? 'In Person' : 'Online' }}</div>
        </div>
        <div class="flex-100"></div>
        <div class="actions">
            <button class="btn btn-lg btn-animation-y-sm btn-cancel-session">Cancel</button>
            <button class="btn btn-lg btn-animation-y-sm btn-view-session">View</button>
        </div>
    </div>
</div>
