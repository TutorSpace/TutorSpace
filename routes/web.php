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
});

// login
Route::get('/login', 'loginController@show')->name('login');
Route::post('/login', 'loginController@login');


// signup
Route::get('/signup_user', 'signupController@show');
// signup student
Route::get('/signup_student', 'signupController@showStudent')->name('signup');
Route::get('/signup_student_2', 'signupController@showStudent_2')->name('signup_2');
Route::post('/signup_student', 'signupController@signupStudent');
Route::post('/signup_student_2', 'signupController@signupStudent_2');
// signup tutor
Route::get('/signup_tutor', 'signupController@showTutor')->name('signup_tutor');
Route::get('/signup_tutor_2', 'signupController@showTutor_2')->name('signup_tutor_2');
Route::post('/signup_tutor', 'signupController@signupTutor');
Route::post('/signup_tutor_2', 'signupController@signupTutor_2');

// forget password
Route::get('/forget_password', 'forgetPasswordController@show');
Route::post('/forget_password_send', 'forgetPasswordController@send');

// profile
Route::get('/profile_student', 'profileController@showStudent')->name('profile_student');
Route::get('/profile_tutor', 'profileController@showTutor')->name('profile_tutor');



