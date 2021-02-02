<div class="container modal-verify-tutor">
    <svg class="d-block mx-auto my-3 svg"  viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M28.6788 14.6551C28.0288 14.0043 26.9721 14.0043 26.3221 14.6551L19.1671 21.8093L16.1788 18.8218C15.5288 18.171 14.4721 18.171 13.8221 18.8218C13.1713 19.4726 13.1713 20.5276 13.8221 21.1785L17.9888 25.3451C18.3138 25.671 18.7404 25.8335 19.1671 25.8335C19.5938 25.8335 20.0204 25.671 20.3454 25.3451L28.6788 17.0118C29.3296 16.361 29.3296 15.306 28.6788 14.6551Z" fill="#6749DF"/>
        <path d="M38.3333 18.3333C37.4133 18.3333 36.6667 19.08 36.6667 20C36.6667 29.19 29.19 36.6667 20 36.6667C10.81 36.6667 3.33333 29.19 3.33333 20C3.33333 10.81 10.81 3.33333 20 3.33333C24.4742 3.33333 28.6742 5.08167 31.8275 8.25667C32.475 8.91083 33.5308 8.91417 34.1842 8.265C34.8375 7.61667 34.8408 6.56167 34.1925 5.90833C30.4092 2.09833 25.3683 0 20 0C8.97167 0 0 8.97167 0 20C0 31.0283 8.97167 40 20 40C31.0283 40 40 31.0283 40 20C40 19.08 39.2533 18.3333 38.3333 18.3333Z" fill="#6749DF"/>
    </svg>
    <h4 class="w-100 text-center mb-4">Become a Verified Tutor</h4>
    <p class="text-dark">Please upload your USC STARS Report or transcript to complete tutor verification.</p>

    <h5 class="w-100 mt-4">Submit Your Verification Request</h5>

    <div class="my-4">
        <div class="d-flex flex-column justify-content-center align-items-center position-relative fc-grey fs-2-4 text-center" id="upload-file">
            <p id="upload-caption">Upload File</p>
            <div class="mt-3 btn btn-primary text-center" id="upload-file-button">
                <label class="pt-1 pb-0 px-5" for="tutor-verification-file">Click Here</label>
                <input type="file" id="tutor-verification-file" />
            </div>
        </div>
    </div>

    <p class="text-dark">
        Note: Verified tutors will receive extra cash bonuses from every completed tutoring session and also 50% more experience points by tutoring a verified course. <a href="{{route('tutor-verification-policy.show')}}" class="color-primary">[Tutor Verification Policy]</a>
    </p>

    <span class="text-dark">
        Questions? Email us at <a class="text-dark" href="mailto:tutorspacehelp@gmail.com">tutorspacehelp@gmail.com</a>
    </span>

</div>
