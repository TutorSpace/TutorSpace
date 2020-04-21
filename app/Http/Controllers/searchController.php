<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class searchController extends Controller
{


    public function show() {
        $user = Auth::user();

        if($user->is_tutor) {
            return view('search.search_for_student', [
                'user' => $user
            ]);
        }
        else {
            return view('search.search_for_tutor', [
                'user' => $user
            ]);
        }
    }
}
