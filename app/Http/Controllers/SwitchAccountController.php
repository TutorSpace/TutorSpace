<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SwitchAccountController extends Controller
{
    public function register(Request $request) {
        $currUser = Auth::user();
        if($currUser->is_tutor && !$currUser->hasDualIdentities()) {
            Auth::login($currUser->createStudentIdentityFromTutor());
            $successMsg = view('switch-account.partials.switch-account-register-success', compact('currUser'))->render();

        }


        return response()->json([
            'successMsg' => $successMsg
        ]);
    }
}
