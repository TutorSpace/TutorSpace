function isInViewPort(elem) {
	var distance = elem.getBoundingClientRect();
	return (
		distance.top >= 0 &&
		distance.left >= 0 &&
		distance.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
		distance.right <= (window.innerWidth || document.documentElement.clientWidth)
	);
};

function adjustScrollBtnVisibility() {
    if(!isInViewPort(addPostBtn[0]) || addPostBtn.is(":hidden")) {
        $('.btn-add-post-scroll').show();
    }
    else {
        $('.btn-add-post-scroll').hide();
    }

    if(($(document).scrollTop() > 400)) {
        $('.btn-go-top').show();
    }
    else {
        $('.btn-go-top').hide();
    }
}

let addPostBtn = $('.btn-add-post');

adjustScrollBtnVisibility();

$(window).scroll(function() {
    adjustScrollBtnVisibility();
});

$(window).resize(function () {
    adjustScrollBtnVisibility();
});

$('.overlay-forum-left .toggle-collapsed').click(function() {
    $('.overlay-forum-left').addClass('toggle-expand-animation');
});

$('.overlay-forum-left .toggle-expanded').click(function() {
    $('.overlay-forum-left').removeClass('toggle-expand-animation');
});


$('.forum-left__list-item').click(function() {
    let href = $(this).attr('data-location-href');
    window.location.href = href;
});
