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
            <circle cx="7.5" cy="7.5" r="7.5" fill="#A5BE0D"/>
        </svg>
        <a href="{{ route('notifications.index') }}" class="fc-black-2">All</a>
    </div>
    <div class="type-container">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#F0847D"/>
        </svg>
        <a href="{{ route('notifications.index') . '?showSessions=true' }}" class="fc-black-2">Sessions</a>
    </div>
    <div class="type-container">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#FBB752"/>
        </svg>
        <a href="{{ route('notifications.index') . '?showForum=true' }}" class="fc-black-2">Forum</a>
    </div>
    <div class="type-container">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="@if(Auth::user()->is_tutor) #6749DF @else #1F7AFF @endif"/>
        </svg>
        <a href="{{ route('notifications.index') . '?showTutorSpace=true' }}" class="fc-black-2">TutorSpace</a>
    </div>
</div>
<ul class="msgs">
    @php
        $tz = App\CustomClass\TimeFormatter::getTZ();

        $sessionTypes = [
            'App\Notifications\UserRequestedRefundNotification',
            'App\Notifications\RefundRequestApprovedNotification',
            'App\Notifications\RefundDeclinedNotification',
            'App\Notifications\NewTutorRequest',
            'App\Notifications\TutorRequestAccepted',
            'App\Notifications\TutorRequestDeclined',
            'App\Notifications\CancelSessionNotification',
            'App\Notifications\TutorSessionFinishedNotification',
            'App\Notifications\UnratedTutorNotification',
        ];

        $forumTypes = [
            'App\Notifications\Forum\MarkedAsBestReplyNotification',
            'App\Notifications\Forum\NewReplyAddedNotification',
            'App\Notifications\Forum\NewFollowupAddedNotification',
        ];

        $tutorSpaceTypes = [
            'App\Notifications\WelcomeMessageNotification',
            'App\Notifications\ReferralRegisterSuccessNotification',
            'App\Notifications\TutorVerificationInitiatedNotification',
            'App\Notifications\TutorVerificationCompleted',
            'App\Notifications\InvoicePaymentFailed',
            'App\Notifications\InvoicePaid',
            'App\Notifications\TutorLevelUpNotification',
            'App\Notifications\UnpaidInvoiceReminder',
            'App\Notifications\PayoutFailed',
            'App\Notifications\PayoutPaid',
            'App\Notifications\InviteToBeTutorNotification',
        ];
    @endphp
    @if ($showSessions)
        @foreach (Auth::user()->notifications()->whereIn('type', $sessionTypes)->orderBy('created_at', 'desc')->get() as $notification)
            @include('notification.notifications', [
                'notification' => $notification
            ])
        @endforeach
    @elseif($showForum)
        @foreach (Auth::user()->notifications()->whereIn('type', $forumTypes)->orderBy('created_at', 'desc')->get() as $notification)
            @include('notification.notifications', [
                'notification' => $notification
            ])
        @endforeach
    @elseif($showTutorSpace)
        @foreach (Auth::user()->notifications()->whereIn('type', $tutorSpaceTypes)->orderBy('created_at', 'desc')->get() as $notification)
            @include('notification.notifications', [
                'notification' => $notification
            ])
        @endforeach
    @else
        @foreach (Auth::user()->notifications()->orderBy('created_at', 'desc')->get() as $notification)
            @include('notification.notifications', [
                'notification' => $notification
            ])
        @endforeach
    @endif
</ul>
