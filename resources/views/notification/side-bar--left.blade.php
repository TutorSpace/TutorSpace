<h4 class="heading">Notification</h4>
<form class="search-bar-container" method="GET" action="#">
    <input type="text" class="search-bar form-control form-control-lg" placeholder="Search...">
    <svg>
        <use xlink:href="{{asset('assets/sprite.svg#icon-magnifying-glass')}}"></use>
    </svg>
</form>
<ul class="msgs">
    @include('notification.side-bar-notification-msg', [
        'unRead' => true,
        'time' => "5:38pm",
        'notificationType' => 'forum'
    ])
    @include('notification.side-bar-notification-msg', [
        'unRead' => true,
        'time' => "9/3/20",
        'notificationType' => 'forum'
    ])
    @include('notification.side-bar-notification-msg', [
        'time' => "12/30/20",
        'notificationType' => 'sessions'
    ])
    @include('notification.side-bar-notification-msg', [
        'time' => "12/30/20",
        'notificationType' => 'sessions'
    ])
    @include('notification.side-bar-notification-msg', [
        'unRead' => true,
        'time' => "12/30/20",
        'notificationType' => 'tutorspace'
    ])
    @include('notification.side-bar-notification-msg', [
        'time' => "12/30/20",
        'notificationType' => 'tutorspace'
    ])

    @include('notification.side-bar-notification-msg', [
        'time' => "12/30/20",
        'notificationType' => 'forum'
    ])
    @include('notification.side-bar-notification-msg', [
        'unRead' => true,
        'time' => "12/30/20",
        'notificationType' => 'tutorspace'
    ])
    @include('notification.side-bar-notification-msg', [
        'time' => "12/30/20",
        'notificationType' => 'forum'
    ])
    @include('notification.side-bar-notification-msg', [
        'time' => "12/30/20",
        'notificationType' => 'session'
    ])
    @include('notification.side-bar-notification-msg', [
        'time' => "12/30/20",
        'notificationType' => 'forum'
    ])
    @include('notification.side-bar-notification-msg', [
        'time' => "12/30/20",
        'notificationType' => 'tutorspace'
    ])
    @include('notification.side-bar-notification-msg', [
        'time' => "12/30/20",
        'notificationType' => 'forum'
    ])
    @include('notification.side-bar-notification-msg', [
        'time' => "12/30/20",
        'notificationType' => 'tutorspace'
    ])
</ul>
