<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title')</title>

    {{-- google services --}}
    <meta name="google-signin-client_id" content="{{ env('GOOGLE_CLIENT_ID') }}">

    {{-- tinymec (rich editor) --}}
    <script src="https://cdn.tiny.cloud/1/0g5x4ywp59ytu15qbexxmx02e1mxg5eudd75k8p0kicery2n/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

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
            @php
                session()->forget('errorMsg');
            @endphp
        @endif
        @if(session('successMsg'))
            toastr.success('{{ session('successMsg') }}');
            @php
                session()->forget('successMsg');
            @endphp
        @endif

        // for footer subscribe button
        $('#footer__form-subscribe').submit(function(e) {
            e.preventDefault();
            if(!$(this).find('input[type=email]').val()) {
                toastr.error('Please enter your email!');
                return;
            }

            $.ajax({
                type:'POST',
                url: "{{ route('subscription.store') }}",
                data: {
                    email: $(this).find('input[type=email]').val()
                },
                success: (data) => {
                    let { successMsg } = data;
                    toastr.success(successMsg);
                },
                error: function(error) {
                    if(error.responseJSON.errors) {
                        toastr.error(error.responseJSON.errors.email[0]);
                    }
                    if(error.errorMsg) {
                        toastr.error(error.errorMsg);
                    }
                }
            });
        });
    </script>
    @yield('js')

</body>
</html>
