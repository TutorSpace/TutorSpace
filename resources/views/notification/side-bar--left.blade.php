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
        Sessions
    </div>
    <div class="type-container">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#FBB752"/>
        </svg>
        Forum
    </div>
    <div class="type-container">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="@if(Auth::user()->is_tutor) #6749DF @else #1F7AFF @endif"/>
        </svg>
        TutorSpace
    </div>
</div>
<ul class="msgs">
    @foreach (Auth::user()->notifications as $notification)
        @if ($notification->type == 'App\Notifications\WelcomeMessageNotification')
            @include('notification.side-bar-notification-msg', [
                'unRead' => $notification->unread(),
                'time' => $notification->created_at,
                'notificationType' => 'tutorspace',
                'notificationHeader' => 'Welcome to TutorSpace',
                'notificationContent' => 'Welcome to TutorSpace!',
                'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\TutorVerificationInitiatedNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at,
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Tutor Verification',
                    'notificationContent' => 'We have received your request to be a verified tutor.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\TutorVerificationCompleted')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at,
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Tutor Verification',
                    'notificationContent' => 'We have successfully processed your tutor verification request.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\InvoicePaymentFailed')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at,
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Payment Failed',
                    'notificationContent' => 'Oops. Your auto-payment failed. Please use the link below to make the payment.',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\InvoicePaid')
            {{-- todo: finish this --}}
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at,
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'Payment Success',
                    'notificationContent' => '',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications\TutorLevelUpNotification')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at,
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => 'New Tutor Level',
                    'notificationContent' => 'Congratulations! You reached the next tutor level!',
                    'notifId' => $notification->id
            ])
        @elseif($notification->type == 'App\Notifications')
            @include('notification.side-bar-notification-msg', [
                    'unRead' => $notification->unread(),
                    'time' => $notification->created_at,
                    'notificationType' => 'tutorspace',
                    'notificationHeader' => '',
                    'notificationContent' => '',
                    'notifId' => $notification->id
            ])
        @endif
    @endforeach

    {{-- @include('notification.side-bar-notification-msg', [
        'unRead' => true,
        'time' => "5:38pm",
        'notificationType' => 'forum',
        'notificationHeader' => 'Marked as Best Reply',
        'notificationContent' => 'Welcome to TutorSpace!'
    ]) --}}

    {{-- @include('notification.side-bar-notification-msg', [
        'time' => "12/30/20",
        'notificationType' => 'sessions',
        'notificationHeader' => 'New Tutor Request',
        'notificationContent' => 'Welcome to TutorSpace!'
    ]) --}}

    {{-- @include('notification.side-bar-notification-msg', [
        'unRead' => true,
        'time' => "12/30/20",
        'notificationType' => 'tutorspace',
        'notificationHeader' => 'TutorSpace',
        'notificationContent' => 'Welcome to TutorSpace!'
    ]) --}}

</ul>
