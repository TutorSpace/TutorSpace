$('.btn-read-more').click((e) => {
    e.preventDefault();
    alert('TODO: lead to the review page');
});

var $window = $(window).on('resize', fitProfileImgHeight).trigger('resize'); //on page load

function fitProfileImgHeight() {
    let imgContainer = $('.about__information__img .img-container');
    var currentWidth = imgContainer.width();
    imgContainer.height(currentWidth);

}


$('.btn-request-tutor-session').click(function() {

    window.location.href = "/tutor_request/" + $(this).attr('data-tutor-id') + "?from=home";

});
