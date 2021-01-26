@php
$tz = App\CustomClass\TimeFormatter::getTZ();
$startDateTime = $request->session_time_start->setTimeZone($tz);
$endDateTime = $request->session_time_end->setTimeZone($tz);
// not accounting for actual day difference
$diffInDays = $endDateTime->format('M/d/Y') != $startDateTime->format('M/d/Y');

@endphp
<div>
    <div class="info-box" data-session-id="{{ $request->id }}">
        <div class="user-info">
            <img src="{{ Storage::url(Auth::user()->is_tutor ? $request->student->profile_pic_url : $request->tutor->profile_pic_url) }}" alt="profile-img">
            @if (Auth::user()->is_tutor)
            <a class="content" href="{{ route('view.profile', $request->student) }}">
                {{ $request->student->first_name }}
                {{ $request->student->last_name }}
            </a>
            @else
            <a class="content" href="{{ route('view.profile', $request->tutor) }}">
                {{ $request->tutor->first_name }}
                {{ $request->tutor->last_name }}
            </a>
            @endif
        </div>
        <div class="date">
            <span class="title">Start Date</span>
            <span class="content">
                {{ $request->session_time_start->setTimeZone($tz)->format('m/d') }}<span class="info-box__year">{{ $request->session_time_start->setTimeZone($tz)->format('/y') }}</span>
                {{ $request->session_time_start->setTimeZone($tz)->format('D') }}
            </span>
        </div>
        <div class="time">
            <span class="title">Time</span>
            <span class="content">
                {{ $request->session_time_start->setTimeZone($tz)->format('H:i') }}
                -
                {{ $request->session_time_end->setTimeZone($tz)->format('H:i') }}
                @if ($diffInDays != 0)
                    (+{{$diffInDays}} day)
                @endif


            </span>
        </div>
        <div class="course">
            <span class="title">Course</span>
            <span class="content">{{ $request->course->course }}</span>
        </div>
        <div class="session-type">
            <span class="title">Type</span>
            <div class="content">{{ $request->is_in_person ? 'In Person' : 'Online' }}</div>
        </div>
        <div class="flex-100"></div>
        <div class="action">
            <button class="btn btn-lg btn-animation-y-sm btn-cancel-request" data-route-url="{{ route('tutor-request.cancel', $request) }}">Cancel</button>
        </div>

    </div>
</div>
