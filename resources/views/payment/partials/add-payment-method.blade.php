<div class="container modal-add-payment-method">
    <form class="form--add-payment-method" method="POST" action="#">
        @csrf
        <h4>Add New Payment Method</h4>
        <div>
            <label for="first-name">First Name</label>
            <input type="text" class="form-control form-control-lg" id="first-name">
        </div>
        <div>
            <label for="last-name">Last Name</label>
            <input type="text" class="form-control form-control-lg" id="last-name">
        </div>
        <div>
            <label for="card-number">Card Number</label>
            <input type="text" class="form-control form-control-lg" id="card-number">
        </div>
        <div>
            <label for="">CCV</label>
            <input type="text" class="form-control form-control-lg" id="">
        </div>
    </form>
</div>
