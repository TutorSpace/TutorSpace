<div>
    <div class="info-box" data-session-id="{{ $session->id }}">
        <div class="user-info">
            <img src="{{ Storage::url(Auth::user()->is_tutor ? $session->student->profile_pic_url : $session->tutor->profile_pic_url) }}" alt="profile-img">
            <a class="content" href="#">
                @if (Auth::user()->is_tutor)
                    {{ $session->student->first_name }}
                    {{ $session->student->last_name }}
                @else
                    {{ $session->tutor->first_name }}
                    {{ $session->tutor->last_name }}
                @endif
            </a>
        </div>
        <div class="date">
            <span class="title">Date</span>
            <span class="content">
                {{ date("m/d", strtotime($session->session_time_start)) }}<span class="info-box__year">{{ date("/y", strtotime($session->session_time_start)) }}</span>
                {{ date("D", strtotime($session->session_time_start)) }}
            </span>
        </div>
        <div class="time">
            <span class="title">Time</span>
            <span class="content">
                {{ date("H:i", strtotime($session->session_time_start)) }}
                -
                {{ date("H:i", strtotime($session->session_time_end)) }}
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
