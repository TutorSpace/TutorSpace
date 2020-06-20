//  ========================= for all register page ===========================
$('input').on('input', function () {
    if ($(this).val()) {
        $(this).next().addClass('fill-color-blue-secondary');
    } else {
        $(this).next().removeClass('fill-color-blue-secondary');
    }
});

$('input').filter('[required]').on('input', function () {
    let allFilled = true;
    $.each($('input').filter('[required]'), (idx, el) => {
        if (!$(el).val())
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


$(document).ready(function() {

});




//  ========================= register student 2 ===========================
(function () {
    let totalSeconds = 30;
    let currentTimeInterval;

    // adjusting email input size
    // $(window).resize(function() {
    //     adjustInputEmailSize();
    // });

    // let adjustInputEmailSize = () => {
    //     $.each($('.form-group-4 input'), (idx, el) => {
    //         // alert($(el).height());
    //         $(el).height($(el).width() + 'px');
    //     });
    // };

    $('#resend-code').click(function () {
        // TODO: using ajax to send the email

        if (!currentTimeInterval) {
            $('#timeLabel').html(pad(totalSeconds));
            currentTimeInterval = setInterval(setTime, 1000);
            $(this).prop('disabled', true);
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


// ======================== register student 3 ====================
(function () {
    $('.custom-select').select2({});

})();

// // The tags should be always be the same as in the school_year table! Need to manully update the fields/array!
// $(function () {

//     $("#major").autocomplete({
//         source: majorTags
//     });

//     $("#schoolYear").autocomplete({
//         source: schoolYearTags
//     });
// });


// $("input[type=file]").change(function() {
//     var fileInput = $(this)[0];
//     var filename = fileInput.files[0].name;

//     $('#file-input-text').html(filename);
// });
