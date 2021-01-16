$('#tags').select2({
    placeholder: "Add post tags here...",
    ajax: {
        url: '/autocomplete/data-source/tags',
        dataType: 'json',
        processResults: function (data) {
            return {
                results: data
            };
        }
    }
});

$('.forum-left__list-item').click(function() {
    let href = $(this).attr('data-location-href');
    window.location.href = href;
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
            placeholder: "Add post tags here...",
            ajax: {
                url: '/autocomplete/data-source/tags',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });
    }
});


$('.forum-content__search__search-by').change(function() {
    let val = $(this).find("option:selected").attr('value');
    if(val == 'tags') {
        $('.forum-content__search .tags-container').removeClass('hidden');
        $('.keyword-search').addClass('hidden');
        $('#tags').select2({
            placeholder: "Add post tags here...",
            ajax: {
                url: '/autocomplete/data-source/tags',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });
    }
    else {
        $('.forum-content__search .tags-container').addClass('hidden');
        $('.keyword-search').removeClass('hidden');
    }
});

$('#forum__input-search-keyword').keypress(function(e) {
    if(e.keyCode == 13) {
        $('.forum-content__search').submit();
    }
});


$('#svg-tags, #svg-keyword').click(function() {
    $('.forum-content__search').submit();
})



$('.btn-filter').click(function() {
    $('.filter-container__content').toggleClass('hidden');
});
