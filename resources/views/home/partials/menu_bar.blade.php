<div class="toggle-customized color-primary">
    <div class="toggle-container toggle-collapsed">
        <svg class="svg-toggle" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-right-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.14 8.753l-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
        </svg>
    </div>
    <div class="toggle-container toggle-expanded">
        <svg class="svg-toggle" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-right-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.14 8.753l-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
        </svg>
    </div>
    <ul class="toggle-after-list">
        <li class="toggle-after-list-item">
            <a class="toggle-after-list-content" href="{{ route('home') }}">
                <svg class="toggle-after-list-svg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M6 1H1v3h5V1zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12h-5v3h5v-3zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8H1v7h5V8zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6h-5v7h5V1zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z"/>
                </svg>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="toggle-after-list-item">
            <a class="toggle-after-list-content" href="{{ route('home.tutor-sessions') }}">
                <svg class="toggle-after-list-svg">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-study')}}"></use>
                </svg>
                <span>Tutoring sessions</span>
            </a>
        </li>
        <li class="toggle-after-list-item">
            <a class="toggle-after-list-content" href="{{ route('home.forum-activities') }}">
                <svg class="toggle-after-list-svg">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-pencil')}}"></use>
                </svg>
                <span>Forum Activities</span>
            </a>
        </li>
        <li class="toggle-after-list-item">
            <a class="toggle-after-list-content" href="{{ route('home.profile') }}">
                <svg class="toggle-after-list-svg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                </svg>
                <span>Profile Settings</span>
            </a>
        </li>
    </ul>
</div>

<nav class="menu-bar">
    <ul class="menu-bar__lists">
        <li @if(Route::current()->getName() == 'home') class="active" @endif>
            <a href="{{ route('home') }}">
                <span>Dashboard</span>
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right arrow" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </a>
        </li>
        <li @if(Route::current()->getName() == 'home.tutor-sessions') class="active" @endif>
            <a href="{{ route('home.tutor-sessions') }}">
                <span>Tutoring sessions</span>
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right arrow" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </a>
        </li>
        <li @if(Route::current()->getName() == 'home.forum-activities') class="active" @endif>
            <a href="{{ route('home.forum-activities') }}">
                <span>Forum Activities</span>
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right arrow" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </a>
        </li>
        <li @if(Route::current()->getName() == 'home.profile') class="active" @endif>
            <a href="{{ route('home.profile') }}">
                <div class="menu-bar-notification">
                    <span>Profile Settings</span>
                    @if(
                    (Auth::user()->is_tutor && Auth::user()->tutor_verification_status == "unsubmitted")
                    || (Auth::user()->is_tutor && !Auth::user()->tutorHasStripeAccount())
                    || (!Auth::user()->is_tutor && !app(App\Http\Controllers\Payment\StripeApiController::class)->customerHasCards())
                    || Auth::user()->tags()->doesntExist()
                    || Auth::user()->courses()->doesntExist()
                    )
                        <span class="notification-dot">
                            <svg width="7" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
                            </svg>
                        </span>
                    @endif
                </div>

                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right arrow" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                </svg>

            </a>
        </li>
    </ul>
</nav>
