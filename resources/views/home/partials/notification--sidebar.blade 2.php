@if (isset($isCancellationNotification) && $isCancellationNotification)
<div class="side-bar__notification">
    <div class="side-bar__notification--left">
        <img src="{{ Storage::url(Auth::user()->profile_pic_url) }}" alt="profile img">
    </div>
    <div class="side-bar__notification--content">
        <span>Session Cancelled</span>
        <span class="subtitle">{{ $notificationContent }} &middot; 08/21 Wed</span>
    </div>

    <div class="side-bar__notification--right">
        <span>15 hours ago</span>
    </div>
</div>
@elseif(isset($isBestReplyNotification) && $isBestReplyNotification)
<div class="side-bar__notification">
    <div class="side-bar__notification--left">
        <div class="side-bar__notification--best-reply"></div>
    </div>
    <div class="side-bar__notification--content">
        <span>Marked As Best Reply</span>
        <span class="subtitle">{{ $notificationContent }}</span>
    </div>

    <div class="side-bar__notification--right">
        <span>15 hours ago</span>
    </div>
</div>
@endif
