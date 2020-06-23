<?php

use Illuminate\Support\Facades\Route;


// for testing
Route::get('/test', 'testController@test');

// index page
Route::get('/', 'GeneralController@index')->name('index');

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
    Route::get('/reset-password/student', 'Auth\ResetPasswordController@indexResetPasswordStudent')->name('reset-password.index.student');
    Route::post('/reset-password/student', 'Auth\ForgotPasswordController@resetPasswordStudent')->name('reset-password.store.student');
    Route::get('/reset-password/tutor', 'Auth\ResetPasswordController@indexResetPasswordTutor')->name('reset-password.index.tutor');
    Route::post('/reset-password/tutor', 'Auth\ForgotPasswordController@resetPasswordTutor')->name('reset-password.store.tutor');
});


// login
Route::get('/login', 'loginController@show')->name('login')->middleware(['checkLogout']);
Route::post('/login', 'loginController@login');



// signup
Route::get('/signup_user', 'signupController@show')->middleware(['checkLogout']);
// signup student
Route::get('/signup_student', 'signupController@showStudent')->name('signup')->middleware(['checkLogout']);
Route::get('/signup_student_2', 'signupController@showStudent_2')->name('signup_2')->middleware(['checkLogout']);
Route::post('/signup_student', 'signupController@signupStudent');
Route::post('/signup_student_2', 'signupController@signupStudent_2');
// signup tutor
Route::get('/signup_tutor', 'signupController@showTutor')->name('signup_tutor')->middleware(['checkLogout']);
Route::get('/signup_tutor_2', 'signupController@showTutor_2')->name('signup_tutor_2')->middleware(['checkLogout']);
Route::post('/signup_tutor', 'signupController@signupTutor');
Route::post('/signup_tutor_2', 'signupController@signupTutor_2');

// forget password
Route::get('/forget_password', 'forgetPasswordController@show')->middleware(['checkLogout']);
Route::post('/forget_password_send', 'forgetPasswordController@send');

// profile
Route::get('/profile', 'profileController@show')->name('profile')->middleware(['auth']);
Route::get('/view_profile/{viewUserId}', 'profileController@viewProfile')->middleware(['auth']);

// edit profile
Route::get('/edit_profile', 'profileController@showEdit')->name('edit_profile')->middleware(['auth']);
Route::post('/edit_profile', 'profileController@editProfile');



// log out
Route::get('/logout', 'loginController@logout')->name('logout')->middleware(['auth']);


// home page
Route::get('/home', 'homeController@show')->name('home')->middleware(['auth']);


// search page
Route::get('/search', 'searchController@show')->name('search')->middleware(['auth']);


// bookmark
Route::get('/bookmark_remove', 'generalController@removeBookmark')->middleware(['auth']);
Route::get('/bookmark_add', 'generalController@addBookmark')->middleware(['auth']);


// dashboard
Route::get('/dashboard', 'generalController@getDashboardPosts')->middleware(['auth']);
Route::post('/dashboard_add', 'generalController@addDashboardPosts')->middleware(['auth']);



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
Route::post('/tutor_request_reject', 'generalController@rejectTutorRequest')->middleware(['auth']);
Route::post('/tutor_request_accept', 'generalController@acceptTutorRequest')->middleware(['auth']);
Route::get('/tutor_request/{tutor}', 'tutorRequestController@showMakeTutorRequest')->middleware(['auth']);
Route::get('/edit_availability', 'tutorRequestController@showEditAvailability')->middleware(['auth']);
Route::post('/edit_availability', 'tutorRequestController@saveAvailableTime')->middleware(['auth']);
Route::post('/tutor_request', 'tutorRequestController@makeTutorRequest')->middleware(['auth']);


// chatting
Route::get('/messages', 'chatController@show')->name('chatroom')->middleware(['auth']);
Route::post('/messages', 'chatController@sendMessage')->middleware(['auth']);
Route::get('/detailedMessages/{otherUserId}', 'chatController@getMessages')->middleware(['auth']);
Route::get('/messages/{otherUser}', 'chatController@showChat')->middleware(['auth']);

