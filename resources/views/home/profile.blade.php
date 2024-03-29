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
{{-- stripe --}}
<script src="https://js.stripe.com/v3/"></script>

@endsection

@section('content')

@include('partials.nav')

<div class="container-fluid home p-relative">
    @include('home.partials.menu_bar')
    <main class="home__content">
        @if(Auth::user()->is_tutor)
        <div class="container col-layout-2 home__panel home__header-container bg-color-purple-primary">
            <div class="home__panel__text heading-container">
                <p class="heading" id="help-tutor-verification-trigger">Want to earn experience points faster?
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle svg-help" viewBox="0 0 16 16" id="help-tutor-verification" style="margin-bottom: 2rem">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                </svg>
                </p>
            </div>
            @if (Auth::user()->is_tutor && Auth::user()->tutor_verification_status == "unsubmitted")
            <div class="home__panel__button">
                <p class="home__panel__button__label">Become a Verified Tutor</p>
            </div>
            @elseif (Auth::user()->is_tutor && Auth::user()->tutor_verification_status == "submitted")
            <div class="home__panel__button submitted">
                <p class="home__panel__button__label">Verification Request Submitted</p>
            </div>
            @endif
        </div>
        @endif


        <form class="container col-layout-2 profile" autocomplete="off"
            action="@if (isset($registerToBeTutor2) && $registerToBeTutor2) {{ route('switch-account.register-to-be-tutor-2') }} @else {{ route('home.profile.update') }} @endif"
            method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div
                    class="profile__text-container--white p-relative @if (isset($registerToBeTutor1) && $registerToBeTutor1) z-index-2000 @endif">
                    @if ($errors->any())
                    <p
                        class="fs-1-4 fc-red mb-2 @if (isset($registerToBeTutor1) && $registerToBeTutor1) p-absolute top-0-5 @endif">
                        {{ $errors->first() }}
                    </p>
                    @endif
                    <div class="d-flex justify-content-between align-items-center mb-4 p-relative">
                        @if (isset($registerToBeTutor1) && $registerToBeTutor1)
                        <h4 class="heading--register-to-be-tutor-1">Step 1: Complete your personal infomation</h4>
                        @endif
                        <h5 class="font-weight-bold">Personal Information</h5>
                        <div
                            class="profile__text__edit d-flex align-items-center mr-2 hover--pointer @if (isset($registerToBeTutor1) && $registerToBeTutor1) hidden @endif">
                            <svg class="mr-2" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-pencil"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" />
                                <path fill-rule="evenodd"
                                    d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z" />
                            </svg>
                            <span class="fs-1-4">Edit</span>
                        </div>
                    </div>
                    <div class="profile__form-row">
                        <div>
                            <label class="profile__label">First Name</label>
                            <input type="text" class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->first_name }}" disabled>
                        </div>
                        <div>
                            <label class="profile__label">Last Name</label>
                            <input type="text" class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->last_name }}" disabled>
                        </div>
                    </div>

                    <div class="profile__form-row mt-3">
                        <div class="autocomplete">
                            <label for="first-major" class="profile__label">First Major</label>
                            <input type="text" class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->firstMajor->major ??  old('first-major')  }}" name="first-major" id="first-major"
                                readonly>
                        </div>
                        <div class="autocomplete">
                            <label for="second-major" class="profile__label">Second Major (optional)</label>
                            <input type="text" class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->secondMajor->major ??  old('second-major')  }}" name="second-major"
                                id="second-major" readonly>
                        </div>
                        <div class="autocomplete">
                            <label for="minor" class="profile__label">Minor (optional)</label>
                            <input type="text" class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->minor->minor ?? old('minor') }}" name="minor" id="minor" readonly>
                        </div>
                    </div>

                    <div class="profile__form-row mt-3">
                        <div class="autocomplete">
                            <label for="school-year" class="profile__label">Class Standing</label>
                            <input type="text" class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->schoolYear->school_year ?? old('school-year') }}" name="school-year"
                                id="school-year" readonly>
                        </div>
                        <div class="gpa autocomplete mr-3">
                            <label for="gpa" class="profile__label">GPA</label>
                            <input type="text" class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->gpa ?? old('gpa') }}" name="gpa" id="gpa" readonly>
                        </div>
                        <div class="gpa-note">
                            <span class="font-italic">
                                Note: Your GPA would <span class="font-weight-bold">NOT</span> occur on your profile
                                page.
                            </span>
                        </div>
                    </div>

                    <div class="profile__form-row mt-3">
                        <div class="input-introduction">
                            <label for="" class="profile__label">Introduction (optional)</label>
                            <textarea name="introduction" rows="5" class="profile__input form-control form-control-lg"
                                readonly>{{ Auth::user()->introduction ?? old('introduction') }}</textarea>
                        </div>
                    </div>

                    {{-- buttons --}}
                    <div class="w-100 profile__buttons d-none">
                        @if (isset($registerToBeTutor1) && $registerToBeTutor1)
                        <button class="btn btn-primary" type="submit">Next</button>
                        @else
                        <button class="btn btn-outline-primary mr-5" id="btn-reset" type="button">Discard
                            Changes</button>
                        <button class="btn btn-primary" type="submit">Save Changes</button>
                        @endif
                    </div>
                </div>

                <div
                    class="profile__text-container--white p-relative @if (isset($registerToBeTutor2) && $registerToBeTutor2) z-index-2000 @endif">
                    @if (isset($registerToBeTutor2) && $registerToBeTutor2)
                    <h4 class="heading--register-to-be-tutor-2">Step 2: Complete your tutor information</h4>
                    @endif
                    @if (isset($hourlyRateError) && $hourlyRateError)
                    <p class="fs-1-4 fc-red">
                        Please Enter a Valid Hourly Rate.
                    </p>
                    @endif
                    <h5 class="w-100 font-weight-bold mb-4 has-notification-dot">
                        @if(Auth::user()->is_tutor) Tutor @else Student @endif Information
                        @if (Auth::user()->courses()->doesntExist())
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
                        </svg>
                        @endif
                    </h5>
                    <div class="profile__form-row flex-wrap">
                        <div class="autocomplete mb-3">
                            <label for="course" class="profile__label p-relative" id="help-user-info-trigger">
                                @if (Auth::user()->is_tutor)
                                Courses you would like to tutor
                                @else
                                Courses you are taking this semester
                                @endif
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle svg-help" viewBox="0 0 16 16" id="help-user-info">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                                  </svg>
                            </label>
                            <input type="text"
                                class="profile__input profile__input__courses form-control form-control-lg" id="course">
                        </div>
                        @if (Auth::user()->is_tutor)
                        <div class="hourly-rate autocomplete">
                            <label for="hourly-rate" class="profile__label" id="help-hourly-rate-trigger">
                                Hourly Rate (Upper Limit: ${{ Auth::user()->tutorLevel->hourly_rate_upper_bound }})
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle svg-help" viewBox="0 0 16 16" id="help-hourly-rate">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                                  </svg>
                            </label>
                            <div class="hourly-rate-input-container">
                                <span class="symbol">$</span>
                                <input type="number" class="profile__input form-control form-control-lg"
                                    value="{{ Auth::user()->hourly_rate }}" name="hourly-rate" id="hourly-rate"
                                    min="10" max="{{ Auth::user()->tutorLevel->hourly_rate_upper_bound }}">
                            </div>
                        </div>
                        @endif

                        <div class="boxes boxes__course flex-100">
                            @foreach(Auth::user()->courses as $course)
                            <span class="box p-relative" type="button" style="background-color: {{ $course->color }}; color: white;">
                                @if (App\VerifiedCourse::where('course_id', $course->id)->where('user_id',
                                Auth::id())->exists())
                                <svg class="p-absolute verify" width="1em" height="1em" viewBox="0 0 512 512"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M256 0C114.836 0 0 114.836 0 256C0 397.164 114.836 512 256 512C397.164 512 512 397.164 512 256C512 114.836 397.164 0 256 0Z"
                                        fill="#FFCE00" />
                                    <path
                                        d="M385.75 201.75L247.082 340.414C242.922 344.574 237.461 346.668 232 346.668C226.539 346.668 221.078 344.574 216.918 340.414L147.586 271.082C139.242 262.742 139.242 249.258 147.586 240.918C155.926 232.574 169.406 232.574 177.75 240.918L232 295.168L355.586 171.586C363.926 163.242 377.406 163.242 385.75 171.586C394.09 179.926 394.09 193.406 385.75 201.75V201.75Z"
                                        fill="#FAFAFA" />
                                </svg>
                                @endif
                                <span class="label" data-course-id={{$course->id}}>{{ $course->course }}</span>
                                <svg class="p-absolute remove" width="1em" height="1em" viewBox="0 0 16 16"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                            @endforeach
                        </div>
                        <p class="profile__label font-italic">Note: You can add at most 7 courses.</p>
                    </div>
                    {{-- buttons --}}
                    <div class="w-100 profile__buttons mt-0">
                        @if (isset($registerToBeTutor2) && $registerToBeTutor2)
                        <button class="btn btn-primary" type="submit">Create Account</button>
                        @endif
                    </div>
                </div>

                <div class="profile__text-container--white">
                    <h5 class="w-100 font-weight-bold mb-4 has-notification-dot">
                        <span id="help-forum-trigger">Forum Settings</span>
                        @if (Auth::user()->tags()->doesntExist())
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle svg-help ml-4" viewBox="0 0 16 16" id="help-forum">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                          </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle svg-help ml-2" viewBox="0 0 16 16" id="help-forum">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                          </svg>
                        @endif

                    </h5>
                    <div class="profile__form-row flex-wrap">
                        <div class="autocomplete mb-3">
                            <label for="tag" class="profile__label">Tags you are interested in</label>
                            <input type="text" class="profile__input profile__input__forum form-control form-control-lg"
                                id="tag">
                        </div>

                        <div class="boxes boxes__forum flex-100">
                            @foreach((Auth::user())->tags as $tag)
                            <span class="box p-relative" style="background-color: {{ $tag->color }}; color: white;">
                                <span class="label" data-tag-id={{$tag->id}}>{{ $tag->tag }}</span>
                                <svg class="p-absolute remove" width="1em" height="1em" viewBox="0 0 16 16"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                            @endforeach
                        </div>
                        <p class="profile__label font-italic">Note: You can add at most 10 tags.</p>
                    </div>
                </div>

                <div class="profile__text-container--white p-relative">
                    <div class="stripe-svg-container">
                    </div>
                    <h5 class="w-100 font-weight-bold mb-4 has-notification-dot" id="payment-method-section">
                        Payment Methods
                        @if (
                        (Auth::user()->is_tutor && !Auth::user()->tutorHasStripeAccount())
                        || (!Auth::user()->is_tutor && !app(App\Http\Controllers\Payment\StripeApiController::class)->customerHasCards()))
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
                        </svg>
                        @endif
                    </h5>
                    <div class="profile__form-row flex-wrap payment">
                        @if (Auth::user()->is_tutor)
                        <button id="btn-setup-payment" class="btn btn-primary btn-setup-payment px-5 py-3 ws-no-wrap" type="button">
                            {{ Auth::user()->tutorHasStripeAccount()? "View Your Stripe Payment Account":"Set Up Payment
                            Methods" }}
                        </button>
                        <div class="flex-100"></div>
                        <p class="fs-1-4 font-italic fw-500 mt-4 flex-100">
                            Note: By registering your account, you agree to <a href="{{route("service-agreement.show")}}" class="color-primary" target="_blank">TutorSpace Services Agreement</a> and the <a href="https://stripe.com/connect-account/legal" class="color-primary" target="_blank">Stripe Connected Account Agreement</a>.
                        </p>
                        @if (Auth::user()->is_tutor && !Auth::user()->tutorHasStripeAccount())
                        <p class="fs-1-4 font-italic fw-500 mt-1 flex-100">
                            <span class="text-danger">IMPORTANT:</span> Please note that you will be asked to provide your business name and your website address, but feel free to enter a random one if you don't have one.
                        </p>
                        @endif
                        @else
                        <div class="payment-cards">
                            <div id="btn-add-payment" class="btn-add-payment bg-add-card m-3">
                                <div>+</div>
                                <div>Add New Payment</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>


    </main>

</div>


@endsection

@section('js')



<script defer>

    function stripeInit() {

        // A reference to Stripe.js initialized with your real test publishable API key.
        var stripe = Stripe(stripeApiKey);
        // The items the customer wants to buy
        // Disable the button until we have Stripe set up on the page
        document.querySelector("button").disabled = true;
        fetch("{{ route('payment.stripe.create_setup_intent') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": '{{csrf_token()}}'
            },
        })
        .then(function(result) {
            return result.json();
        })
        .then(function(data) {
            // console.log(data);
            var elements = stripe.elements();
            var style = {
                base: {
                fontSize: "16px",
                color: "#32325d",
                fontFamily:
                    "-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif",
                fontSmoothing: "antialiased",
                "::placeholder": {
                    color: "rgba(0,0,0,0.4)"
                }
                }
            };

            var card = elements.create("card", { style: style });
            // Stripe injects an iframe into the DOM
            card.mount("#card-element");
            card.on("change", function (event) {
                // Disable the Pay button if there are no card details in the Element
                document.querySelector("button").disabled = event.empty;
                document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
            });
            var form = document.getElementById("payment-form");
            form.addEventListener("submit", function(event) {
                processing(true);
                event.preventDefault();
                var checkeAgreement = document.getElementById("add-card-agreement");
                var email = document.getElementById("email").value.trim();
                var name = document.getElementById("card-holder").value.trim();
                if (!checkeAgreement.checked){
                    showError("Please read our terms of agreement");
                }else if (!email || !name){
                    showError("Please enter billing account details");
                }else{

                    paymentActionProcessing = true;
                    setUpCard(stripe, card, data.clientSecret, email, name);

                }
                // Complete payment when the submit button is clicked

            });
        });


        // Calls stripe.confirmCardPayment
        // If the card requires authentication Stripe shows a pop-up modal to
        // prompt the user to enter authentication details without leaving your page.
        var setUpCard = function(stripe, card, clientSecret, email, name) {
            // TODO: nate check if card already exists
            // # Retrieve the customer we're adding this token to
            loading(true);

            stripe.createToken(card).then((token)=>{
                return $.ajax({
                    type: 'POST',
                    url: '{{ route('payment.stripe.verify_card_exists') }}',
                    data: {
                        "token": token
                    },
                    success: (msg) =>{
                        confirmCard(stripe, card, clientSecret, email, name)
                    },
                    error: (err) => {
                        loading(false);
                        processing(false);
                        if (err.responseJSON.error){
                            showError(err.responseJSON.error);
                        }
                    }
                 });
            })
        };

        function confirmCard(stripe, card, clientSecret, email, name){
                stripe
                    .confirmCardSetup(clientSecret, {
                        payment_method: {
                            card: card,
                            billing_details: { email: email, name: name }
                        }
                    })
                    .then(function(result) {
                        if (result.error) {
                            // Show error to your customer
                            showError(result.error.message);
                            loading(false);
                            processing(false);
                            toastr.error("An error has occurred");
                        } else {
                            // save card as default
                            setCardAsDefault(result.setupIntent.payment_method, false).then((res)=>{
                                // The payment succeeded!
                                orderComplete(result.setupIntent.client_secret);
                            });

                        }
                });
        }


        /* ------- UI helpers ------- */
        // Shows a success message when the payment is complete
        var orderComplete = function(clientSecret) {
            stripe.retrieveSetupIntent(clientSecret).then(function(result) {
                // TODO: nate uncomment
                // store last bank card action in session
                sendLastBankCardAction("addNew").then(()=>{
                        toastr.success("Added card successfully");
                        var submitBtn = document.querySelector("#btn-add-payment-submit");
                        if (submitBtn) submitBtn.disabled = true;
                        loading(false);
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                });
            });
        };
        // Show the customer the error from Stripe if their card fails to charge
        var showError = function(errorMsgText) {
            loading(false);
            var errorMsg = document.querySelector("#card-error");
            errorMsg.textContent = errorMsgText;
            setTimeout(function() {
                errorMsg.textContent = "";
            }, 4000);
        };
        // Show a spinner on payment submission
        var loading = function(isLoading) {
            const button = document.querySelector("button");
            const spinner = document.querySelector("#spinner");
            const buttonText = document.querySelector("#button-text");
            if (isLoading) {
                // Disable the button and show a spinner
                if (button) button.disabled = true;
                if (spinner) spinner.classList.remove("hidden");
                if (buttonText) buttonText.classList.add("hidden");
            } else {
                if (button) button.disabled = false;
                if (spinner) spinner.classList.add("hidden");
                if (buttonText) buttonText.classList.remove("hidden");
            }
        };

    }
</script>

<script>

        var processing = function(isProcessing){
            if (isProcessing){
                $(".btn-delete").attr("disabled",true);
                $(".btn-set-default").attr("disabled",true);
            }else{
                $(".btn-delete").attr("disabled",false);
                $(".btn-set-default").attr("disabled",false);
            }
        }

    const setCardAsDefault = function (paymentMethodID, isFake) {
        var fake = "false";
        if (isFake){
            var fake = "true";
        }

        var data = {
            'paymentMethodID':paymentMethodID,
            'isFake':fake
        };

        return fetch("{{route('payment.stripe.set_invoice_payment_default') }}", {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json',
            "X-CSRF-Token": '{{csrf_token()}}'
            },
        })
    }

@if (!Auth::user()->is_invalid)
    displayCards();
@endif

    function handleDelete(){

        var btnDelete = $(".btn-delete");
        btnDelete.click(function(){
            processing(true);
            event.preventDefault();
            const paymentMethodID = $(this).data("id");
            detachCard(paymentMethodID, true).then(result=>{
                return result.json();
            }).then((result)=>{
                if (result.errorMsg){
                    toastr.error(result.errorMsg);
                }else{
                    sendLastBankCardAction("deleteCard").then(()=>{
                        toastr.success(result.success);
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                    });
                }
            })
            .catch(error=>{
                toastr.error(error);
                processing(false);
            })
        });
    }

    function handleSetDefault(){
        var btnDefault = $(".btn-set-default");
        btnDefault.click(function(){
            processing(true);
            event.preventDefault();
            const paymentMethodID = $(this).data("id");
            setCardAsDefault(paymentMethodID, true).then((res)=>{
                if (res.errorMsg){
                    toastr.error(res.errorMsg);
                }else{
                    sendLastBankCardAction("setDefault").then(()=>{
                        toastr.success("Succesfully set card as default payment method");
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                    });
                }
            })
            .catch(error=>{
                processing(false);
                toastr.error(error)
            })

        });
    }

    function detachCard(paymentMethodID, isFake){
        var fake = "false";
        if (isFake){
            var fake = "true";
        }

        const data = {
            'paymentMethodID':paymentMethodID,
            'isFake':fake
        };

        return fetch("{{route('payment.stripe.detach_payment') }}", {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": '{{csrf_token()}}'
                },
            })
    }

    // save bank card action in session
    function sendLastBankCardAction(action){
        const data = {
            "bankCardActionToStore": action
        }
        return fetch("{{route('payment.stripe.store_bank_card_action_in_session') }}", {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": '{{csrf_token()}}'
                },
            })
    }

    function displayCards(){
        JsLoadingOverlay.show(jsLoadingOverlayOptions);
        $.ajax({
            url: "{{ route('payment.stripe.list-cards') }}",
            method: 'GET',
            complete: () => {
                JsLoadingOverlay.hide();
            },
            success: (data) => {
                let {
                    cards
                } = data;
                cards.forEach((card,idx) => {
                    // get card brand and include svg
                    var cardBrand;
                    if (card.brand == "amex"){
                        cardBrand = `@include('payment.partials.card-svg.american-express-svg')`;
                    }else if (card.brand == "discover"){
                        cardBrand = `@include('payment.partials.card-svg.discover-svg')`;
                    }else if (card.brand == "jcb"){
                        cardBrand = `@include('payment.partials.card-svg.jcb-svg')`;
                    }else if (card.brand == "mastercard"){
                        cardBrand = `@include('payment.partials.card-svg.master-svg')`;
                    }else if (card.brand == "visa"){
                        cardBrand = `@include('payment.partials.card-svg.visa-svg')`;
                    }else if (card.brand == "diners"){
                        cardBrand = `@include('payment.partials.card-svg.diners-club-svg')`;
                    }else if (card.brand == "unionpay"){
                        cardBrand = `@include('payment.partials.card-svg.union-pay-svg')`;
                    }
                    else{
                        cardBrand = `Brand: ${card.brand}`;
                    }

                    // prepend cards
                    $('.payment-cards').prepend(`
                            <div class="bank-card `+
                            (card.is_default == 'false'? `bg-non-default`:`bg-default`)
                            +`
                             m-3">
                                <div class="overlay"></div>
                                <div class="bank-card-row-one">  <div class="brand">
                                    `+ cardBrand +` </div>
                                </div>

                                <div class="bank-card-row-two">
                                    <div class="number">
                                        <span>****</span>
                                        <span>****</span>
                                        <span>****</span>
                                        <span>${card.last4}</span>
                                    </div>
                                </div>
                                <div class="bank-card-row-three">
                                    <div class="card-holder">
                                        <div>Card Holder</div>
                                        <div class="user-info">${card.card_holder}</div>
                                    </div>
                                    <div class="expiration">
                                        <div>Exp Date</div>
                                        <div class="user-info">${card.exp_month}/${card.exp_year}</div>
                                    </div>
                                </div>
                                `+
                                (card.is_default == 'false'?`
                                    <div class="bank-card-btns">
                                        <button data-id=${idx} class="btn btn-delete">Delete</button>
                                        <button data-id=${idx} class="btn btn-set-default">Set As Default</button>
                                    </div>
                                `:`
                                    <div class="bank-card-btns default-payment-font">Default Payment</div>
                                `)
                                +`
                            </div>
                    `);
                });

                handleDelete();
                handleSetDefault();

            },
            error: (err) => {
                console.log(err);
            }
        })
    }



    $("#btn-setup-payment").click(function () {
        JsLoadingOverlay.show(jsLoadingOverlayOptions);
        postToConnectAccount().then((response) => {
            JsLoadingOverlay.hide();

            // redirect to create stripe account
            if (response.stripe_url) {
                window.location = response.stripe_url;
            } else {
                toastr.error('Something went wrong. Please contact tutorspacehelp@gmail.com for more details.')
            }

        })
    });

    function postToConnectAccount() {
        JsLoadingOverlay.show(jsLoadingOverlayOptions);
        return $.ajax({
            url: "{{ route('payment.stripe.onboarding') }}",
            method: 'POST',
            complete: () => {
                JsLoadingOverlay.hide();
            }
        })
    }

    $('#btn-add-payment').click(function () {
        bootbox.dialog({
            message: `@include('payment.partials.save-card')`,
            size: 'medium',
            centerVertical: true,
        });
        stripeInit();
    });

</script>

{{-- autocomplete --}}
<script>
    $('#hourly-rate').on("change paste keyup", function () {
        if(Number($(this).val()) < 10 || Number($(this).val()) > {{ Auth::user()->tutorLevel->hourly_rate_upper_bound }} ) {
            return
        }

        updateHourlyRate();
    });

    function updateHourlyRate() {
        $.ajax({
            type: 'POST',
            url: '{{ route('home.profile.hourly-rate.update') }}',
            data: {
                "hourly-rate": $('#hourly-rate').val()
            },
            error: (err) => {
                console.log(err);
            }
        });
    }

    let gpa = [
        @for($i = 4.00; $i >= 1.00; $i -= 0.01)
        "{{ number_format($i, 2) }}",
        @endfor
    ];
    let hourlyRate = [
        @for($i = 10; $i <= 50; $i += 1)
        "{{ number_format($i, 1) }}",
        @endfor
    ];

</script>

<script>
    $('.home__panel__button').on('click', function () {
        if ($('.modal-verify-tutor')[0] || $(this).hasClass('submitted')) return;

        bootbox.dialog({
            message: `@include('home.partials.tutorVerification')`,
            size: 'medium',
            onEscape: true,
            centerVertical: true,
            buttons: {
                Decline: {
                    label: 'Cancel',
                    className: 'btn btn-outline-primary mr-2 p-3 px-5',
                    callback: function () {}
                },
                Submit: {
                    label: 'Submit',
                    className: 'btn btn-primary p-3 px-5',
                    callback: function () {
                        tutorVerificationUpload();
                    }
                },
            }
        });

        function tutorVerificationUpload() {
            var file = $("#tutor-verification-file")[0].files[0];
            if (file && !fileTypeError) {
                uploadFile(file);
            } else if (fileTypeError) {
                toastr.error("unsupported file type");
            } else {
                toastr.error("File cannot be empty");
            }
        }

        // check mime type promise: return true if it's accepted file type, else false
        function checkMimeType(file) {
            return new Promise(function (resolve, reject) {
                try {
                    const filereader = new FileReader();
                    filereader.onloadend = function (evt) {
                        console.log(filereader);
                        if (evt.target.readyState === FileReader.DONE) {
                            const uint = new Uint8Array(evt.target.result)
                            let bytes = []
                            uint.forEach((byte) => {
                                bytes.push(byte.toString(16))
                            })
                            const hex = bytes.join('').toUpperCase()
                            console.log(hex);
                            resolve(correctMimetype(hex));
                            return;
                        }
                    }
                    const blob = file.slice(0, 4);
                    filereader.readAsArrayBuffer(blob);
                } catch (err) {
                    reject("error");
                }
            })
        }

        const correctMimetype = (signature) => {
            switch (signature) {
                // pdf
                case '25504446':
                    // jpg
                case 'FFD8FFDB':
                case 'FFD8FFE0':
                    // jpeg
                case 'FFD8FFEE':
                case 'FFD8FFE1':
                    // png
                case '89504E47':
                case '504B0304':
                    // doc, xls, ppt, msg
                case 'D0CF11E0':
                    // rtf
                case '7B5C7274':
                    // docx
                case '504B0304':
                    // xlsx
                case '504B0708':
                    return true;
                default:
                    return false;
            }
        }

        var fileTypeError = false;
        $("#tutor-verification-file").change(function () {
            const fileInput = $(this)[0];
            const file = fileInput.files[0];

            if (file) { // file exists
                checkMimeType(file).then(acceptedMime => {
                    if (acceptedMime) { // accepted mime type
                        var fileName = fileInput.value.split("\\").pop();
                        if (fileName.length > 20) {
                            fileName = fileName.substring(0, 20) + "...";
                        }
                        $("#upload-caption").html(fileName);
                        fileTypeError = false;
                    } else { // unaccepted mime type
                        $("#upload-caption").html("unsupported file type");
                        fileTypeError = true;
                    }
                });
            } else { // file doesn't exist
                $("#upload-caption").html("Upload File");
            }
        })

        function uploadFile(file) {
            var formData = new FormData();
            formData.append('tutor-verification-file', file);
            JsLoadingOverlay.show(jsLoadingOverlayOptions);
            return $.ajax({
                type: 'POST',
                url: "{{ route('tutor-profile-verification') }}",
                data: formData,
                contentType: false,
                processData: false,
                complete: () => {
                    JsLoadingOverlay.hide();
                },
                success: (data) => {
                    bootbox.dialog({
                        message: `@include('home.partials.tutorVerification--upload_success')`,
                        size: 'medium',
                        centerVertical: true,
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                },
                error: () => {
                    toastr.error('Something went wrong. Please try again.');
                    return false;
                }
            });
        }

    });

</script>

<script>
    let isTutor = {{ Auth::user()->is_tutor }};

    const isPaymentRedirect = getUrlParameter('payment-section-redirect');
    if (isPaymentRedirect){
        $('html, body').animate({
            scrollTop: $('#payment-method-section').offset().top - 100
        }   , 700);
    }
</script>
<script src="{{ asset('js/home/profile.js') }}"></script>

@if ((isset($registerToBeTutor1) && $registerToBeTutor1))
<script>
    $('.profile__text__edit').click();
</script>
@endif

@if ((isset($registerToBeTutor1) && $registerToBeTutor1) || (isset($registerToBeTutor2) && $registerToBeTutor2))
{{-- the following classes are from the bootbox --}}
<div class="modal-backdrop fade show"></div>
@endif

@endsection
