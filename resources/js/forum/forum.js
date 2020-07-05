function isInViewPort(elem) {
	var distance = elem.getBoundingClientRect();
	return (
		distance.top >= 0 &&
		distance.left >= 0 &&
		distance.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
		distance.right <= (window.innerWidth || document.documentElement.clientWidth)
	);
};

let addPostBtn = $('.btn-add-post')[0];
let trendingTags = $('.trending-tags__list-item:last-child')[0];

$(window).scroll(function() {
    if(!isInViewPort(addPostBtn)) {
        $('.btn-add-post-scroll').show();
    }
    else {
        $('.btn-add-post-scroll').hide();
    }

    if(!isInViewPort(trendingTags)) {
        $('.btn-go-top').show();
    }
    else {
        $('.btn-go-top').hide();
    }

});

$('.btn-add-post-scroll').click(function() {
    window.location.href = "/forum/add-post";
});
