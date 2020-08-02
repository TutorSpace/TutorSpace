const { success } = require("toastr");

let colorHash = new ColorHash({
    hue: [ {min: 70, max: 90}, {min: 180, max: 210}, {min: 270, max: 285} ]
});

$.each($('.tag'), (idx, ele) => {
    var color = colorHash.rgb($(ele).html());

    var d = 0;
    // Counting the perceptive luminance - human eye favors green color...
    let luminance = ( 0.299 * color[0] + 0.587 * color[1] + 0.114 * color[2])/255;

    if (luminance > 0.5)
        d = 0; // bright colors - black font
    else
        d = 255; // dark colors - white font

    $(ele).css("background-color", `rgb(${color[0]}, ${color[1]}, ${color[2]})`);
    $(ele).css("color", `rgb(${d}, ${d}, ${d})`);
});


// upload photo
$('#upload-profile-pic').click(function() {
    $('#input-profile-pic').click();
});

$("#input-profile-pic").change(function() {
    var fileInput = $(this)[0];
    var file = fileInput.files[0];
    var formData = new FormData();
    formData.append('profile-pic', file);

    $.ajax({
        type:'POST',
        url: $('#profile-pic-form').attr('action'),
        data: formData,
        contentType: false,
        processData: false,
        success: (data) => {
            toastr.success('Successfully uploaded the image!');
            $('#profile-image').attr('src', storageUrl + data.imgUrl);
            $('.nav-right__profile-img').attr('src', storageUrl + data.imgUrl);
        },
        error: function(error) {
            toastr.error('Something went wrong. Please try again.');
            console.log(error);
        }
    });
});

if ($('.bookmarked-tutors').prop('scrollHeight') > $('.bookmarked-tutors').prop('clientHeight')) {
    //if 'true', the content overflows the tab: we show the hidden link
    $('.bookmarked-tutors + .scroll-faded').css('display', 'block');
}

if ($('.tutor-requests').prop('scrollHeight') > $('.tutor-requests').prop('clientHeight')) {
    //if 'true', the content overflows the tab: we show the hidden link
    $('.tutor-requests + .scroll-faded').css('display', 'block');
}

$('.btn-view-all-upcoming-sessions').click(function() {
    $(this).parent().next().find('.hidden-2').toggle("fast");
    if($(this).html().includes('View')) {
        $(this).html('Hide Upcoming Sessions')
    }
    else {
        $(this).html('View All Upcoming Sessions')
    }

});


function isInViewPort(elem) {
    var distance = elem.getBoundingClientRect();
    console.log(distance);
	return (
		distance.top >= -120
	);
};

$(window).scroll(function() {
    if(isInViewPort($('.home__header')[0])) {
        if($('body').hasClass('bg-student')) {
            $('nav.nav').addClass('nav-auth--student');
            $('nav.nav').addClass('nav-auth');
            $('nav.nav').removeClass('nav-guest');
            $('nav.nav').removeClass('nav-guest--student');
        }
        else if($('body').hasClass('bg-tutor')) {
            $('nav.nav').addClass('nav-auth--tutor');
            $('nav.nav').addClass('nav-auth');
            $('nav.nav').removeClass('nav-guest');
            $('nav.nav').removeClass('nav-guest--tutor');
        }
    }
    else {
        if($('body').hasClass('bg-student')) {
            $('nav.nav').removeClass('nav-auth--student');
            $('nav.nav').removeClass('nav-auth');
            $('nav.nav').addClass('nav-guest');
            $('nav.nav').addClass('nav-guest--student');
        }
        else if($('body').hasClass('bg-tutor')) {
            $('nav.nav').removeClass('nav-auth--tutor');
            $('nav.nav').removeClass('nav-auth');
            $('nav.nav').addClass('nav-guest');
            $('nav.nav').addClass('nav-guest--tutor');
        }
    }
});
