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
        console.log('here');
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
    }
    else {
        $('.tags-container').addClass('hidden');
        $('.keyword-search').removeClass('hidden');
    }
});


// $('.forum-content__search .select2-search__field').keypress(function() {
//     var keycode = (event.keyCode ? event.keyCode : event.which);
//     if(keycode == '13'){
//         alert('You pressed a "enter" key in textbox');
//     }
// });

