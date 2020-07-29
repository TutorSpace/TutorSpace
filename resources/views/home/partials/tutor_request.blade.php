<div class="info-box tutor-request">
    @if(isset($isNotification) && $isNotification)
    <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
    </svg>
    @endif
    <div class="user-info">
        <img src="{{ Storage::url(Auth::user()->profile_pic_url) }}" alt="profile-img">
        <a class="content" href="#">
            Shuaiqing Luo Lorem ipsum dolor sit amet consectetur, adipisicing elit. Harum laborum saepe dolorem hic voluptates obcaecati ipsam deleniti dolorum soluta, laudantium incidunt similique velit laboriosam quos doloremque quasi quas temporibus eius!
        </a>
    </div>
    <div class="date">
        <span class="title">Date</span>
        <span class="content">08/02/2020 Wednesdaydghlsdghsdghsdl</span>
    </div>
    <div class="time">
        <span class="title">Time</span>
        <span class="content">13:30PM - 15:00PMgsdhgdsghlsdghsdgsld</span>
    </div>
    <div class="course">
        <span class="title">Course</span>
        <span class="content">BUAD 304dgsglshgdslgdsg</span>
    </div>
    @if ($forTutor)
    <div class="actions">
        <button class="btn btn-lg btn-animation-y-sm btn-decline">Decline</button>
        <button class="btn btn-lg btn-animation-y-sm btn-accept">Accept</button>
    </div>
    @else
    <div class="status">
        <span class="title">Status</span>
        @if (isset($approved) && $approved)
        <span class="content approved">Approved</span>
        @elseif(isset($approved) && !$approved)
        <span class="content declined">Declined</span>
        @elseif(isset($pending) && $pending)
        <span class="content pending">Pending</span>
        @endif
    </div>
    <div class="action @unless(isset($pending) && $pending) invisible @endunless">
        <button class="btn btn-lg btn-animation-y-sm btn-cancel">Cancel</button>
    </div>
    @endif


</div>
