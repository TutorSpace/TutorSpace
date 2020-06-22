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
    // index page of auth
    Route::get('/', 'Auth\LoginController@indexAuth')->name('auth.index')->middleware(['checkLogout']);

    // logout
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    // send verification email for register
    Route::get('/register/send-verification-email', 'Auth\RegisterController@sendVerificatioinEmail')->middleware(['checkLogout']);

    // google callback for register & login
    Route::get('callback', 'Auth\GoogleController@handleGoogleCallback')->middleware(['checkLogout']);

    // ====================== register student =====================
    Route::get('/register/student/1', 'Auth\RegisterController@indexStudent1')->name('register.index.student.1')->middleware(['checkLogout']);
    Route::post('/register/student/1', 'Auth\RegisterController@storeStudent1')->name('register.store.student.1')->middleware(['checkLogout']);
    Route::get('register/google/student', 'Auth\GoogleController@registerRedirectToGoogleStudent')->name('register.google.student')->middleware(['checkLogout']);

    Route::get('/register/student/2', 'Auth\RegisterController@indexStudent2')->name('register.index.student.2')->middleware(['checkLogout']);
    Route::post('/register/student/2', 'Auth\RegisterController@storeStudent2')->name('register.store.student.2')->middleware(['checkLogout']);

    Route::get('/register/student/3', 'Auth\RegisterController@indexStudent3')->name('register.index.student.3')->middleware(['checkLogout']);
    Route::post('/register/student/3', 'Auth\RegisterController@storeStudent3')->name('register.store.student.3')->middleware(['checkLogout']);


    // ====================== register tutor =====================
    Route::get('/register/tutor/1', 'Auth\RegisterController@indexTutor1')->name('register.index.tutor.1')->middleware(['checkLogout']);
    Route::post('/register/tutor/1', 'Auth\RegisterController@storeTutor1')->name('register.store.tutor.1')->middleware(['checkLogout']);
    Route::get('register/google/tutor', 'Auth\GoogleController@registerRedirectToGoogleTutor')->name('register.google.tutor')->middleware(['checkLogout']);

    Route::get('/register/tutor/2', 'Auth\RegisterController@indexTutor2')->name('register.index.tutor.2')->middleware(['checkLogout']);
    Route::post('/register/tutor/2', 'Auth\RegisterController@storeTutor2')->name('register.store.tutor.2')->middleware(['checkLogout']);

    Route::get('/register/tutor/3', 'Auth\RegisterController@indexTutor3')->name('register.index.tutor.3')->middleware(['checkLogout']);
    Route::post('/register/tutor/3', 'Auth\RegisterController@storeTutor3')->name('register.store.tutor.3')->middleware(['checkLogout']);


    // =============== login student ===============
    Route::get('/login/student', 'Auth\LoginController@indexStudent')->name('login.index.student')->middleware(['checkLogout']);
    Route::post('/login/student', 'Auth\LoginController@storeStudent')->name('login.store.student')->middleware(['checkLogout']);
    Route::get('login/google/student', 'Auth\GoogleController@loginRedirectToGoogleStudent')->name('login.google.student')->middleware(['checkLogout']);

    // =============== login tutor ===============
    Route::get('/login/tutor', 'Auth\LoginController@indexTutor')->name('login.index.tutor')->middleware(['checkLogout']);
    Route::post('/login/tutor', 'Auth\LoginController@storeTutor')->name('login.store.tutor')->middleware(['checkLogout']);
    Route::get('login/google/tutor', 'Auth\GoogleController@loginRedirectToGoogleTutor')->name('login.google.tutor')->middleware(['checkLogout']);



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
Route::get('/profile', 'profileController@show')->name('profile')->middleware(['checkLogin']);
Route::get('/view_profile/{viewUserId}', 'profileController@viewProfile')->middleware(['checkLogin']);

// edit profile
Route::get('/edit_profile', 'profileController@showEdit')->name('edit_profile')->middleware(['checkLogin']);
Route::post('/edit_profile', 'profileController@editProfile');



// log out
Route::get('/logout', 'loginController@logout')->name('logout')->middleware(['checkLogin']);


// home page
Route::get('/home', 'homeController@show')->name('home')->middleware(['checkLogin']);


// search page
Route::get('/search', 'searchController@show')->name('search')->middleware(['checkLogin']);


// bookmark
Route::get('/bookmark_remove', 'generalController@removeBookmark')->middleware(['checkLogin']);
Route::get('/bookmark_add', 'generalController@addBookmark')->middleware(['checkLogin']);


// dashboard
Route::get('/dashboard', 'generalController@getDashboardPosts')->middleware(['checkLogin']);
Route::post('/dashboard_add', 'generalController@addDashboardPosts')->middleware(['checkLogin']);



// sessions
Route::post('/session_cancel', 'sessionController@cancelSession')->middleware(['checkLogin']);
Route::get('/view_session/{session}', 'sessionController@viewSession')->middleware(['checkLogin']);


// subjects
Route::post('/remove_fav_subject', 'subjectController@removeFavSubject')->middleware(['checkLogin']);
Route::post('/add_fav_subject', 'subjectController@addFavSubject')->middleware(['checkLogin']);

// courses
Route::post('/remove_fav_course', 'courseController@removeFavCourse')->middleware(['checkLogin']);
Route::post('/add_fav_course', 'courseController@addFavCourse')->middleware(['checkLogin']);

// characteristics
Route::post('/remove_characteristic', 'characteristicController@removeCharacteristic')->middleware(['checkLogin']);
Route::post('/add_characteristic', 'characteristicController@addCharacteristic')->middleware(['checkLogin']);

// reviews
Route::post('/post_review', 'reviewController@postReview')->middleware(['checkLogin']);

// search
Route::get('/search', 'searchController@show')->middleware(['checkLogin']);

// reports
Route::get('/report/{reportee}', 'reportController@showReport')->middleware(['checkLogin']);
Route::post('/report/{reportee}', 'reportController@postReport')->middleware(['checkLogin']);

// tutor requests
Route::post('/tutor_request_reject', 'generalController@rejectTutorRequest')->middleware(['checkLogin']);
Route::post('/tutor_request_accept', 'generalController@acceptTutorRequest')->middleware(['checkLogin']);
Route::get('/tutor_request/{tutor}', 'tutorRequestController@showMakeTutorRequest')->middleware(['checkLogin']);
Route::get('/edit_availability', 'tutorRequestController@showEditAvailability')->middleware(['checkLogin']);
Route::post('/edit_availability', 'tutorRequestController@saveAvailableTime')->middleware(['checkLogin']);
Route::post('/tutor_request', 'tutorRequestController@makeTutorRequest')->middleware(['checkLogin']);


// chatting
Route::get('/messages', 'chatController@show')->name('chatroom')->middleware(['checkLogin']);
Route::post('/messages', 'chatController@sendMessage')->middleware(['checkLogin']);
Route::get('/detailedMessages/{otherUserId}', 'chatController@getMessages')->middleware(['checkLogin']);
Route::get('/messages/{otherUser}', 'chatController@showChat')->middleware(['checkLogin']);

