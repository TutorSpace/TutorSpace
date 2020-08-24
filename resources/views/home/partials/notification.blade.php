<div>
    <div class="info-box">
        <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
        </svg>
        <div class="notification-content">
            @if (isset($isCancellationNotification) && $isCancellationNotification)
            <span class="font-weight-bold mr-2">CANCELLATION:</span> Your Tutor Session has been cancelled by <span class="font-weight-bold">{{ $notificationContent }}</span>.
            @elseif(isset($isBestReplyNotification) && $isBestReplyNotification)
            Your reply to <span class="font-weight-bold font-italic">{{ $notificationContent }}</span> has been marked as best reply.
            @endif


        </div>
        <div class="action">
            <button class="btn btn-lg btn-animation-y-sm btn-view">View</button>
        </div>
    </div>
</div>
