require('./bootstrap');
require('select2');
window.toastr = require('toastr');




$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('select').each(function(idx, ele) {
        if($(this).find('option:selected').prop('disabled')){
            //Selected option is disabled
            $(this).next().find('.select2-selection__rendered').addClass('fc-grey');
            $(this).next().find('.select2-selection__rendered').removeClass('fc-black');
        }
    });

    $("select").change(function(){
        if($(this).find('option:selected').prop('disabled')){
            //Selected option is disabled
            $(this).next().find('.select2-selection__rendered').addClass('fc-grey');
            $(this).next().find('.select2-selection__rendered').removeClass('fc-black');
        }
        else {
            $(this).next().find('.select2-selection__rendered').removeClass('fc-grey');
            $(this).next().find('.select2-selection__rendered').addClass('fc-black');
        }
    });

    // for  square display
    let adjustSquareSize = () => {
        $.each($('.square'), (idx, el) => {
            $(el).height($(el).width() + 'px');
        });
    };
    adjustSquareSize();
    $(window).resize(function() {
        adjustSquareSize();
    });

    // for nav animation
    setTimeout(function() {
        $('.message-welcome').hide();
        $('.nav-right__svg-container').addClass('nav-fade-in-animation');
        $('.nav-right__profile-img').addClass('nav-fade-in-animation');
        $('.nav-right__svg-container').show();
        $('.nav-right__profile-img').show();

    }, 3700);

    $('.nav-right__profile-img').click(function() {
        if($('.nav-right .nav-toggle-sm').is(":hidden")) {
            $('.profile-img-dropdown').toggle();
        }
    });

    $('.svg-list').click(function() {
        $('.profile-img-dropdown').hide();
        $(this).next().toggle();
    });

})


