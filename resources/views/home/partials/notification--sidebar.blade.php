<div class="side-bar__notification @if(isset($hidden) && $hidden) hidden @endif" @if(isset($hidden) && $hidden) data-to-hide="true" @endif data-route="{{ route('notifications.index', 'show-notif=' . $notif->id) }}">
    @if($notif->type == 'App\Notifications\Forum\MarkedAsBestReplyNotification')
    <div class="side-bar__notification--left">
        <div class="side-bar__notification--best-reply"></div>
    </div>
    <div class="side-bar__notification--content">
        <span>Marked as Best Reply</span>
        <span class="subtitle">A reply is marked as best reply.</span>
    </div>

    <div class="side-bar__notification--right">
        <span>{{ $notif->created_at->diffForHumans() }}</span>
    </div>
    @elseif($notif->type == 'App\Notifications\Forum\NewReplyAddedNotification')
    <div class="side-bar__notification--left">
        <div class="side-bar__notification--best-reply"></div>
    </div>
    <div class="side-bar__notification--content">
        <span>New Reply Added</span>
        <span class="subtitle">A new reply is added.</span>
    </div>

    <div class="side-bar__notification--right">
        <span>{{ $notif->created_at->diffForHumans() }}</span>
    </div>
    @elseif($notif->type == 'App\Notifications\Forum\NewFollowupAddedNotification')
    <div class="side-bar__notification--left">
        <div class="side-bar__notification--best-reply"></div>
    </div>
    <div class="side-bar__notification--content">
        <span>Someone Replied to You</span>
        <span class="subtitle">Someone replied to you in a post.</span>
    </div>

    <div class="side-bar__notification--right">
        <span>{{ $notif->created_at->diffForHumans() }}</span>
    </div>
@endif
</div>
