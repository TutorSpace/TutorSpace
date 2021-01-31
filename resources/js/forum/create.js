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
    content: 'Any questions you have regarding course content and professors, school majors, puzzles in your homework, and anything else you may find confused in your school life.',
    interactive: true,
    placement: 'top',
    // interactiveDebounce: 75,
    allowHTML: true,
    theme: 'help-content',
});

tippy($('#btn-class-note')[0], {
    animateFill: false,
    plugins: [animateFill],
    content: 'If you believe your class notes will help students who are currently taking or will take a particular course in the future, you are welcomed to share them and let more people benefit. However, please note that any sharing should comply with the USC Integrity Policy.',
    interactive: true,
    placement: 'top',
    // interactiveDebounce: 75,
    allowHTML: true,
    theme: 'help-content',
});

tippy($('#btn-class-review')[0], {
    animateFill: false,
    plugins: [animateFill],
    content: 'You can share your thoughts on what is the primary content of the course, how do you like your professor compared to professors in other sections, how do you think this course may contribute to the completion of your degree and your career aspiration, what kinds of students do you think should take this course, any tips for students to ace this course, etc.',
    interactive: true,
    placement: 'top',
    // interactiveDebounce: 75,
    allowHTML: true,
    theme: 'help-content',
});
