<div class="side-bar__notification @if(isset($hidden) && $hidden) hidden @endif" @if(isset($hidden) && $hidden) data-to-hide="true" @endif>
@if(isset($isBestReplyNotification) && $isBestReplyNotification)
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
@endif
</div>
