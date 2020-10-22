<div class="notification__content__header font-weight-bold">
    Your tutor session has been cancelled.
</div>
<div class="notification__content__info">

        <div class="notification__side-bar--right__header bg-color-purple-primary d-flex justify-content-center">
            <img class="notification__side-bar--right__header__image rounded-circle bg-color-blue-primary position-relative "></img>
        </div>

    <div class="container modal-book-session bg-white p-5 pt-2 mb-5 notification__side-bar--right">
        <p class="fc-black-2 justify-content-center fs-1-6 text-center">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<p>

        <p class="my-5 fs-1-2">Your session has been cancelled by Nemo Enim.</p>
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

    </div>

    <p class="fc-grey text-center mt-5">TutorSpace Team <br/> Email: tutorspace@gmail.com </p>
</div>
