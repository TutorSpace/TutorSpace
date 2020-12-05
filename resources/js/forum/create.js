$('.btn-post-type').click(function() {
    $('.btn-selected').removeClass('btn-selected');
    $(this).addClass('btn-selected');
    $('#input-hidden-post-type').val($(this).attr('data-post-type-id'));
});

$('#create-tags').select2({
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
