<section class="home__header @if(session()->has('showWelcome')) home__header--animated @endif">
    <div class="">
        @if(session()->has('showWelcome'))
        <h3 class="welcome-msg ws-no-wrap">
            Welcome, {{ Auth::user()->first_name }}!
        </h3>
        @endif
        <div class="content d-flex p-relative">
            <figure class="content-img">
                <img src="{{ Storage::url(Auth::user()->profile_pic_url) }}" alt="profile-img" id="profile-image">
                <figcaption class="caption" id="upload-profile-pic">Upload Photo</figcaption>
                <form id="profile-pic-form" action="{{ route('upload-profile-pic') }}" enctype="multipart/form-data" class="hidden">
                    <input type="file" class="hidden" name="profile-pic" id="input-profile-pic" accept="image/*">
                </form>
            </figure>
            <div class="content-info">
                <div class="name-container">
                    <h4 class="name">
                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                    </h4>
                    @if (Auth::user()->is_tutor)
                    <div class="d-flex align-items-center">
                        @php
                            $starRating = Auth::user()->getAvgRating();
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i < $starRating)
                            <svg class="full" version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                <title>star-full</title>
                                <path d="M32 12.408l-11.056-1.607-4.944-10.018-4.944 10.018-11.056 1.607 8 7.798-1.889 11.011 9.889-5.199 9.889 5.199-1.889-11.011 8-7.798z"></path>
                            </svg>
                            @else
                            <svg class="empty" version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                <title>star-empty</title>
                                <path d="M32 12.408l-11.056-1.607-4.944-10.018-4.944 10.018-11.056 1.607 8 7.798-1.889 11.011 9.889-5.199 9.889 5.199-1.889-11.011 8-7.798zM16 23.547l-6.983 3.671 1.334-7.776-5.65-5.507 7.808-1.134 3.492-7.075 3.492 7.075 7.807 1.134-5.65 5.507 1.334 7.776-6.983-3.671z"></path>
                            </svg>
                            @endif
                        @endfor
                        <span class="rating">
                            {{ $starRating }}
                        </span>
                    </div>
                    @endif
                </div>

                @if (Auth::user()->is_tutor)
                <p class="sub">
                    <span class="sub--1">
                        @if (Auth::user()->is_tutor_verified)
                        <svg class="mr-1" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect width="12" height="12" fill="url(#pattern10)"/>
                            <defs>
                            <pattern id="pattern10" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image10" transform="scale(0.00195312)"/>
                            </pattern>
                            <image id="image10" width="512" height="512" xlink:href="data:image/png;base64,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"/>
                            </defs>
                        </svg>
                        @endif
                        {{ Auth::user()->tutorLevel->tutor_level }} Tutor
                    </span>
                    <span class="middot">
                        &middot;
                    </span>
                    <span class="sub--2">
                        ??? points
                    </span>
                </p>
                <div class="tutor-level-progress">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="tutor-level tutor-level--current">
                        ??????
                    </span>
                    <span class="tutor-level tutor-level--next">
                        ??????????
                    </span>
                </div>
                @else
                <p class="sub">
                    <span class="sub--1">
                        {{ Auth::user()->firstMajor->major ?? "No info about your major" }}
                    </span>
                    @if (Auth::user()->secondMajor)
                    <span class="middot">
                        &middot;
                    </span>
                    <span class="sub--1">
                        {{ Auth::user()->secondMajor->major }}
                    </span>
                    @endif
                    <span class="middot">
                        &middot;
                    </span>
                    <span class="sub--2">
                        {{ Auth::user()->schoolYear->school_year ?? "No info about your school year" }}
                    </span>
                    <span class="sub--3 ml-1">
                        <a href="{{ route('home.profile') }}">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil  fc-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                            </svg>
                        </a>
                    </span>
                </p>
                @endif
            </div>
            <div class="content-data">
                <div class="data">
                    <span class="number">{{ Carbon\Carbon::now()->diffInDays(Auth::user()->created_at) }}</span>
                    <span class="classifier">Days</span>
                </div>
                <div class="data">
                    <span class="number">{{ Auth::user()->numSessions() }}</span>
                    <span class="classifier">Sessions</span>
                </div>
                @if (Auth::user()->is_tutor)
                <div class="data">
                    <span class="number">?</span>
                    <span class="classifier">Students</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
