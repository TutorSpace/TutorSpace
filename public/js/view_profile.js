$('.btn-read-more').click(() => {
    alert('TODO: lead to the review page');
});

var $window = $(window).on('resize', fitProfileImgHeight).trigger('resize'); //on page load

function fitProfileImgHeight() {
    let imgContainer = $('.about__information__img .img-container');
    var currentWidth = imgContainer.width();
    imgContainer.height(currentWidth);

}
