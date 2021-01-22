require('./bootstrap');
require('select2');

window.toastr = require('toastr');
toastr.options.preventDuplicates = true;
// toastr.options.progressBar = true;
// toastr.options.closeButton = true;
// toastr.options.timeOut = 0;
// toastr.options.extendedTimeOut = 0;



window.bootbox = require('bootbox');
window.Chart = require('chart.js');
window.moment = require('moment');
// window.moment.tz("America/Los_Angeles").format();

window.Pikaday = require('pikaday');
require('timepicker');

require('bootstrap-slider');

require('js-loading-overlay');
window.jsLoadingOverlayOptions = {
    'overlayBackgroundColor': '#666666',
    'overlayOpacity': 0.05,
    'spinnerIcon': 'ball-atom',
    'spinnerColor': '#000',
    'spinnerSize': '1x',
    'overlayIDName': 'overlay',
    'spinnerIDName': 'spinner',
};



$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('[data-toggle="tooltip"]').tooltip()

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
    } else if(pathname.startsWith('/search')) {
        $('nav .nav__item.link-find-tutor').addClass('active');
    } else if(pathname.startsWith('/help-center')) {
        $('nav .nav__item.link-support').addClass('active');
    } else if(pathname.startsWith('/invite')) {
        $('nav .nav__item.link-invite').addClass('active');
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
    $('._nav .btn-sign-in').click(function() {
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

    // ===================== nav search =================
    $('nav .svg-search').click(function() {
        $('.nav__form').submit();
    });

    // home and view profile page
    $('.btn-view-all-info-cards').click(function() {
        $(this).closest('.info-cards').find('.hidden-2').toggle("fast");
        if($(this).html().includes('View')) {
            $(this).html('Hide')
        }
        else {
            $(this).html('View All')
        }
    });

    $('.btn-view-all-info-boxes').click(function() {
        $(this).closest('.row').find('.info-boxes .hidden-2').toggle("fast");
        if($(this).html().includes('View')) {
            $(this).html('Hide')
        }
        else {
            $(this).html('View All')
        }
    });

    // toggle-customized
    $('.toggle-customized .toggle-collapsed').click(function() {
        $('.toggle-customized').addClass('toggle-expand-animation');
    });

    $('.toggle-customized .toggle-expanded').click(function() {
        $('.toggle-customized').removeClass('toggle-expand-animation');
    });

    $('.toggle-after-list-item').click(function() {
        let href = $(this).attr('data-location-href');
        window.location.href = href;
    });

    // report box
    $('.report-box .heading').click(function() {
        $('.report-box').toggleClass('report-box--animated');
    });

    $('.report-box .star-rating svg').click(function() {
        $(this).prevAll().each(function(idx, el) {
            $(el).find('path').addClass('fill-color-yellow-primary');
        })
        $(this).find('path').addClass('fill-color-yellow-primary');

        $(this).nextAll().each(function(idx, el) {
            $(el).find('path').removeClass('fill-color-yellow-primary');
        })
    });

    $('#report-box-form').submit(function(event) {
        let rating = $('.report-box .star-rating path.fill-color-yellow-primary').length;
        $(this).find('input[name=star-rating]').val(rating);

        return true;
    });
})
