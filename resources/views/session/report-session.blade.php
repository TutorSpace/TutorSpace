<div class="container modal-session-cancel">
    <h6 class="w-100 text-center my-5">Post your review about this tutor session.</h6>

    <p class="font-weight-bold fc-black-2 mt-5">How is this tutor session overall?</p>
    <div class="mb-3">
        <select name="star-rating" class="form-control form-control-lg fs-1-6" required>
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
            @endfor
        </select>
    </div>

    <p class="font-weight-bold fc-black-2 mt-5">Please add more details about this tutor session.</p>

    <textarea name="review" class="w-100 fs-1-6 p-4" rows="3" required></textarea>

</div>
