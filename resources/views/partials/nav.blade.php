<header>
    <nav class="nav p-fixed w-100 d-flex align-items-center
        @if(in_array(Route::current()->getName(), [
                'index'
            ]))
            nav-guest
        @else
            @auth
                @if (Auth::user()->is_tutor)
                    nav-auth nav-auth--tutor
                @else
                    nav-auth nav-auth--student
                @endif
            @else
                nav-guest
            @endauth
        @endif
    ">

        <a class="brand-name" href="@auth{{ route('index') }} @else {{ route('home') }}@endauth">TutorSpace</a>

        <div class="nav-left d-flex align-items-center">
            <a class="nav__item" href="#">Forum</a>
            <a class="nav__item" href="#">Support</a>
            <form action="" method="GET" class="form-search form-search-lg form-search-blue nav__form">
                <input type="text" class="form-control form-control-lg input-search" placeholder="Search for tutors...">
                <svg class="svg-search">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                </svg>
            </form>
        </div>


        <div class="nav-right">
            @auth
                <span class="message-welcome">
                    Hello, {{ Auth::user()->first_name }}!
                </span>
                <div class="nav-right__svg-container">
                    <svg class="svg-message" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    </svg>
                    <svg class="svg-notification" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bell-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                    </svg>
                </div>
                <img src="{{ Storage::url(Auth::user()->profile_pic_url) }}" alt="profile img" class="nav-right__profile-img">
                {{-- @session('showWelcome')

                @else

                @endsession --}}

            @else
                <a class="btn ml-auto btn-outline-student btn-sign-in" href="#" id="nav-btn-sign-in">Sign In</a>
            @endauth
        </div>
    </nav>
</header>
