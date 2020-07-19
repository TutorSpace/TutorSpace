$('#tags').select2({
    placeholder: "Add post tags here..."
});

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
    if($(window).width() <= 1200) {
        $('#tags').select2({
            placeholder: "Add post tags here..."
        });
    }
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



$('.forum-content__search__search-by').change(function() {
    let val = $(this).find("option:selected").attr('value');
    if(val == 'tags') {
        $('.tags-container').removeClass('hidden');
        $('.keyword-search').addClass('hidden');
        $('#tags').select2({
            placeholder: "Add post tags here..."
        });
    }
    else {
        $('.tags-container').addClass('hidden');
        $('.keyword-search').removeClass('hidden');
    }
});

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
