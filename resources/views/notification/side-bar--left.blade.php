<h4 class="heading">Notifications</h4>
{{-- <form class="search-bar-container" method="GET" action="#">
    <input type="text" class="search-bar form-control form-control-lg" placeholder="Search...">
    <svg>
        <use xlink:href="{{asset('assets/sprite.svg#icon-magnifying-glass')}}"></use>
    </svg>
</form> --}}
<div class="notification-type-info">
    <div class="type-container">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#F0847D"/>
        </svg>
        <a href="#" class="fc-black-2">Sessions</a>
    </div>
    <div class="type-container">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#FBB752"/>
        </svg>
        <a href="#" class="fc-black-2">Forum</a>
    </div>
    <div class="type-container">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="@if(Auth::user()->is_tutor) #6749DF @else #1F7AFF @endif"/>
        </svg>
        <a href="#" class="fc-black-2">TutorSpace</a>
    </div>
</div>
<ul class="msgs">
    @php
        $tz = App\CustomClass\TimeFormatter::getTZ();
    @endphp
    @foreach (Auth::user()->notifications()->orderBy('created_at', 'desc')->get() as $notification)
        @if ($notification->type == 'App\Notifications\WelcomeMessageNotification')
            @include('notification.side-bar-notification-msg', [
                'unRead' => $notification->unread(),
                'time' => $notification->created_at->setTimeZone($tz),
                'notificationType' => 'tutorspace',
                'notificationHeader' => 'Welcome to TutorSpace',
                'notificationContent' => 'Welcome to TutorSpace!',
                'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\TutorVerificationInitiatedNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Tutor Verification',
                    'notificationContent' => 'We have received your request to be a verified tutor.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\TutorVerificationCompleted')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Tutor Verification',
                    'notificationContent' => 'We have successfully processed your tutor verification request.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\InvoicePaymentFailed')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Payment Failed',
                    'notificationContent' => 'Oops. Your auto-payment failed. Please use the link below to make the payment.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\InvoicePaid')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Payment Success',
                    'notificationContent' => 'Your session is completed. We have successfully received your payment.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\TutorLevelUpNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'New Tutor Level',
                    'notificationContent' => 'Congratulations! You reached the next tutor level!',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\UnpaidInvoiceReminder')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Unpaid Tutoring Session',
                    'notificationContent' => 'You have an unapid tutoring session.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\PayoutFailed')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Payout Failed',
                    'notificationContent' => 'A recent payout to you has failed.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\PayoutPaid')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Payout Success',
                    'notificationContent' => 'You have received a payout.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\InviteToBeTutorNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Invite to be Tutor',
                    'notificationContent' => 'You are invited to be a tutor.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\UserRequestedRefundNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'sessions',
                    'notificationHeader' => 'Refund Request',
                    'notificationContent' => 'We have received your refund request.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\RefundRequestApprovedNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'sessions',
                    'notificationHeader' => 'Refund Success',
                    'notificationContent' => 'We have approved your refund request.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\RefundDeclinedNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'sessions',
                    'notificationHeader' => 'Refund Declined',
                    'notificationContent' => 'We are sorry that your refund request is declined.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\NewTutorRequest')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'sessions',
                    'notificationHeader' => 'New Tutor Request',
                    'notificationContent' => 'You just received a new Tutoring Session Request!',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\TutorRequestAccepted')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'sessions',
                    'notificationHeader' => 'Tutor Request Accepted',
                    'notificationContent' => 'Your tutor request is accepted.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\TutorRequestDeclined')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'sessions',
                    'notificationHeader' => 'Tutor Request Declined',
                    'notificationContent' => 'Your tutor request is declined.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\CancelSessionNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'sessions',
                    'notificationHeader' => 'Session Canceled',
                    'notificationContent' => 'Your session is canceled.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\TutorSessionFinishedNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'sessions',
                    'notificationHeader' => 'Session Finished',
                    'notificationContent' => 'You just finished a tutoring session.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\UnratedTutorNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'sessions',
                    'notificationHeader' => 'Rate your Tutor',
                    'notificationContent' => 'You have not yet rated this tutor. We would really appreciate if you could leave some reviews about your tutor.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\Forum\MarkedAsBestReplyNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'forum',
                    'notificationHeader' => 'Marked as Best Reply',
                    'notificationContent' => 'A reply is marked as best reply.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\Forum\NewReplyAddedNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'forum',
                    'notificationHeader' => 'New Reply Added',
                    'notificationContent' => 'A new reply is added.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\Forum\NewFollowupAddedNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at->setTimeZone($tz),
                    'notificationType' => 'forum',
                    'notificationHeader' => 'Someone Replied to You',
                    'notificationContent' => 'Someone replied to you in a post.',
                    'notifId' => $notification->id
            ])
        @endif
    @endforeach
</ul>
