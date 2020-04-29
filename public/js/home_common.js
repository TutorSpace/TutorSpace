// select view session
$('.home__container__notifications__sessions .session__container > button:last-child').click(function () {
    window.location.href = `/view_session/${$(this).attr('data-session-id')}?from=home`;
});


// cancel session
$('.home__container__notifications__sessions .session__container > button:not(:last-child)').click(function () {
    let sessionId = $(this).attr('data-session-id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url: `/session_cancel`,
        data: {
            session_id: sessionId
        },
        success: (data) => {
            let { successMsg } = data;
            toastr.success(successMsg);
            window.location.href = '/home';
        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });

});



// for adding post
$('#add-post').click(() => {
    showAddPost();
});

// cancel button for post
$('#add-post-container .btn-cancel').click((e) => {
    e.preventDefault();
    $('#background-cover').hide();
});


// add post
$('#add-post-container').submit((e) => {
    e.preventDefault();

    let postMsg = $('#post-content').val();
    let inputCourseSubject = $('#add-post-course-subject option:selected').val();


    if(!postMsg || postMsg.trim().length === 0) {
        toastr.warning('Please enter post content!');
        return;
    }
    if(inputCourseSubject === 'Select') {
        toastr.warning('Please select which course/subject your post is about!');
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url: '/dashboard_add',
        data: {
            postMsg: postMsg,
            inputCourseSubject: inputCourseSubject
        },
        success: (data) => {
            console.log(data);
            let { successMsg } = data;
            toastr.success(successMsg);

            let inputTutorStudent = $('#search-posts option:selected').val();
            if(inputTutorStudent === 'my-posts') {
                $('#filter-form').submit();
            }
            $('#background-cover').hide();
            $('textarea').val('');
        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });
});


$('#filter-form').submit(function(e) {
    e.preventDefault();

    let inputCourseSubject = $('#search-courses-subjects option:selected').val();
    let inputTutorStudent = $('#search-posts option:selected').val();

    $.ajax({
        type:'GET',
        url: '/dashboard',
        data: {
            courseSubject: inputCourseSubject,
            tutorStudent: inputTutorStudent
        },
        success: (data) => {
            let { posts } = data;
            posts = JSON.parse(posts);

            let tbody = $('.home__container__help-center__table tbody');
            tbody.empty();


            posts.forEach(post => {
                let imgUrl = assetsURL + '/' + post.profile_pic_url;
                let fullName = post.full_name;

                let courseSubjectName;
                if(post.is_course_post)
                    courseSubjectName = post.course;
                else
                    courseSubjectName = post.subject;

                let postMsg = post.post_message;
                let postId = post.post_id;
                let userId = post.user_id;
                let dateCreated = post.post_created_time;



                dateCreated = $.datepicker.formatDate('mm/dd/yy', new Date(dateCreated));


                let element = `
                    <tr data-post-id="${postId}">
                        <th scope="row"  onclick="viewProfile(${userId})"><img src="${imgUrl}" alt="tutor pic">${fullName}</th>
                        <td>
                            <p>${dateCreated}</p><span>${courseSubjectName}</span>
                        </td>
                        <td class="post-message">${postMsg}</td>
                        <td>
                            <button class="btn btn-lg btn-primary button--small" data-post-id="${postId}" onclick="message(${userId})">
                                Send Message
                            </button>
                        </td>
                    </tr>
                `;

                if(inputTutorStudent === 'my-posts') {
                    element = `
                        <tr data-post-id="${postId}">
                            <th scope="row" onclick="viewProfile(${userId})"><img src="${imgUrl}" alt="tutor pic">${fullName}</th>
                            <td>
                                <p>${dateCreated}</p><span>${courseSubjectName}</span>
                            </td>
                            <td class="post-message">${postMsg}</td>
                        </tr>
                    `;
                }


                tbody.append(element);
            });
        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });

});




function showAddPost() {
    $('#background-cover').height(document.documentElement.scrollHeight);
    $('#background-cover').width(document.documentElement.scrollWidth);
    $('#background-cover').show();

    let centerOffset = (document.documentElement.scrollHeight - $(window).height()) / 2;
    $('html,body').animate({
            scrollTop: centerOffset
        },
        'slow'
    );

    // $('#add-post-container').height($(window).height() / 2);
}


function showSignupWizard() {
    $('#background-cover-2').height(document.documentElement.scrollHeight);
    $('#background-cover-2').width(document.documentElement.scrollWidth);
    $('#background-cover-2').show();

    let centerOffset = (document.documentElement.scrollHeight - $(window).height()) / 2;
    $('html,body').animate({
            scrollTop: centerOffset
        },
        'slow'
    );
}

function success(successMsg) {
    toastr.success(successMsg);
}

function viewProfile(id) {
    window.location.href = '/view_profile/' + id + '?from=home';
}

function message(userId) {
    window.location.href = '/messages/' + userId;
}

