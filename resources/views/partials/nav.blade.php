<header>
    <nav class="nav p-fixed w-100 d-flex align-items-center
        @if(in_array(Route::current()->getName(), [
                'index'
            ]))
            nav-guest
        @else
            @auth
                @if ($currUser->is_tutor)
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
            
            @else
                <a class="btn ml-auto btn-outline-student btn-sign-in" href="#" id="nav-btn-sign-in">Sign In</a>
            @endauth
        </div>
    </nav>
</header>
