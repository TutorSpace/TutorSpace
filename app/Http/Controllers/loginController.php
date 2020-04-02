<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class loginController extends Controller
{
    public function show() {
        return view('authenticate.show_login');
    }

    public function login() {
        
    }
}
