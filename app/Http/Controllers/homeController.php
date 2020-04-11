<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class homeController extends Controller
{
    public function show() {
        $user = Auth::user();

        
        if($user->is_tutor) {
            return view('home.home_tutor');
        }
        else {
            return view('home.home_student');
        }
    }
}
