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
        <div class="container col-layout-2 home__header-container">
            <div class="heading-container">
                <p class="heading">Profile Settings</p>
                <span>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed enim blanditiis ipsam nesciunt quia culpa eaque eligendi
                </span>
            </div>
        </div>

        <form class="container col-layout-2 profile" autocomplete="off">
            <div class="row">
                <h5 class="w-100 profile__heading">Personal Information</h5>
                <div class="profile__form-row">
                    <div>
                        <label for="" class="profile__label">First Name</label>
                        <input type="text" class="profile__input form-control form-control-lg" placeholder="Shuaiqing" readonly>
                    </div>
                    <div>
                        <label for="" class="profile__label">Last Name</label>
                        <input type="text" class="profile__input form-control form-control-lg" placeholder="Luo" disabled readonly>
                    </div>
                </div>

                <div class="profile__form-row mt-3">
                    <div class="autocomplete">
                        <label for="first-major" class="profile__label">First Major</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="{{ Auth::user()->firstMajor->major ?? "" }}" name="first-major" id="first-major">
                    </div>
                    <div class="autocomplete">
                        <label for="second-major" class="profile__label">Second Major (optional)</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="{{ Auth::user()->secondMajor->major ?? "" }}" name="second-major" id="second-major">
                    </div>
                    <div class="autocomplete">
                        <label for="minor" class="profile__label">Minor (optional)</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="{{ Auth::user()->minor->minor ?? "" }}" name="minor" id="minor">
                    </div>
                </div>

                <div class="profile__form-row mt-3">
                    <div class="autocomplete">
                        <label for="school-year" class="profile__label">Class Standing</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="{{ Auth::user()->schoolYear->school_year ?? "" }}" name="school-year" id="school-year">
                    </div>
                    <div class="gpa autocomplete mr-3">
                        <label for="gpa" class="profile__label">GPA</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="{{ Auth::user()->gpa ?? "" }}" name="gpa" id="gpa">
                    </div>
                    <div class="gpa-note">
                        <span class="font-italic">
                            Note: Your GPA would <span class="font-weight-bold">NOT</span> occur on your profile page.
                        </span>
                    </div>
                </div>

                <h5 class="w-100 profile__heading">Tutor Information</h5>
                <div class="profile__form-row flex-wrap">
                    <div class="autocomplete mb-3">
                        <label for="course" class="profile__label">Courses You Would Like to Tutor in</label>
                        <input type="text" class="profile__input form-control form-control-lg" id="course">
                    </div>
                    <div class="hourly-rate autocomplete">
                        <label for="hourly-rate" class="profile__label">Hourly Rate</label>
                        <div class="hourly-rate-input-container">
                            <span class="symbol">$</span>
                            <input type="text" class="profile__input form-control form-control-lg" value="{{ Auth::user()->hourly_rate ?? "" }}" name="hourly-rate" id="hourly-rate">
                        </div>
                    </div>

                    <div class="boxes flex-100">
                        @foreach (App\Course::all()->take(7) as $course)
                        <span class="box p-relative" type="button">
                            {{ $course->course }}
                            <span class="p-absolute remove">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </span>
                        @endforeach
                    </div>
                </div>

                <h5 class="w-100 profile__heading">Forum Settings</h5>
                <div class="profile__form-row flex-wrap">
                    <div class="autocomplete mb-3">
                        <label for="tag" class="profile__label">Tags You are Interested in</label>
                        <input type="text" class="profile__input form-control form-control-lg" id="tag">
                    </div>

                    <div class="boxes flex-100">
                        @foreach (App\Tag::all()->take(10) as $tag)
                        <span class="box p-relative" type="button">
                            <span class="p-absolute verify">
                                <svg width="1em" height="1em" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M256 0C114.836 0 0 114.836 0 256C0 397.164 114.836 512 256 512C397.164 512 512 397.164 512 256C512 114.836 397.164 0 256 0Z" fill="#FFCE00"/>
                                    <path d="M385.75 201.75L247.082 340.414C242.922 344.574 237.461 346.668 232 346.668C226.539 346.668 221.078 344.574 216.918 340.414L147.586 271.082C139.242 262.742 139.242 249.258 147.586 240.918C155.926 232.574 169.406 232.574 177.75 240.918L232 295.168L355.586 171.586C363.926 163.242 377.406 163.242 385.75 171.586C394.09 179.926 394.09 193.406 385.75 201.75V201.75Z" fill="#FAFAFA"/>
                                </svg>
                            </span>
                            {{ $tag->tag }}
                            <span class="p-absolute remove">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </span>
                        @endforeach
                    </div>
                </div>

                {{-- buttons --}}
                <div class="w-100 profile__buttons">
                    <button class="btn btn-outline-primary mr-5" type="button">Discard Changes</button>
                    <button class="btn btn-primary" type="button">Save Changes</button>
                </div>
            </div>
        </form>


    </main>

</div>


@endsection

@section('js')

<script src="{{ asset('js/home/profile.js') }}"></script>

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


    function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    if($(inp).attr('id') == 'course') {
                        alert('here');
                    }
                    else if(x) {
                        /*and simulate a click on the "active" item:*/
                        x[currentFocus].click();
                    }
                }
            }
        });
        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
            x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

autocomplete(document.getElementById("first-major"), majors);
autocomplete(document.getElementById("second-major"), majors);
autocomplete(document.getElementById("minor"), minors);
autocomplete(document.getElementById("school-year"), schoolYears);
autocomplete(document.getElementById("gpa"), gpa);
autocomplete(document.getElementById("hourly-rate"), hourlyRate);
autocomplete(document.getElementById("course"), courses);
autocomplete(document.getElementById("tag"), tags);

</script>
@endsection
