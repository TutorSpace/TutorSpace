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
        @if (Auth::user()->is_tutor && Auth::user()->tutor_verification_status == "unsubmitted")
        <div class="container col-layout-2 home__panel home__header-container bg-color-purple-primary">
            <div class="home__panel__text heading-container">
                <p class="heading">Want to earn experience points more quickly? </p>
            </div>
            <div class="home__panel__button">
                <p class="home__panel__button__label">Become a Verified Tutor</p>
            </div>
        </div>
        @elseif (Auth::user()->is_tutor && Auth::user()->tutor_verification_status == "submitted")
        <div class="container col-layout-2 home__panel home__header-container bg-color-purple-primary">
            <div class="home__panel__text heading-container">
                <p class="heading">Tutor Verification Submitted</p>
            </div>
        </div>
        @endif

        <form class="container col-layout-2 profile" autocomplete="off"
            action="@if (isset($registerToBeTutor2) && $registerToBeTutor2) {{ route('switch-account.register-to-be-tutor-2') }} @else {{ route('home.profile.update') }} @endif"
            method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div
                    class="profile__text-container--white p-relative @if (isset($registerToBeTutor1) && $registerToBeTutor1) z-index-9999 @endif">
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
                                value="{{ Auth::user()->firstMajor->major ?? "" }}" name="first-major" id="first-major"
                                readonly>
                        </div>
                        <div class="autocomplete">
                            <label for="second-major" class="profile__label">Second Major (optional)</label>
                            <input type="text" class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->secondMajor->major ?? "" }}" name="second-major"
                                id="second-major" readonly>
                        </div>
                        <div class="autocomplete">
                            <label for="minor" class="profile__label">Minor (optional)</label>
                            <input type="text" class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->minor->minor ?? "" }}" name="minor" id="minor" readonly>
                        </div>
                    </div>

                    <div class="profile__form-row mt-3">
                        <div class="autocomplete">
                            <label for="school-year" class="profile__label">Class Standing</label>
                            <input type="text" class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->schoolYear->school_year ?? "" }}" name="school-year"
                                id="school-year" readonly>
                        </div>
                        <div class="gpa autocomplete mr-3">
                            <label for="gpa" class="profile__label">GPA</label>
                            <input type="text" class="profile__input form-control form-control-lg"
                                value="{{ Auth::user()->gpa ?? "" }}" name="gpa" id="gpa" readonly>
                        </div>
                        <div class="gpa-note">
                            <span class="font-italic">
                                Note: Your GPA would <span class="font-weight-bold">NOT</span> occur on your profile
                                page.
                            </span>
                        </div>
                    </div>

                    @if (Auth::user()->is_tutor)
                    <div class="profile__form-row mt-3">
                        <div class="input-introduction">
                            <label for="" class="profile__label">Introduction (optional)</label>
                            <textarea name="introduction" rows="5" class="profile__input form-control form-control-lg"
                                readonly>{{ Auth::user()->introduction }}</textarea>
                        </div>
                    </div>
                    @endif

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
                    class="profile__text-container--white p-relative @if (isset($registerToBeTutor2) && $registerToBeTutor2) z-index-9999 @endif">
                    @if (isset($registerToBeTutor2) && $registerToBeTutor2)
                    <h4 class="heading--register-to-be-tutor-2">Step 2: Complete your tutor information</h4>
                    @endif
                    @if (isset($hourlyRateError) && $hourlyRateError)
                    <p class="fs-1-4 fc-red">
                        Please Enter a Valid Hourly Rate.
                    </p>
                    @endif
                    <h5 class="w-100 font-weight-bold mb-4">Tutor Information</h5>
                    <div class="profile__form-row flex-wrap">
                        <div class="autocomplete mb-3">
                            <label for="course" class="profile__label">
                                @if (Auth::user()->is_tutor)
                                Courses you would like to tutor in
                                @else
                                Courses you would like to be tutored in
                                @endif
                            </label>
                            <input type="text"
                                class="profile__input profile__input__courses form-control form-control-lg" id="course">
                        </div>
                        @if (Auth::user()->is_tutor)
                        <div class="hourly-rate autocomplete">
                            <label for="hourly-rate" class="profile__label">Hourly Rate</label>
                            <div class="hourly-rate-input-container">
                                <span class="symbol">$</span>
                                <input type="text" class="profile__input form-control form-control-lg"
                                    value="{{ Auth::user()->hourly_rate ?? "" }}" name="hourly-rate" id="hourly-rate">
                            </div>
                        </div>
                        @endif

                        <div class="boxes boxes__course flex-100">
                            @foreach(Auth::user()->courses as $course)
                            <span class="box p-relative" type="button">
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
                    <h5 class="w-100 font-weight-bold mb-4">Forum Settings</h5>
                    <div class="profile__form-row flex-wrap">
                        <div class="autocomplete mb-3">
                            <label for="tag" class="profile__label">Tags you are interested in</label>
                            <input type="text" class="profile__input profile__input__forum form-control form-control-lg"
                                id="tag">
                        </div>

                        <div class="boxes boxes__forum flex-100">
                            @foreach((Auth::user())->tags as $tag)
                            <span class="box p-relative">
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

                <div class="profile__text-container--white">
                    <h5 class="w-100 font-weight-bold mb-4">Payment Methods</h5>
                    <div class="profile__form-row flex-wrap payment">
                        @if (Auth::user()->is_tutor)
                        <button id="btn-setup-payment" class="btn btn-primary btn-setup-payment" type="button">Set Up Payment
                            Methods</button>
                        @else
                        <div class="payment-cards">
                            <div class="card-wrapper">
                                <div class="card">
                                    <div class="brand">
                                        Brand: xxxx
                                    </div>
                                    <div class="exp">
                                        Expired At: MM/YY
                                    </div>
                                    <div class="last4">
                                        Card Number: xxxx-xxxx-xxxx-1234
                                    </div>
                                </div>
                                <button id = "btn-delete" class="btn btn-danger mr-2 btn-delete">Delete</button>
                                <button class="btn btn-primary">Set As Default</button>
                            </div>
                        </div>

                        <button id="btn-add-payment" class="btn btn-primary btn-add-payment" type="button">Add New
                            Payment Method</button>
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
        var stripe = Stripe("pk_test_51HvqSrGxwAT7uYY4xEdsjjJD8HcIC4en1jSFwH0Qrhe2TSSM1r1KqkbcweDkdsCwYkEpaPP63mmCgys4DGBfPz9200cmsSAtZn");
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
                event.preventDefault();
                // Complete payment when the submit button is clicked
                setUpCard(stripe, card, data.clientSecret);
            });
        });
        // Calls stripe.confirmCardPayment
        // If the card requires authentication Stripe shows a pop-up modal to
        // prompt the user to enter authentication details without leaving your page.
        var setUpCard = function(stripe, card, clientSecret) {
            loading(true);
            var email = document.getElementById("email").value;
            stripe
                .confirmCardSetup(clientSecret, {
                    payment_method: {
                        card: card,
                        billing_details: { email: email }
                    }
                })
                .then(function(result) {
                    if (result.error) {
                        // Show error to your customer
                        showError(result.error.message);
                        toastr.error("An error has occurred");
                    } else {
                        // save card as default
                        setCardAsDefault(result.setupIntent.payment_method, false).then((res)=>{
                            // The payment succeeded!
                            orderComplete(result.setupIntent.client_secret);
                        });

                    }
                });
        };




        /* ------- UI helpers ------- */
        // Shows a success message when the payment is complete
        var orderComplete = function(clientSecret) {
            stripe.retrieveSetupIntent(clientSecret).then(function(result) {
                toastr.success("Added card successfully");
                document.querySelector("#btn-add-payment-submit").disabled = true;
                loading(false);
                setTimeout(function () {
                    location.reload();
                }, 1000);
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
            if (isLoading) {
                // Disable the button and show a spinner
                document.querySelector("button").disabled = true;
                document.querySelector("#spinner").classList.remove("hidden");
                document.querySelector("#button-text").classList.add("hidden");
            } else {
                document.querySelector("button").disabled = false;
                document.querySelector("#spinner").classList.add("hidden");
                document.querySelector("#button-text").classList.remove("hidden");
            }
        };
    }
</script>

<script>
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

    displayCards();

    function handleDelete(){
        var btnDelete = $(".btn-delete");
        btnDelete.click(function(){
            event.preventDefault();
            const paymentMethodID = $(this).data("id");
            detachCard(paymentMethodID, true).then(result=>{
                return result.json();
            }).then((result)=>{
                if (result.errorMsg){
                    toastr.error(result.errorMsg)
                }else{
                    toastr.success(result.success)
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            })
            .catch(error=>{
                // TODO: error handling
                toastr.error(error);
            })

        });
    }

    function handleSetDefault(){
        var btnDefault = $(".btn-setDefault");
        btnDefault.click(function(){
            event.preventDefault();
            const paymentMethodID = $(this).data("id");
            console.log(paymentMethodID);
            setCardAsDefault(paymentMethodID, true).then((res)=>{
                // TODO: Success
                if (res.errorMsg){
                    toastr.error(res.errorMsg);
                }else{
                    toastr.success("succesfully set card as default payment method")
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            })
            .catch(error=>{
                // TODO: error handling
                toastr.error(error)
            })

        });
    }

    function detachCard(paymentMethodID, isFake){
        var fake = "false";
        if (isFake){
            var fake = "true";
        }

        var data = {
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



    function displayCards(){
        $.ajax({
            url: "{{ route('payment.stripe.list-cards') }}",
            method: 'GET',
            success: (data) => {
                let {
                    cards
                } = data;
                cards.forEach((card,idx) => {
                    $('.payment-cards').append(`
                        <div class="card-wrapper">
                            <div class="card">
                                <div class="brand">
                                    Brand: ${card.brand}
                                </div>
                                <div class="exp">
                                    Expired At: ${card.exp_month}/${card.exp_year}
                                </div>
                                <div class="last4">
                                    Card Number: xxxx-xxxx-xxxx-${card.last4}
                                </div>
                            </div>

                           `+

                           (card.is_default == 'false'?`
                                <button data-id=${idx} class="btn btn-danger mr-2 btn-delete">Delete</button>
                                <button data-id=${idx} class="btn btn-primary btn-setDefault">Set As Default</button>

                           `:'')
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
        // TODO: add loading
        postToConnectAccount().then((response) => {
            // TODO: hide loading


            // redirect to create stripe account
            if (response.stripe_url) {
                window.location = response.stripe_url;
                // TODO: error
            } else {

            }

        })
    });

    function postToConnectAccount() {
        return $.ajax({
            url: "{{ route('payment.stripe.onboarding') }}",
            method: 'POST',
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
    });

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
        if ($('.modal-verify-tutor')[0]) return;

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
            return $.ajax({
                type: 'POST',
                url: "{{ route('tutor-profile-verification') }}",
                data: formData,
                contentType: false,
                processData: false,

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
