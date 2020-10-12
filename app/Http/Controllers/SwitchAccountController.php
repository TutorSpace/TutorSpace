<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SwitchAccountController extends Controller
{
    public function register(Request $request) {
        $currUser = Auth::user();
        if($currUser->hasDualIdentities()) return;

        if($currUser->is_tutor) {
            Auth::login($currUser->createStudentIdentityFromTutor());
            $successMsg = view('switch-account.partials.switch-account-register-success', compact('currUser'))->render();
        }


        return response()->json([
            'successMsg' => $successMsg
        ]);
    }

    public function switch() {
        $currUser = Auth::user();
        Auth::login(User::where('email', $currUser->email)->where('is_tutor', !$currUser->is_tutor)->first());

        return response()->json([
            'successMsg' => 'Successfully switched the account!'
        ]);
    }

}
