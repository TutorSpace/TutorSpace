@if (isset($isCancellationNotification) && $isCancellationNotification)
<div class="notification">
    <div class="notification--left">
        <img src="{{ Storage::url(Auth::user()->profile_pic_url) }}" alt="profile img">
    </div>
    <div class="notification--content">
        <span>Session Cancelled</span>
        <span class="subtitle">{{ $notificationContent }} &middot; 08/21/20</span>
    </div>

    <div class="notification--right">
        <span>15 hours ago</span>
    </div>
</div>
@elseif(isset($isBestReplyNotification) && $isBestReplyNotification)
<div class="notification">
    <div class="notification--left">
        <div class="notification--best-reply"></div>
    </div>
    <div class="notification--content">
        <span>Marked As Best Reply</span>
        <span class="subtitle">{{ $notificationContent }}</span>
    </div>

    <div class="notification--right">
        <span>15 hours ago</span>
    </div>
</div>
@endif
