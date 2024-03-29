<section class="view-profile__user-info">
    @if (Illuminate\Support\Str::of($user->profile_pic_url)->contains('placeholder'))
    <div class="user-img placeholder-img" id="profile-image">
        <span>{{ strtoupper($user->first_name[0]) . ' ' . strtoupper($user->last_name[0]) }}</span>
    </div>
    @else
    <img src="{{ Storage::url($user->profile_pic_url) }}" alt="profile-img" id="profile-image" class="user-img">
    @endif

    <h6 class="name">
        {{ $user->first_name }} {{ $user->last_name }}
    </h6>

    <div class="detail-info">
        {{ $user->firstMajor->major ?? "No info about his/her major" }}@if ($user->secondMajor)&nbsp;&nbsp;&#8226;&nbsp;&nbsp;{{ $user->secondMajor->major }}@endif&nbsp;&nbsp;&#8226;&nbsp;&nbsp;{{ $user->schoolYear->school_year ?? "No info about his/her school year" }}
    </div>

    <div class="intro-toggle fc-grey">
        <span>More about Him/Her</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up hover--primary-color" viewBox="0 0 16 16" id="intro-toggle--before">
            <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659l4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up hover--primary-color hidden-2" viewBox="0 0 16 16" id="intro-toggle--after">
            <path d="M3.204 11h9.592L8 5.519 3.204 11zm-.753-.659l4.796-5.48a1 1 0 0 1 1.506 0l4.796 5.48c.566.647.106 1.659-.753 1.659H3.204a1 1 0 0 1-.753-1.659z"/>
        </svg>
    </div>
    <div class="intro font-italic fs-1-4 fc-grey hidden-2" data-target="intro-toggle">
        “{{ $user->getIntroduction() }}”
    </div>
    <div class="button-container mt-3">
        @if (!Auth::check() || Auth::id() != $user->id)
        <a href="{{ $user->getChattingRoute() }}" class="btn fs-1-4 btn-primary btn-animation-y-sm" id="btn-chat">Chat</a>
        @endif
        <button id="btn-invite" class="btn fs-1-4 btn-outline-primary btn-animation-y-sm mt-3">Invite to be a Tutor</button>
    </div>

    <section class="section tutor-sessions pt-2">
        <div class="tutor-sesssions__content">
            <p class="heading">Courses He/She would like to Take</p>
            <div class="courses">
                @php
                    $courses = $user->courses;
                @endphp
                @foreach ($courses as $course)
                <span class="course" style="background-color: {{ $course->color }}; color: white;">
                    {{ $course->course }}
                </span>
                @endforeach
            </div>

            <div class="statistics-container">
                <div class="statistics color-primary">
                    <span class="number color-primary">{{ Carbon\Carbon::now()->diffInDays($user->created_at) }}</span>
                    <span class="classifier">Days</span>
                </div>
                <div class="statistics color-primary">
                    <span class="number color-primary">{{ $user->numSessions() }}</span>
                    <span class="classifier">Sessions</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section forum-activities pt-2">
        <a href="#" class="hover--pointer-none">Forum Activities</a>
        <div class="statistics-container mt-0">
            <div class="statistics color-primary">
                <span class="number color-primary">{{ $user->posts()->count() }}</span>
                <span class="classifier">Posts</span>
            </div>
            <div class="statistics color-primary">
                <span class="number color-primary">{{ $user->followedPosts()->count() }}</span>
                <span class="classifier">Followed</span>
            </div>
            <div class="statistics color-primary">
                <span class="number color-primary">{{ $user->participatedPosts()->count() }}</span>
                <span class="classifier">Participated</span>
            </div>
        </div>
    </section>

</section>
