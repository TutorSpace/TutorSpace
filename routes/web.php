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
Route::get('/login', 'loginController@show');
Route::post('/login', 'loginController@login');


// signup
Route::get('/signup_user', 'signupController@show');
// signup student
Route::get('/signup_student', 'signupController@showStudent')->name('signup');
Route::get('/signup_studnet_2', 'signupController@showStudent_2')->name('signup_2');
Route::post('/signup_student', 'signupController@signupStudent');
Route::post('/signup_student_2', 'signupController@signupStudent_2');

Route::get('/signup_tutor', 'signupController@showTutor');
Route::post('/signup_tutor', 'signupController@signupTutor');


// profile
Route::get('/profile_student', 'profileController@showStudent')->name('profile_student');
Route::get('/profile_tutor', 'profileController@showTutor')->name('profile_tutor');

