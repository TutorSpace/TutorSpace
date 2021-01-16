<div class="
    user-card
    @if (Route::current()->getName() == 'posts.show' && Auth::check() && $user->email == Auth::user()->email)
    hidden
    @endif
    "
    data-user-id="{{ $user->id }}"
>
    @unless ((Auth::check() && Auth::user()->is_tutor) || !$user->is_tutor)
    <svg class="svg-bookmark" data-user-id="{{ $user->id }}">
        @if(!Auth::check() || Auth::user()->bookmarkedUsers()->where('id', $user->id)->doesntExist()))
        <use class="" xlink:href="{{asset('assets/sprite.svg#icon-bookmark-empty')}}"></use>
        <use class="hidden bookmarked" xlink:href="{{asset('assets/sprite.svg#icon-bookmark-fill')}}"></use>
        @else
        <use class="hidden" xlink:href="{{asset('assets/sprite.svg#icon-bookmark-empty')}}"></use>
        <use class="bookmarked" xlink:href="{{asset('assets/sprite.svg#icon-bookmark-fill')}}"></use>
        @endif
    </svg>
    @endunless

    <img class="user-image" src="{{ Storage::url($user->profile_pic_url) }}" alt="user image">

    <a class="user-name" href="{{ route('view.profile', $user->id) }}">
        {{ $user->first_name }} {{ $user->last_name }}
    </a>

    @if ($user->firstMajor)
    <span class="user-info text-capitalize text-center  mt-1">
        {{ $user->firstMajor->major }}
    </span>
    @endif

    @if ($user->is_tutor)
    <span class="user-info text-capitalize mt-1 d-flex justify-content-center align-items-center">
        @if ($user->is_tutor_verified)
        @include('partials.svg-tutor-verified')
        @endif
        {{ $user->tutorLevel->tutor_level }} Tutor
    </span>
    <a class="btn btn-lg btn-chat btn-animation-y-sm mt-4" href="{{ route('chatting.index') }}">Chat</a>
    <a class="btn btn-lg btn-request btn-animation-y-sm" href="{{ route('view.profile', $user->id) }}">Request a Session</a>

    @else
    <span class="user-info mt-1">Student</span>
    <a class="btn btn-chat btn-animation-y-sm mt-4" href="{{ route('chatting.index') }}">Chat</a>

    @if (!App\User::existTutor($user->email))
    <button class="btn btn-lg btn-invite btn-animation-y-sm">Invite to be a Tutor</button>
    @endif
    @endif

</div>
