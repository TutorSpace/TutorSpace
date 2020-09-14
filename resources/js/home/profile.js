$('.boxes__course .box').click(function() {
    var new_course_id = 1;
    $.ajax({
        type:'POST',
        url: '/course_add_remove',
        data: {
            new_course_id:new_course_id
        },
        success: (data) => {
            $(this).remove();
            let { successMsg } = data;
            toastr.success(successMsg);
        },
        error: function(error) {
            toastr.error(error);
        }
    });
})

$('.boxes__forum .box').click(function() {
    var new_tag_id = 1;
    $.ajax({
        type:'POST',
        url: '/tag_add_remove',
        data: {
            new_tag_id:new_tag_id
        },
        success: (data) => {
            $(this).remove();
            let { successMsg } = data;
            toastr.success(successMsg);
        },
        error: function(error) {
            toastr.error(error);
        }
    });
})



$('.autocomplete .profile__input__courses').on("keydown", function(e){
    if(e.which == 13){
        var new_tag = $('.profile__input__courses').val().toUpperCase();

        // checks if a duplicate tag is being added
        if ($('.boxes__course .box .label').text().includes(new_tag)) {
           // error message
        }
        // checks if 7 tags have been added already
        else if ($('.boxes__course .box').length == 7) {
            toastr.error("You can add at most 7 courses.");
        }
        else {
            // create new tag
            $clone = $('.boxes__course .box:first').clone( true );
            $('.label', $clone).text(new_tag);
            $('.boxes__course').append($clone);
        }
        // clear input field
        $('.profile__input__courses').val("");

    }
});


window.profile_add_course_tag_tutor = function() {
    var new_tag = $('#course').val();

    if ($('.boxes__course .box .label').text().includes(new_tag)) {
        toastr.error("The course is already selected ");
    }
    // checks if 7 tags have been added already
    else if ($('.boxes__course .box').length == 7) {
        toastr.error("You can add at most 7 courses.");
    }
    else {
        // create new tag

        //todo: remove this once the fix is made to use ids instead of course name
        var new_course_id = 1;
        $clone = $('.boxes__course .box:first').clone( true );
        $('.label', $clone).text(new_tag);

        $.ajax({
        type:'POST',
        url: '/course_add_remove',
        data: {
            new_course_id:new_course_id
        },
        success: (data) => {
            $('.boxes__course').append($clone);
            let { successMsg } = data;
            toastr.success(successMsg);
        },
        error: function(error) {
            toastr.error(error);
        }
    });
    }
    // clear input field
    $('.profile__input__courses').val("");
}


$('.autocomplete .profile__input__forum').on("keydown", function(e){
    if(e.which == 13){
        var new_tag = $('.profile__input__forum').val().toUpperCase();

        // checks if a duplicate tag is being added
        if ($('.boxes__forum .box .label').text().includes(new_tag)) {
           // error message
        }
        // checks if 7 tags have been added already
        else if ($('.boxes__forum .box').length == 10) {
            toastr.error("You can add at most 10 tags.");
            // error message
        }
        else {
            // create new tag
            $clone = $('.boxes__forum .box:first').clone( true );
            $('.label', $clone).text(new_tag);
            $('.boxes__forum').append($clone);
        }
        // clear input field
        $('.profile__input__forum').val("");

    }
});


window.profile_add_forum_tag_tutor = function() {
    var new_tag = $('#tag').val();

    if ($('.boxes__forum .box .label').text().includes(new_tag)) {
        // error message
        toastr.error("The tag is already selected ");
    }
    // checks if 7 tags have been added already
    else if ($('.boxes__forum .box').length == 10) {
        toastr.error("You can add at most 10 tags.");
    }
    else {
        // create new tag

        //todo: remove this once the fix is made to use ids instead of tag name
        var new_tag_id = 2;
        $clone = $('.boxes__forum .box:first').clone( true );
        $('.label', $clone).text(new_tag);

        $.ajax({
        type:'POST',
        url: '/tag_add_remove',
        data: {
            new_tag_id:new_tag_id
        },
        success: (data) => {
            $('.boxes__course').append($clone);
            let { successMsg } = data;
            toastr.success(successMsg);
        },
        error: function(error) {
            toastr.error(error);
        }
    });
    }
    // clear input field
    $('.profile__input__forum').val("");
}
