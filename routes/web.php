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

// edit profile 
Route::get('/edit_profile', 'profileController@showEdit')->name('edit_profile')->middleware(['checkLogin']);
Route::post('/edit_profile', 'profileController@editProfile');

// home page
Route::get('/home_student', function() {
    return "<h1>home student page</h1>";
})->name('home_student')->middleware(['checkLogin']);
Route::get('/home_tutor', function() {
    return "<h1>home tutor page</h1>";
})->name('home_tutor')->middleware(['checkLogin']);;


Route::get('/logout', 'loginController@logout')->name('logout')->middleware(['checkLogin']);



