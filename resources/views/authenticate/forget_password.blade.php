@extends('layouts.index')
@section('title', 'forget password')

@section('content')

    <!-- fgpwd => forget password -->
    <div class="container-fluid fgpwd-outerbox">
        <div class="fgpwd-container">

            <div class="fgpwd-container__header text-center"><h1>Forgot Your Password?</h1></div>
            <div class="fgpwd-container__header-2 text-center"><h5>We'll send you an Authorization Code to the email you provide us!</h5>
            
            </div>
            <div class="fgpwd-container__inputs">
                <input type="email" class="fgpwd-container__inputs__email" name="email" placeholder="Email" id="email">
                <input type="text" class="fgpwd-container__inputs__email" id="Code" name="code" placeholder="Code">
                <input type="password" class="fgpwd-container__inputs__email" name="password" id="password" placeholder="Password">
            </div>
            
            <div class="fgpwd-container__button-container">
                <button class="btn btn-lg btn-primary btn-animated--up" id="btn-send">Send Authentication Code</button>
                <button class="btn btn-lg btn-outline-primary btn-animated--up" id="btn-back">Go Back Home</button>
            </div>

        </div>

    </div>

@endsection

@section('js')
<script>

    function sendCode(email) {
        $.ajax({
            type: 'POST',
            url: '/forget_password_send',
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {
                // $("#msg").html(data.msg);
            }
        });
    }
</script>

<script src="js/forget_password.js"></script>

@endsection