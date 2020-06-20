@extends('layouts.app')
@section('title', 'Sign Up - Student')

@section('body-class')
bg-grey-light body-signup
@endsection

@section('content')
<div class="container signup">

    {{-- left template --}}
    @include('admin.templates.register_left_student')

    <div class="signup--right signup--right-student">
        <h2 class="signup__heading">Create Account</h2>
        <form action="{{ route('register.store.student.1') }}" method="POST">
            <div class="form-group-2">
                @csrf
                <div class="p-relative">
                    <input type="text" class="form-control signup-form-input signup-form-input-normal" placeholder="First Name" required>
                    <svg class="input-icon">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-user')}}"></use>
                    </svg>
                </div>

                <div class="p-relative">
                    <input type="text" class="form-control signup-form-input signup-form-input-normal" placeholder="Last Name" required>
                    <svg class="input-icon">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-user')}}"></use>
                    </svg>
                </div>
            </div>

            <div class="p-relative">
                <input type="email" class="form-control signup-form-input signup-form-input-normal" placeholder="Email" required>
                <svg class="input-icon">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-mail')}}"></use>
                </svg>
            </div>

            <div class="p-relative">
                <input type="password" class="form-control signup-form-input signup-form-input-normal" placeholder="Password" required>
                <svg class="input-icon">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-lock')}}"></use>
                </svg>
            </div>

            <div class="d-flex justify-content-center mt-sm-5 mt-3">
                <hr>
            </div>

            <div class="d-flex justify-content-center mt-sm-5 mt-3">
                <div id="btn-google-signup"></div>
            </div>

            <div class="signup-container-bottom mt-sm-5 mt-3">

                {{-- btn-next --}}
                <button class="btn btn-next bg-grey">
                    <svg class="btn-next__arrow" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="37" height="37" fill="url(#pattern0)" />
                        <defs>
                            <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0" transform="scale(0.00195312)" />
                            </pattern>
                            <image id="image0" width="512" height="512"
                                xlink:href="data:image/png;base64,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" />
                        </defs>
                    </svg>
                </button>
            </div>

        </form>


    </div>
</div>

{{-- bg shapes for students --}}
@include('admin.templates.bg_shapes_student')

@endsection


@section('js')
<script>

let isStudent = true;
</script>

<script src="{{ asset('js/register.js') }}"></script>
@endsection
