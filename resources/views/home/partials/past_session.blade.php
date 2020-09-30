<div>
    <div class="info-box">
        <div class="user-info">
            <img src="{{ Storage::url($user->profile_pic_url) }}" alt="profile-img">
            <a class="content" href="#">
                Shuaiqing Luo
            </a>
        </div>
        <div class="date">
            <div>
                <span class="content">08/02<span class="info-box__year">/20</span> Wed</span>
            </div>
            <span class="content">13:30 - 15:00</span>
        </div>
        <div class="course">
            <span class="content">BUAD 304</span>
        </div>
        <div class="type">
            <div class="content">Online</div>
        </div>
        <div class="status">
            @if ($status == 'pending')
            <div class="content pending">
                Pending <br/>
                Payment
            </div>
            @elseif($status == 'completed')
            <div class="content completed">Completed</div>
            @endif

        </div>
        <div class="price">
            <div class="content">$12.5</div>
        </div>
        <div class="action--toggle">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
            </svg>
        </div>
    </div>
</div>
