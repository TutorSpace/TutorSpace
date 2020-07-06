$('.btn-post-type').click(function() {
    $('.btn-selected').removeClass('btn-selected');
    $(this).addClass('btn-selected');
});


tinymce.init({
    selector: 'textarea',  // change this value according to your HTML
    plugins : 'advlist link image lists',
    a_plugin_option: true,
    a_configuration_option: 400
});

