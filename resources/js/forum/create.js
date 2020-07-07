$('.btn-post-type').click(function() {
    $('.btn-selected').removeClass('btn-selected');
    $(this).addClass('btn-selected');
});

$('#tags').select2({
    placeholder: "Add post tags here..."
});
