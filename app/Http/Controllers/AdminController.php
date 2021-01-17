<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexTutorVerification() {
        return view('admin.tutor-verification');
    }
}
