<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/test', 'testController@test');




Route::get('/', function () {
    return view('index');
})->name('index')->middleware(['checkLogout']);

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

// tutor requests
Route::post('/tutor_request_reject', 'generalController@rejectTutorRequest')->middleware(['checkLogin']);
Route::post('/tutor_request_accept', 'generalController@acceptTutorRequest')->middleware(['checkLogin']);

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
