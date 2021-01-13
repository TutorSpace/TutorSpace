<div>
    <div class="info-box">
        <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
        </svg>
        <div class="user-info">
            <img src="{{ Storage::url($transaction->user->profile_pic_url) }}" alt="profile-img">
            <a class="content" href="#">
                {{ $transaction->user->first_name . ' ' . $transaction->user->last_name }}
            </a>
        </div>
        <div class="date">
            <span class="title">Date</span>
            <span class="content">08/02<span class="info-box__year">/20</span>
                Wed</span>
        </div>
        <div class="time">
            <span class="title">Time</span>
            <span class="content">2:30 - 13:00</span>
        </div>
        <div class="course">
            <span class="title">Course</span>
            <span class="content">BUAD 304</span>
        </div>
        <div class="price">
            <span class="title">Total</span>
            <span class="content">$19.0</span>
        </div>
        <div class="action">
            <button class="btn btn-lg btn-animation-y-sm btn-pay">Pay</button>
        </div>
    </div>
</div>
