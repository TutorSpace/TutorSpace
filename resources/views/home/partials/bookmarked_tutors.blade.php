<div class="home__bookmarked-tutors d-flex flex-row my-4 align-items-center">
    <img src="{{ Storage::url(Auth::user()->profile_pic_url) }}" width="75rem" height="75rem" style="border-radius:50%" alt="profile-img" id="profile-image">
    <div class="d-flex flex-column">
        <span class="ml-5 fc-black-2 fs-1-8">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
        <span class="d-flex flex-row mt-3 ml-5">
            <btn class="bc-blue-primary px-5 py-2 mr-3 hover--pointer text-primary fs-1-4" style="border: 1px solid; border-radius:5px">Message</btn>
            <btn class="bg-color-blue-primary px-5 py-2 hover--pointer text-white fs-1-4" style="border-radius:5px">Request</btn>
        <span>
    </div>
</div>
