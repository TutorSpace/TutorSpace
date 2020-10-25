<div class="notification__content__header font-weight-bold">
    You received a new tutor request from Nemo Enim!
</div>
<div class="notification__content__info">

        <div class="notification__side-bar--right__header bg-color-purple-primary d-flex justify-content-center">
            <img class="notification__side-bar--right__header__image rounded-circle bg-color-blue-primary position-relative "></img>
        </div>

    <div class="container modal-session bg-white p-5 pt-2 mb-5 notification__side-bar--right">
        <p class="fc-black-2 justify-content-center fs-1-6 text-center">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<p>

        <p class="mt-5 fc-theme-color fs-1-6">Session Overview</p>

        <div class="d-flex justify-content-between mb-5">
            <div class="d-flex flex-column">
                <p class="fc-grey fs-1-2">Date:</p>
                <p class="fc-black-2 fs-1-4">08/02/2020 Thursday</p>
            </div>
            <div class="d-flex flex-column">
                <p class="fc-grey fs-1-2">Time:</p>
                <p class="fc-black-2 fs-1-4">3:30pm - 5:00pm</p>
            </div>
            <div class="d-flex flex-column">
                <p class="fc-grey fs-1-2">Course:</p>
                <p class="fc-black-2 fs-1-4">Math102A</p>
            </div>
            <div class="d-flex flex-column">
                <p class="fc-grey fs-1-2">Format:</p>
                <p class="fc-black-2 fs-1-4">In Person</p>
            </div>
            <div class="d-flex flex-column">
                <p class="fc-grey fs-1-2">Price:</p>
                <p class="fs-1-4 fc-theme-color">$ 28</p>
            </div>
        </div>

        <div id="calendar" style="height: 10rem"></div>

        <p class="fc-black-2 mt-5 fs-1-2"><span class="font-weight-bold">Cancellation Policy: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

        <p class="fc-black-2 mt-3 fs-1-2"><span class="font-weight-bold">Refund Policy: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>

        <div class="d-flex justify-content-center pt-5">
            <button class="btn btn-lg btn-outline-primary btn-cancel mr-3 py-2 px-5" type="button">Decline</button>
            <button class="btn btn-lg btn-primary btn-submit py-2 px-5" type="submit">Accept</button>
        </div>

    </div>

    <p class="fc-grey text-center mt-5">TutorSpace Team <br/> Email: tutorspace@gmail.com </p>
</div>
