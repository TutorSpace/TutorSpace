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


Route::get('/login', 'loginController@show');
Route::post('/login', 'loginController@authenticate');

Route::get('/signup_user', 'signupController@show');
Route::get('/signup_student', 'signupController@showStudent');
Route::get('/signup_tutor', 'signupController@showTutor');