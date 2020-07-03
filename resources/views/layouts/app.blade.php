<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel = "icon" href =
    "{{ asset('assets/images/tutorspace_logo.png') }}"
            type = "image/x-icon">



    <!-- my css -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}" />
    @yield('links-in-head')
</head>
<body class="@yield('body-class')">


    @yield('content')

    {{-- my js --}}
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        @if(session('errorMsg'))
            toastr.error('{{ session('errorMsg') }}');
        @endif
        @if(session('successMsg'))
            toastr.error('{{ session('successMsg') }}');
        @endif
    </script>
    @yield('js')

</body>
</html>
