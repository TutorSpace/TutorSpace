<?php

use Illuminate\Support\Facades\Route;


// for testing
Route::post('/test', 'testController@test')->name('test');
Route::get('/test', 'testController@index');

// index page
Route::get('/', 'GeneralController@index')->name('index');

// search for tutors in nav bar
Route::get('/search', 'SearchController@index')->name('search.index');

// subscriptions
Route::post('/subscription/subscribe', 'SubscriptionController@store')->name('subscription.store');
Route::get('/subscription/unsubscribe', 'SubscriptionController@destroy')->name('subscription.destroy');

// invite to be tutor
Route::post('/invite-to-be-tutor/{user}', 'GeneralController@inviteToBeTutor')->middleware('auth')->name('invite-to-be-tutor');

// upload photo
Route::post('/upload-profile-pic', 'GeneralController@uploadProfilePic')->middleware('auth')->name('upload-profile-pic');

// calendar
Route::group([
    'prefix' => 'calendar'
], function() {
    Route::post('/availableTime', 'CalendarController@addAvailableTime')->name('availableTime.store');
    Route::delete('/availableTime', 'CalendarController@deleteAvailableTime')->name('availableTime.delete');
});

// bookmark
Route::group([
    'prefix' => 'bookmark'
], function() {
    Route::post('/{user}', 'BookmarkController@store')->name('bookmark.store');
    Route::delete('/{user}', 'BookmarkController@delete')->name('bookmark.delete');

    // get a single user_card
    Route::get('/{user}', 'BookmarkController@show')->name('bookmark.show');
});

// recommended tutors
Route::get('/recommended-tutors', 'GeneralController@getRecommendedTutors')->middleware('auth')->name('recommended-tutors');

// private policy
Route::get('/policy', 'GeneralController@showPrivatePolicy')->name('policy.show');

// ============================  auth  ========================
Route::group([
    'prefix' => 'auth'
], function () {
    // logout
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    // send verification email for register
    Route::get('/register/send-verification-email', 'Auth\RegisterController@sendVerificationEmail');

    // google callback for register & login
    Route::get('callback', 'Auth\GoogleController@handleGoogleCallback');

    // ====================== register student =====================
    Route::get('/register/student/1', 'Auth\RegisterController@indexStudent1')->name('register.index.student.1');
    Route::post('/register/student/1', 'Auth\RegisterController@storeStudent1')->name('register.store.student.1');
    Route::get('register/google/student', 'Auth\GoogleController@registerRedirectToGoogleStudent')->name('register.google.student');

    Route::get('/register/student/2', 'Auth\RegisterController@indexStudent2')->name('register.index.student.2');
    Route::post('/register/student/2', 'Auth\RegisterController@storeStudent2')->name('register.store.student.2');

    Route::get('/register/student/3', 'Auth\RegisterController@indexStudent3')->name('register.index.student.3');
    Route::post('/register/student/3', 'Auth\RegisterController@storeStudent3')->name('register.store.student.3');


    // ====================== register tutor =====================
    Route::get('/register/tutor/1', 'Auth\RegisterController@indexTutor1')->name('register.index.tutor.1');
    Route::post('/register/tutor/1', 'Auth\RegisterController@storeTutor1')->name('register.store.tutor.1');
    Route::get('register/google/tutor', 'Auth\GoogleController@registerRedirectToGoogleTutor')->name('register.google.tutor');

    Route::get('/register/tutor/2', 'Auth\RegisterController@indexTutor2')->name('register.index.tutor.2');
    Route::post('/register/tutor/2', 'Auth\RegisterController@storeTutor2')->name('register.store.tutor.2');

    Route::get('/register/tutor/3', 'Auth\RegisterController@indexTutor3')->name('register.index.tutor.3');
    Route::post('/register/tutor/3', 'Auth\RegisterController@storeTutor3')->name('register.store.tutor.3');
    Route::get('/register/tutor/4', 'Auth\RegisterController@indexTutor4')->name('register.index.tutor.4');
    Route::post('/register/tutor/4', 'Auth\RegisterController@storeTutor4')->name('register.store.tutor.4');
    Route::get('/register/tutor/5', 'Auth\RegisterController@indexTutor5')->name('register.index.tutor.5');
    Route::post('/register/tutor/5', 'Auth\RegisterController@storeTutor5')->name('register.store.tutor.5');

    // =============== login student ===============
    Route::get('/login/student', 'Auth\LoginController@indexStudent')->name('login.index.student');
    Route::post('/login/student', 'Auth\LoginController@storeStudent')->name('login.store.student');
    Route::get('login/google/student', 'Auth\GoogleController@loginRedirectToGoogleStudent')->name('login.google.student');

    // =============== login tutor ===============
    Route::get('/login/tutor', 'Auth\LoginController@indexTutor')->name('login.index.tutor');
    Route::post('/login/tutor', 'Auth\LoginController@storeTutor')->name('login.store.tutor');
    Route::get('login/google/tutor', 'Auth\GoogleController@loginRedirectToGoogleTutor')->name('login.google.tutor');

    // ================ reset password ============
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


    // ================ password confirm ==========
    Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');
});


// ===============================  Forum  ==========================
Route::group([
    'prefix' => 'forum'
], function () {
    Route::get('/posts/search-results', 'Forum\PostController@search')->name('posts.search');
    Route::get('/posts/popular', 'Forum\PostController@indexPopular')->name('posts.popular');
    Route::get('/posts/latest', 'Forum\PostController@indexLatest')->name('posts.latest');
    Route::get('posts/my-follows', 'Forum\PostController@showMyFollows')->name('posts.my-follows');
    Route::get('posts/my-posts', 'Forum\PostController@showMyPosts')->name('posts.my-posts');
    Route::get('posts/my-participated', 'Forum\PostController@showMyParticipated')->name('posts.my-participated');
    Route::resource('posts', 'Forum\PostController');

    Route::post('posts/upload-img', 'Forum\PostController@uploadPostImg')->name('upload-post-img');
    Route::post('posts/draft', 'Forum\PostController@storeAsDraft')->name('post-draft.store');
    Route::post('posts/upvote/{post}', 'Forum\PostController@upvote')->name('post.upvote');
    Route::post('posts/follow/{post}', 'Forum\PostController@follow')->name('post.follow');

    Route::post('posts/{post}/replies/reply', 'Forum\ReplyController@storeReply')->name('posts.reply.store');
    Route::post('posts/replies/{reply}/upvote', 'Forum\ReplyController@upvote')->name('posts.reply.upvote');
    Route::post('posts/replies/{reply}/followup', 'Forum\ReplyController@storeFollowup')->name('posts.followup.store');

    Route::post('/posts/mark-best-reply/{post}/{reply}', 'Forum\PostController@markAsBestReply')->name('posts.markBestReply');

    // report
    Route::post('/report', 'GeneralController@storeReport')->middleware('auth')->name('forum.report.store');

});

// home page
Route::get('/home', 'HomeController@index')->name('home');



// profile
Route::get('/profile', 'profileController@show')->name('profile')->middleware(['auth']);
Route::get('/view_profile/{viewUserId}', 'profileController@viewProfile')->middleware(['auth']);

// edit profile
Route::get('/edit_profile', 'profileController@showEdit')->name('edit_profile')->middleware(['auth']);
Route::post('/edit_profile', 'profileController@editProfile');







// bookmark
Route::get('/bookmark_remove', 'GeneralController@removeBookmark')->middleware(['auth']);
Route::get('/bookmark_add', 'GeneralController@addBookmark')->middleware(['auth']);


// dashboard
Route::get('/dashboard', 'GeneralController@getDashboardPosts')->middleware(['auth']);
Route::post('/dashboard_add', 'GeneralController@addDashboardPosts')->middleware(['auth']);



// sessions
Route::post('/session_cancel', 'sessionController@cancelSession')->middleware(['auth']);
Route::get('/view_session/{session}', 'sessionController@viewSession')->middleware(['auth']);


// subjects
Route::post('/remove_fav_subject', 'subjectController@removeFavSubject')->middleware(['auth']);
Route::post('/add_fav_subject', 'subjectController@addFavSubject')->middleware(['auth']);

// courses
Route::post('/remove_fav_course', 'courseController@removeFavCourse')->middleware(['auth']);
Route::post('/add_fav_course', 'courseController@addFavCourse')->middleware(['auth']);

// characteristics
Route::post('/remove_characteristic', 'characteristicController@removeCharacteristic')->middleware(['auth']);
Route::post('/add_characteristic', 'characteristicController@addCharacteristic')->middleware(['auth']);

// reviews
Route::post('/post_review', 'reviewController@postReview')->middleware(['auth']);



// reports
Route::get('/report/{reportee}', 'reportController@showReport')->middleware(['auth']);
Route::post('/report/{reportee}', 'reportController@postReport')->middleware(['auth']);

// tutor requests
Route::post('/tutor_request_reject', 'GeneralController@rejectTutorRequest')->middleware(['auth']);
Route::post('/tutor_request_accept', 'GeneralController@acceptTutorRequest')->middleware(['auth']);
Route::get('/tutor_request/{tutor}', 'tutorRequestController@showMakeTutorRequest')->middleware(['auth']);
Route::get('/edit_availability', 'tutorRequestController@showEditAvailability')->middleware(['auth']);
Route::post('/edit_availability', 'tutorRequestController@saveAvailableTime')->middleware(['auth']);
Route::post('/tutor_request', 'tutorRequestController@makeTutorRequest')->middleware(['auth']);


// chatting
Route::get('/messages', 'chatController@show')->name('chatroom')->middleware(['auth']);
Route::post('/messages', 'chatController@sendMessage')->middleware(['auth']);
Route::get('/detailedMessages/{otherUserId}', 'chatController@getMessages')->middleware(['auth']);
Route::get('/messages/{otherUser}', 'chatController@showChat')->middleware(['auth']);

