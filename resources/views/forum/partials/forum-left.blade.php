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
            <a class="forum-left-sm__list-content" href="{{ route('posts.index') }}">
                <svg class="forum-left-sm__list-svg">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-home')}}"></use>
                </svg>
                <span>Forum</span>
            </a>
        </li>
        <li class="forum-left-sm__list-item">
            <a class="forum-left-sm__list-content" href="{{ route('posts.popular') }}">
                <svg class="forum-left-sm__list-svg">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-fire')}}"></use>
                </svg>
                <span>Popular Posts</span>
            </a>
        </li>
        <li class="forum-left-sm__list-item">
            <a class="forum-left-sm__list-content" href="{{ route('posts.latest') }}">
                <svg class="forum-left-sm__list-svg">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-arrow-up')}}"></use>
                </svg>
                <span>Latest Posts</span>
            </a>
        </li>
        @auth
        <li class="forum-left-sm__list-item">
            <a class="forum-left-sm__list-content" href="{{ route('posts.my-posts') }}">
                <svg class="forum-left-sm__list-svg">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-keyboard')}}"></use>
                </svg>
                <span>My Posts</span>
            </a>
        </li>
        <li class="forum-left-sm__list-item">
            <a class="forum-left-sm__list-content" href="{{ route('posts.my-follows') }}">
                <svg class="forum-left-sm__list-svg">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-heart')}}"></use>
                </svg>
                <span>My Follows</span>
            </a>
        </li>
        @endauth
    </ul>
</div>

<section class="col-3 col-lg-20-p forum-left">
    <ul class="forum-left__list">
        <li class="forum-left__list-item @if(Route::current()->getName() == 'posts.index') current @endif" data-location-href="{{ route('posts.index') }}">
            <svg class="forum-left__list-svg">
                <use xlink:href="{{asset('assets/sprite.svg#icon-home')}}"></use>
            </svg>
            <span class="forum-left__list-content">Forum</span>
        </li>
        <li class="forum-left__list-item @if(Route::current()->getName() == 'posts.popular') current @endif" data-location-href="{{ route('posts.popular') }}">
            <svg class="forum-left__list-svg">
                <use xlink:href="{{asset('assets/sprite.svg#icon-fire')}}"></use>
            </svg>
            <span class="forum-left__list-content">Popular Posts</span>
        </li>
        <li class="forum-left__list-item @if(Route::current()->getName() == 'posts.latest') current @endif" data-location-href="{{ route('posts.latest') }}">
            <svg class="forum-left__list-svg">
                <use xlink:href="{{asset('assets/sprite.svg#icon-arrow-up')}}"></use>
            </svg>
            <span class="forum-left__list-content">Latest Posts</span>
        </li>


        @auth
        <li class="forum-left__list-item @if(Route::current()->getName() == 'posts.my-posts') current @endif" data-location-href="{{ route('posts.my-posts') }}">
            <svg class="forum-left__list-svg">
                <use xlink:href="{{asset('assets/sprite.svg#icon-keyboard')}}"></use>
            </svg>
            <span class="forum-left__list-content">My Posts</span>
        </li>
        <li class="forum-left__list-item @if(Route::current()->getName() == 'posts.my-follows') current @endif" data-location-href="{{ route('posts.my-follows') }}">
            <svg class="forum-left__list-svg">
                <use xlink:href="{{asset('assets/sprite.svg#icon-heart')}}"></use>
            </svg>
            <span class="forum-left__list-content">My Follows</span>
        </li>
        @endauth
    </ul>

    @if(in_array(Route::current()->getName(), ['posts.show']))
        @include('partials.user_card', ['user' => $post->user])
    @endif

</section>

