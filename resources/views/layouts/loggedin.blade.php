<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>


    <!-- my css for all pages, including bootstrap-->
    <link rel="stylesheet" href="{{asset('css/main.css')}}" />
    {{-- css for toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

    @yield('links-in-head')


</head>

<body class="animsition @yield('body-class')">
    <div id="background-cover">
        @yield('add-post-container')
    </div>

        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px" y="0px" viewBox="0 0 1440 320" style="enable-background:new 0 0 1440 320;" xml:space="preserve"
            class="svg-nav">

            <path class="st0 @yield('st0-white')" d="M0,82l80,5.5c80,5.3,240,16.6,400,10.9s320-27.2,480-30.1c160-2.7,320,13.7,400,21.9l80,8.2V0h-80
   c-80,0-240,0-400,0S640,0,480,0S160,0,80,0H0V82z" />
        </svg>


        <nav class="nav nav-login @yield('nav-container-white')">
            <div class="nav-container">
                @yield('nav-white')
                <div class="svg-logo-container" id="logo">
                    <svg width="106" height="33" viewBox="0 0 106 33" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="svg-logo">
                        <path
                            d="M9.40296 0C9.40296 2.37617 9.40296 4.7594 9.40296 7.26954C11.1101 7.26954 12.6933 7.26954 14.366 7.26954C14.366 8.94766 14.366 10.4918 14.366 12.2052C12.7759 12.2052 11.1583 12.2052 9.40296 12.2052C9.40296 18.96 9.40296 25.5527 9.40296 32.2158C7.59258 32.2158 5.93364 32.2158 4.17145 32.2158C4.17145 25.5809 4.17145 19.0164 4.17145 12.2193C2.71213 12.2193 1.35606 12.2193 0 12.2193C0 10.5764 0 8.92651 0 7.28364C1.34918 7.28364 2.69836 7.28364 4.13015 7.28364C4.12326 4.72414 4.12326 2.36207 4.12326 0C5.88546 0 7.64077 0 9.40296 0Z"
                            fill="#2C86C5" />
                        <path
                            d="M53.4575 0C53.4575 2.37617 53.4575 4.75235 53.4575 7.26249C55.1577 7.26249 56.741 7.26249 58.4137 7.26249C58.4137 8.96882 58.4137 10.5412 58.4137 12.2334C56.7891 12.2334 55.199 12.2334 53.4781 12.2334C53.4781 18.9389 53.4781 25.5245 53.4781 32.2017C51.6815 32.2017 50.0226 32.2017 48.226 32.2017C48.226 25.602 48.226 19.0164 48.226 12.2898C46.8148 12.2898 45.5414 12.2898 44.1853 12.2898C44.1853 10.5694 44.1853 8.98997 44.1853 7.31184C45.4794 7.31184 46.7253 7.31184 48.1847 7.31184C48.1778 4.80875 48.1778 2.40438 48.1778 0C49.94 0 51.6953 0 53.4575 0Z"
                            fill="#2C86C5" />
                        <path
                            d="M106 7.29166C105.463 8.94863 104.926 10.6127 104.375 12.319C104.1 12.2908 103.866 12.2978 103.653 12.2485C101.14 11.6068 99.4398 12.8831 98.0975 14.808C96.9686 16.4297 96.3697 18.27 96.3834 20.3007C96.4041 23.8262 96.3903 27.3446 96.3903 30.8701C96.3903 31.2931 96.3903 31.7162 96.3903 32.2097C94.6212 32.2097 92.9623 32.2097 91.2139 32.2097C91.2139 23.9319 91.2139 15.6964 91.2139 7.36922C92.8866 7.36922 94.5042 7.36922 96.232 7.36922C96.2802 8.22238 96.3215 9.06145 96.3766 10.1191C99.0061 6.78399 102.241 6.00133 105.993 7.04487C106 7.12948 106 7.2141 106 7.29166Z"
                            fill="#2C86C5" />
                        <path
                            d="M74.2111 6.81159C67.1072 6.71993 60.9464 12.6921 60.8432 19.7783C60.7468 26.7517 66.8388 32.886 73.9908 32.9988C80.7436 33.1046 86.6979 27.069 86.8011 20.0251C86.9113 13.1081 80.9914 6.90325 74.2111 6.81159ZM73.9151 27.7106C69.6404 27.6965 66.0059 24.1146 66.0265 19.9334C66.0472 15.6464 69.6541 12.0787 73.9839 12.0787C78.2173 12.0716 81.7555 15.6817 81.7211 19.9687C81.6935 24.1428 78.0865 27.7247 73.9151 27.7106Z"
                            fill="#2C86C5" />
                        <path
                            d="M18.5712 15.8215C20.3747 15.8215 22.0336 15.8215 23.8578 15.8215C23.8578 17.4644 23.8233 19.0579 23.8715 20.6444C23.8991 21.7302 23.9266 22.8443 24.14 23.9019C24.5943 26.1371 26.1018 27.4626 28.2426 27.7094C30.9134 28.0197 32.9097 27.1524 33.8045 25.0089C34.2726 23.8948 34.486 22.6116 34.5686 21.3847C34.6925 19.5656 34.603 17.7253 34.603 15.8145C36.3377 15.8145 37.9553 15.8145 39.5592 15.8145C39.6212 15.9061 39.7038 15.9696 39.7038 16.033C39.7038 18.7335 39.8965 21.4482 39.6418 24.1205C39.1462 29.2606 34.7751 32.8989 29.3233 32.9835C23.0042 33.0893 18.6056 28.6754 18.5712 22.1885C18.5643 20.1014 18.5712 18.0002 18.5712 15.8215Z"
                            fill="#2C86C5" />
                        <path
                            d="M21.0979 9.22255C21.1323 7.77006 22.3576 6.55729 23.7619 6.59255C25.1592 6.6278 26.357 7.91813 26.3157 9.34947C26.2744 10.7949 25.0147 12.0359 23.638 11.9795C22.2131 11.9301 21.0635 10.6821 21.0979 9.22255Z"
                            fill="#2C86C5" />
                        <path
                            d="M37.2464 9.30068C37.2395 10.8166 36.0762 12.0153 34.6444 11.98C33.2539 11.9448 32.1113 10.7602 32.0906 9.32888C32.07 7.84818 33.2402 6.60016 34.6719 6.58606C36.1106 6.57196 37.2533 7.77062 37.2464 9.30068Z"
                            fill="#2C86C5" />
                    </svg>
                </div>
                <div class="button-container">
                    <a href="/home">Home</a>
                    <a href="/messages">Messages</a>
                    <form class="search-box" action="/search" method="GET">
                        <svg>
                            <use xlink:href="{{asset('assets/sprite.svg#icon-magnifying-glass')}}"></use>
                        </svg>
                        <input type="text" placeholder="Search a course or name" type="submit">
                    </form>
                </div>
                <div class="user-photo-container">
                    <div class="p-relative">
                        <img src="{{asset('assets/sophia.png')}}" alt="user photo" id="tutor-profile-photo">
                        <div class="nav__dropdown-container">
                            <p class="name">Jamie Chang</p>
                            <div class="profile-container">
                                <span class="profile">Profile</span>
                            </div>
                            <div class="log-out-container">
                                <span class="log-out">Log Out</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </nav>


        @yield('content')


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>


    {{-- js for toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>


    {{-- my js for bootstrap --}}
    <script src="{{asset('js/app.js')}}"></script>

    {{-- my js for nav --}}
    <script src="{{asset('js/nav.js')}}"></script>

    {{-- my js for bookmark --}}
    <script src="{{asset('js/bookmark.js')}}"></script>


    @yield('js')

</body>

</html>
