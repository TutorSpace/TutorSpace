$('.btn-post-type').click(function() {
    $('.btn-selected').removeClass('btn-selected');
    $(this).addClass('btn-selected');
});


tinymce.init({
    selector: 'textarea',  // change this value according to your HTML
    plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'table emoticons template paste help imagetools'
    ],
    height: 300,
    a_plugin_option: true,
    a_configuration_option: 400
});

$('#tags').select2({
    placeholder: "Add post tags here..."
});
