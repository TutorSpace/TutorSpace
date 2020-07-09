<div class="overlay-forum-left">
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
    <ul class="forum-left-sm__list">
        <li class="forum-left-sm__list-item">
            <a class="forum-left-sm__list-content" href="#">
                <svg class="forum-left-sm__list-svg">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-fire')}}"></use>
                </svg>
                <span>Popular Posts</span>
            </a>
        </li>
        <li class="forum-left-sm__list-item">
            <a class="forum-left-sm__list-content" href="#">
                <svg class="forum-left-sm__list-svg">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-keyboard')}}"></use>
                </svg>
                <span>My Posts</span>
            </a>
        </li>
        <li class="forum-left-sm__list-item">
            <a class="forum-left-sm__list-content" href="{{ route('my-follows.index') }}">
                <svg class="forum-left-sm__list-svg">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-heart')}}"></use>
                </svg>
                <span>My Follows</span>
            </a>
        </li>
    </ul>
</div>

<section class="col-3 col-lg-20-p forum-left">
    <ul class="forum-left__list">
        <li class="forum-left__list-item">
            <svg class="forum-left__list-svg">
                <use xlink:href="{{asset('assets/sprite.svg#icon-fire')}}"></use>
            </svg>
            <a class="forum-left__list-content" href="#">Popular Posts</a>
        </li>
        <li class="forum-left__list-item">
            <svg class="forum-left__list-svg">
                <use xlink:href="{{asset('assets/sprite.svg#icon-keyboard')}}"></use>
            </svg>
            <a class="forum-left__list-content" href="#">My Posts</a>
        </li>
        <li class="forum-left__list-item">
            <svg class="forum-left__list-svg">
                <use xlink:href="{{asset('assets/sprite.svg#icon-heart')}}"></use>
            </svg>
            <a class="forum-left__list-content" href="{{ route('my-follows.index') }}">My Follows</a>
        </li>
    </ul>

    @if(in_array(Route::current()->getName(), ['posts.show']))
        <div class="user-card">
            <img class="user-image" src="https://storage.googleapis.com/tutorspace-storage/user-profile-photos/4IZ41ITmkNX5Sf1kaEJsIGmYh5YwFHQEaNQQ1rP0.png" alt="user image">
            <a class="user-name" href="">Neno Kim</a>
            <span class="user-info">Business Management</span>
            <span class="user-info">Beginner Tutor</span>
            <button class="btn btn-lg btn-chat btn-animation-y-sm">Chat</button>
            <button class="btn btn-lg btn-request btn-animation-y-sm">Request Tutor Session</button>
        </div>
    @endif

</section>

