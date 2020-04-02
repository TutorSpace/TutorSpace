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

Route::get('/', function () {
    return view('index');
});

// login
Route::get('/login', 'loginController@show');
Route::post('/login', 'loginController@login');


// signup
Route::get('/signup_user', 'signupController@show');
Route::get('/signup_student', 'signupController@showStudent');
Route::get('/signup_tutor', 'signupController@showTutor');
Route::post('/signup_student', 'signupController@signupStudent');
Route::post('/signup_tutor', 'signupController@signupTutor');

// profile
Route::get('/profile_student', 'profileController@showStudent')->name('profile_student');
Route::get('/profile_tutor', 'profileController@showTutor')->name('profile_tutor');