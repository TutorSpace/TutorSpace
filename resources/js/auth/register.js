//  ========================= for all register page ===========================
$('input').on('input', function () {
    if ($(this).val()) {
        if(isStudent)
            $(this).next().addClass('fill-color-blue-primary');
        else
            $(this).next().addClass('fill-color-purple-primary');
    } else {
        if(isStudent)
            $(this).next().removeClass('fill-color-blue-primary');
        else
            $(this).next().removeClass('fill-color-purple-primary');
    }
});

$('input').filter('[required]').on('input', function () {
    let allFilled = true;
    $.each($('input').filter('[required]'), (idx, el) => {
        if (!$(el).val())
            allFilled = false;
        if($(el).attr('type') == 'password' && $(el).val().length < 6)
            allFilled = false;
    });

    if (allFilled) {
        $('.btn-next').addClass('btn-next-animation');
        if (isStudent)
            $('.btn-next').addClass('btn-student');
        else
            $('.btn-next').addClass('btn-tutor');
        $('.btn-next').removeClass('bg-grey');
    } else {
        $('.btn-next').removeClass('btn-next-animation');
        if (isStudent)
            $('.btn-next').removeClass('btn-student');
        else
            $('.btn-next').removeClass('btn-tutor');
        $('.btn-next').addClass('bg-grey');
    }
});

$(".signup-form-input-email").on('input', function() {

});
$(".signup-form-input-email").keypress(function(e) {
    var inputs = $(this).closest('form').find(':input');
    inputs.eq( inputs.index(this)+ 1 ).focus();
});
$('.signup-form-input-email').keydown(function(e) {
    if(e.keyCode == 46 || e.keyCode == 8) {
        var inputs = $(this).closest('form').find(':input');
        if(!$(this).is(':last-child')) {
            if($(this).val()) {
                $(this).val('');
            }
            else {
                inputs.eq( inputs.index(this) - 1 ).focus();
                inputs.eq( inputs.index(this) - 1 ).val('');
            }
        }
        else {
            if($(this).val()) {
                $(this).val('');
            }
            else {
                inputs.eq( inputs.index(this) - 1 ).focus();
                inputs.eq( inputs.index(this) - 1).val('');
            }
        }
    }
});

$('select').filter('[required]').on('change', function() {
    let allFilled = true;
    $.each($('select').filter('[required]'), (idx, el) => {
        if (!$(el).find(':selected').val() || $(el).find(':selected').prop('disabled'))
            allFilled = false;
    });

    if (allFilled) {
        $('.btn-next').addClass('btn-next-animation');
        if (isStudent)
            $('.btn-next').addClass('btn-student');
        else
            $('.btn-next').addClass('btn-tutor');
        $('.btn-next').removeClass('bg-grey');
    } else {
        $('.btn-next').removeClass('btn-next-animation');
        if (isStudent)
            $('.btn-next').removeClass('btn-student');
        else
            $('.btn-next').removeClass('btn-tutor');
        $('.btn-next').addClass('bg-grey');
    }
});

$('svg').click(function() {
    let route = $(this).attr('data-back-href');
    if(route)
        window.location.href = route;
});


$('.custom-select').select2({});

$('#courses').select2({
    placeholder: "Search by course number"
});

$('.select-clear').click(function() {
    $('select').val(null).trigger('change');
})

$('.icon-upload-image').click(function() {
    $('#profile-pic').click();
})

$('.file-input-text-container').hide();
$('#file-input-text').click(function() {
    $('.file-input-text-container').hide();
    $('input[type=file]').val('');
});

$("input[type=file]").change(function() {
    $('.file-input-text-container').show();
    var fileInput = $(this)[0];
    var filename = fileInput.files[0].name;

    $('#file-input-text').html("Uploaded image: " + filename);
});

//  ========================= register student 2 ===========================
(function () {
    let totalSeconds = 30;
    let currentTimeInterval;

    startTimeLabel();

    function startTimeLabel() {
        $('#timeLabel').html(pad(totalSeconds));
        currentTimeInterval = setInterval(setTime, 1000);
        $('#resend-code').prop('disabled', true);
    }

    $('#resend-code').click(function () {
        if (!currentTimeInterval) {
            // use ajax to send the email
            $.ajax({
                type:'GET',
                url: `/auth/register/send-verification-email`,
                data: {

                },
                success: (data) => {
                    let { successMsg } = data;
                    toastr.success(successMsg);
                    console.log("success");
                },
                error: function(error) {
                    console.log(error);
                    toastr.error(error);
                }
            });
            startTimeLabel();
        }
    });

    function setTime() {
        --totalSeconds;
        if (totalSeconds > 0)
            $('#timeLabel').html(pad(totalSeconds));
        else {
            totalSeconds = 30;
            $('#timeLabel').html('');
            clearInterval(currentTimeInterval);
            currentTimeInterval = null;
            $('#resend-code').prop('disabled', false);
        }
    }

    function pad(val) {
        let pre = " in ";
        let suffix = ' s';
        var valString = val + "";
        if (valString.length < 2) {
            return pre + "0" + valString + suffix;
        } else {
            return pre + valString + suffix;
        }
    }
})();



