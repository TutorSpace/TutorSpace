<header>
    <nav class="nav p-fixed w-100 d-flex align-items-center
        @auth
            @if (Auth::user()->is_tutor)
                nav-auth nav-auth--tutor
            @else
                nav-auth nav-auth--student
            @endif
        @else
            nav-guest
        @endauth
    ">


        <a class="brand-name" href="@auth{{ route('index') }} @else {{ route('home') }}@endauth">TutorSpace</a>

        <div class="nav-left d-flex align-items-center">
            <a class="nav__item" href="#">Forum</a>
            <a class="nav__item" href="#">Support</a>
            <form action="" method="GET" class="nav__form p-relative">
                <input type="text" class="nav__form__search form-control form-control-lg">
                <svg class="nav__form__svg">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-user')}}"></use>
                </svg>
            </form>
        </div>


        <div class="nav-right">
            @guest
                <a class="nav__item btn btn-lg ml-auto btn-outline-student" href="#" id="nav-btn-sign-in">Sign In</a>
            @endguest
        </div>
    </nav>
</header>
