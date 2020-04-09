<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class profileController extends Controller
{
    public function show(Request $request) {
        $user = Auth::user();
        if($user->is_tutor) {
            return view('profile.profile_tutor');
        }
        else {
            return view('profile.profile_student');
        }
        
    }

    public function showEdit() {
        $user = Auth::user();
        if($user->is_tutor) {
            return view('profile.edit_profile_tutor');
        }
        else {
            return view('profile.edit_profile_student');
        }
    }

    
}
