<h4 class="heading">Notification</h4>
<form class="search-bar-container" method="GET" action="#">
    <input type="text" class="search-bar form-control form-control-lg" placeholder="Search...">
    <svg>
        <use xlink:href="{{asset('assets/sprite.svg#icon-magnifying-glass')}}"></use>
    </svg>
</form>
<div class="notification-type-info">
    <div class="type-container">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#F0847D"/>
        </svg>
        Sessions
    </div>
    <div class="type-container">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#5263FB"/>
        </svg>
        Forum
    </div>
    <div class="type-container">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#FBB752"/>
        </svg>
        TutorSpace
    </div>
</div>
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
        'notificationType' => 'sessions'
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
