import tippy, {animateFill} from 'tippy.js';

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

tippy($('#btn-question')[0], {
    animateFill: false,
    plugins: [animateFill],
    content: 'Any questions you have regarding course content and professors, school majors, puzzles in your homework, and anything else you find confusing in your school life.',
    interactive: true,
    placement: 'top',
    // interactiveDebounce: 75,
    allowHTML: true,
    theme: 'help-content',
});

tippy($('#btn-class-note')[0], {
    animateFill: false,
    plugins: [animateFill],
    content: 'Share your class notes that you think will help other students taking the same courses. Note that any sharing should comply with the USC Integrity Policy.',
    interactive: true,
    placement: 'top',
    // interactiveDebounce: 75,
    allowHTML: true,
    theme: 'help-content',
});

tippy($('#btn-class-review')[0], {
    animateFill: false,
    plugins: [animateFill],
    content: 'Share what the primary content of the course is, how you like the professor, how you think this course contributes to your career aspiration, what kind of students you think should take it, any tips for students to ace this course, etc.',
    interactive: true,
    placement: 'top',
    // interactiveDebounce: 75,
    allowHTML: true,
    theme: 'help-content',
});
