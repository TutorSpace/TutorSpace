require('./bootstrap');
require('select2');
window.toastr = require('toastr');

window.ColorHash = require('color-hash');

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

    // ==================== for nav display ==========================
    let pathname = window.location.pathname;
    if(pathname.startsWith('/forum')) {
        $('nav .nav__item.link-forum').addClass('active');
    }

    // ===================== for nav animation ========================
    if($('.message-welcome').length) {
        setTimeout(function() {
            $('.message-welcome').hide();
            $('.nav-right__svg-container').addClass('nav-fade-in-animation');
            $('.nav-right__profile-img').addClass('nav-fade-in-animation');
            $('.nav-right__svg-container').show();
            $('.nav-right__profile-img').show();
        }, 3700);
    }

    $('.nav-right__profile-img').click(function() {
        if($('.nav-right .nav-toggle-sm').is(":hidden")) {
            $('.profile-img-dropdown').toggle();
        }
    });

    $('.svg-list').click(function() {
        $('.profile-img-dropdown').hide();
        $(this).next().toggle();
    });

    $('.btn-go-top').click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });


    // ==================== auth overlay =================
    $('.nav .btn-sign-in').click(function() {
        $('.overlay-student').show();
    });

    $('.overlay .btn-close').click(function() {
        $('.overlay').hide();
    });

    function switchLoginIdentity() {
        $('.overlay-student').toggle();
        $('.overlay-tutor').toggle();
    }

    $('.overlay .btn-switch-login').click(function() {
        switchLoginIdentity();
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

})


