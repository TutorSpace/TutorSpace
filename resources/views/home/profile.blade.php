@extends('layouts.app')

@section('title', 'Dashboard - Profile Settings')

@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection

@section('links-in-head')
{{-- fullcalendar --}}
<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
<script src='{{asset('fullcalendar/main.min.js')}}'></script>
@endsection

@section('content')

@include('partials.nav')

<div class="container-fluid home p-relative">
    @include('home.partials.menu_bar')
    <main class="home__content">
        @if (Auth::user()->is_tutor)
        <div class="container col-layout-2 home__panel home__header-container bg-color-purple-primary">
            <div class="home__panel__text heading-container">
                <p class="heading">Want to earn experience points more quickly? </p>
            </div>
            <div class="home__panel__button">
                <p class="home__panel__button__label">Become a Verified Tutor</p>
            </div>
        </div>
        @endif

        <form class="container col-layout-2 profile" autocomplete="off" action="{{ route('home.profile.update') }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="profile__text-container--white profile__info @if (isset($registerToBeTutor) && $registerToBeTutor) z-index-9999 @endif">
                    @if ($errors->any())
                    <p class="fs-1-4 fc-red mb-2">
                        {{ $errors->first() }}
                    </p>
                    @endif
                    <div class="d-flex justify-content-between align-items-center mb-4 p-relative">
                        @if (isset($registerToBeTutor) && $registerToBeTutor)
                        <h4 class="heading--register-to-be-tutor">Step 1: Complete your personal infomation</h4>
                        @endif
                        <h5 class="font-weight-bold">Personal Information</h5>
                        <div class="profile__text__edit d-flex align-items-center mr-2 hover--pointer @if (isset($registerToBeTutor) && $registerToBeTutor) hidden @endif">
                            <svg class="mr-2" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                            </svg>
                            <span class="fs-1-4">Edit</span>
                        </div>
                    </div>
                    <div class="profile__form-row">
                        <div>
                            <label for="" class="profile__label">First Name</label>
                            <input type="text" class="profile__input form-control form-control-lg" value="Shuaiqing" disabled>
                        </div>
                        <div>
                            <label for="" class="profile__label">Last Name</label>
                            <input type="text" class="profile__input form-control form-control-lg" value="Luo" disabled>
                        </div>
                    </div>

                    <div class="profile__form-row mt-3">
                        <div class="autocomplete">
                            <label for="first-major" class="profile__label">First Major</label>
                            <input
                                type="text"
                                class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->firstMajor->major ?? "" }}"
                                name="first-major"
                                id="first-major"
                                readonly
                            >
                        </div>
                        <div class="autocomplete">
                            <label for="second-major" class="profile__label">Second Major (optional)</label>
                            <input type="text" class="profile__input form-control form-control-lg" value="{{ Auth::user()->secondMajor->major ?? "" }}" name="second-major" id="second-major" readonly>
                        </div>
                        <div class="autocomplete">
                            <label for="minor" class="profile__label">Minor (optional)</label>
                            <input type="text" class="profile__input form-control form-control-lg" value="{{ Auth::user()->minor->minor ?? "" }}" name="minor" id="minor" readonly>
                        </div>
                    </div>

                    <div class="profile__form-row mt-3">
                        <div class="autocomplete">
                            <label for="school-year" class="profile__label">Class Standing</label>
                            <input type="text" class="profile__input form-control form-control-lg" value="{{ Auth::user()->schoolYear->school_year ?? "" }}" name="school-year" id="school-year" readonly>
                        </div>
                        <div class="gpa autocomplete mr-3">
                            <label for="gpa" class="profile__label">GPA</label>
                            <input type="text" class="profile__input form-control form-control-lg" value="{{ Auth::user()->gpa ?? "" }}" name="gpa" id="gpa" readonly>
                        </div>
                        <div class="gpa-note">
                            <span class="font-italic">
                                Note: Your GPA would <span class="font-weight-bold">NOT</span> occur on your profile page.
                            </span>
                        </div>
                    </div>

                    @if (Auth::user()->is_tutor)
                    <div class="profile__form-row mt-3">
                        <div class="input-introduction">
                            <label for="" class="profile__label">Introduction</label>
                            <textarea name="introduction" rows="5" class="profile__input form-control form-control-lg" readonly>{{ Auth::user()->introduction }}</textarea>
                        </div>
                    </div>
                    @endif

                    {{-- buttons --}}
                    <div class="w-100 profile__buttons d-none">
                        @if (isset($registerToBeTutor) && $registerToBeTutor)
                        <button class="btn btn-primary" type="submit">Next</button>
                        @else
                        <button class="btn btn-outline-primary mr-5" id="btn-reset" type="button">Discard Changes</button>
                        <button class="btn btn-primary" type="submit">Save Changes</button>
                        @endif
                    </div>
                </div>

                <div class="profile__text-container--white">
                    <h5 class="w-100 font-weight-bold mb-4">Tutor Information</h5>
                    <div class="profile__form-row flex-wrap">
                        <div class="autocomplete mb-3">
                            <label for="course" class="profile__label">Courses you would like to tutor in</label>
                            <input type="text" class="profile__input profile__input__courses form-control form-control-lg" id="course">
                        </div>
                        <div class="hourly-rate autocomplete">
                            <label for="hourly-rate" class="profile__label">Hourly Rate</label>
                            <div class="hourly-rate-input-container">
                                <span class="symbol">$</span>
                                <input type="text" class="profile__input form-control form-control-lg" value="{{ Auth::user()->hourly_rate ?? "" }}" name="hourly-rate" id="hourly-rate">
                            </div>
                        </div>


                        <div class="boxes boxes__course flex-100">
                            @foreach((Auth::user())->courses as $course)
                            <span class="box p-relative" type="button">
                                <svg class="p-absolute verify" width="1em" height="1em" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M256 0C114.836 0 0 114.836 0 256C0 397.164 114.836 512 256 512C397.164 512 512 397.164 512 256C512 114.836 397.164 0 256 0Z" fill="#FFCE00"/>
                                    <path d="M385.75 201.75L247.082 340.414C242.922 344.574 237.461 346.668 232 346.668C226.539 346.668 221.078 344.574 216.918 340.414L147.586 271.082C139.242 262.742 139.242 249.258 147.586 240.918C155.926 232.574 169.406 232.574 177.75 240.918L232 295.168L355.586 171.586C363.926 163.242 377.406 163.242 385.75 171.586C394.09 179.926 394.09 193.406 385.75 201.75V201.75Z" fill="#FAFAFA"/>
                                </svg>
                                <span class="label" data-course-id={{$course->id}}>{{ $course->course }}</span>
                                <svg class="p-absolute remove" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                            @endforeach
                        </div>
                        <p class="profile__label font-italic">Note: You can add at most 7 courses.</p>
                    </div>
                </div>

                <div class="profile__text-container--white">
                    <h5 class="w-100 font-weight-bold mb-4">Forum Settings</h5>
                    <div class="profile__form-row flex-wrap">
                        <div class="autocomplete mb-3">
                            <label for="tag" class="profile__label">Tags you are interested in</label>
                            <input type="text" class="profile__input profile__input__forum form-control form-control-lg" id="tag">
                        </div>

                        <div class="boxes boxes__forum flex-100">
                        @foreach((Auth::user())->tags as $tag)
                            <span class="box p-relative">
                                <span class="label" data-tag-id={{$tag->id}}>{{ $tag->tag }}</span>
                                <svg class="p-absolute remove" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                            @endforeach
                        </div>
                        <p class="profile__label font-italic">Note: You can add at most 10 tags.</p>
                    </div>
                </div>
            </div>
        </form>


    </main>

</div>


@endsection

@section('js')

{{-- autocomplete --}}
<script>
    let majors = [
        @foreach(App\Major::all() as $major)
        "{{ $major->major }}",
        @endforeach
    ];
    let minors = [
        @foreach(App\Minor::all() as $minor)
        "{{ $minor->minor }}",
        @endforeach
    ];
    let schoolYears = [
        @foreach(App\SchoolYear::all() as $schoolYear)
        "{{ $schoolYear->school_year }}",
        @endforeach
    ];
    let gpa = [
        @for ($i = 4.00; $i >= 1.00; $i -= 0.01)
        "{{ number_format($i, 2) }}",
        @endfor
    ];
    let hourlyRate = [
        @for ($i = 10; $i <= 50; $i += 0.5)
            "{{ number_format($i, 1) }}",
        @endfor
    ];
    let courses = [
        @foreach(App\Course::all() as $course)
        "{{ $course->course }}",
        @endforeach
    ];
    let tags = [
        @foreach(App\Tag::all() as $tag)
        "{{ $tag->tag }}",
        @endforeach
    ];
</script>

<script>
    $('.home__panel__button').on('click',function() {
        if($('.modal-verify-tutor')[0]) return;
        @php
            $callbackFuncName = "tutorVerification_upload";
        @endphp

        bootbox.dialog({
            message: `@include('home.partials.tutorVerification')`,
            size: 'medium',
            onEscape: true,
            backdrop: true,
            centerVertical: true,
            buttons: {
                Decline: {
                    label: 'Decline',
                    className: 'btn btn-outline-primary mr-2 p-3 px-5',
                    callback: function(){}
                },
                Submit: {
                    label: 'Submit',
                    className: 'btn btn-primary p-3 px-5',
                    callback: {{ $callbackFuncName }}
                },
            }
        });
        function tutorVerification_upload() {
            bootbox.dialog({
                message: `@include('home.partials.tutorVerification--upload_success')`,
                size: 'medium',
                onEscape: true,
                backdrop: true,
                centerVertical: true,
                buttons: {
                    Close: {
                    label: 'Close',
                    className: 'btn btn-primary p-3 px-5',
                    callback: function(){}
                },
                }
            });
        }
    });
</script>

<script src="{{ asset('js/home/profile.js') }}"></script>

@if (isset($registerToBeTutor) && $registerToBeTutor)
<script>
    $('.profile__text__edit').click();
</script>

{{-- the following classes are from the bootbox --}}
<div class="modal-backdrop fade show"></div>
@endif
@endsection
