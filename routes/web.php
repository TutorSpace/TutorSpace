<?php

use Illuminate\Support\Facades\Route;


// for testing
Route::get('/test', 'testController@test');

// index page
Route::get('/', 'GeneralController@index')->name('index');

// subscriptions
Route::post('/subscription/subscribe', 'SubscriptionController@store')->name('subscription.store');
Route::get('/subscription/unsubscribe', 'SubscriptionController@destroy')->name('subscription.destroy');

// private policy
Route::get('/policy', 'GeneralController@showPrivatePolicy')->name('policy.show');

// auth
Route::group([
    'prefix' => 'auth'
], function () {
    // logout
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    // send verification email for register
    Route::get('/register/send-verification-email', 'Auth\RegisterController@sendVerificatioinEmail');

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


// profile
Route::get('/profile', 'profileController@show')->name('profile')->middleware(['auth']);
Route::get('/view_profile/{viewUserId}', 'profileController@viewProfile')->middleware(['auth']);

// edit profile
Route::get('/edit_profile', 'profileController@showEdit')->name('edit_profile')->middleware(['auth']);
Route::post('/edit_profile', 'profileController@editProfile');

// home page
Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth']);


// search page
Route::get('/search', 'searchController@show')->name('search')->middleware(['auth']);


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

// search
Route::get('/search', 'searchController@show')->middleware(['auth']);

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

