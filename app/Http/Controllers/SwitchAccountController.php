<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SwitchAccountController extends Controller
{
    // for student
    public function register(Request $request) {
        $currUser = Auth::user();

        // if the user does not have a VALID student account
        if(User::where('email', $currUser->email)->where('is_tutor', false)->where('is_invalid', false)->doesntExist()) {
            $user = User::where('email', $currUser->email)->where('is_tutor', false)->where('is_invalid', true)->first();
            if($user) {
                Auth::login($user);
            } else {
                Auth::login($currUser->createStudentIdentityFromTutor());
            }

            $successMsg = view('switch-account.partials.switch-account-register-success', compact('currUser'))->render();

            return response()->json([
                'successMsg' => $successMsg
            ]);
        }

    }

    public function switch() {
        $currUser = Auth::user();
        Auth::login(User::where('email', $currUser->email)->where('is_tutor', !$currUser->is_tutor)->first());

        return response()->json([
            'successMsg' => 'Successfully switched the account!'
        ]);
    }

    // for tutor
    public function indexRegisterToBeTutor(Request $request) {
        $currUser = Auth::user();

        // if the user does not have a VALID tutor account
        if(User::where('email', $currUser->email)->where('is_tutor', true)->where('is_invalid', false)->doesntExist()) {
            $user = User::where('email', $currUser->email)->where('is_tutor', true)->where('is_invalid', true)->first();
            if($user) {
                Auth::login($user);
            } else {
                Auth::login($currUser->createTutorIdentityFromStudent());
            }
            return view('home.profile', [
                'registerToBeTutor' => true
            ]);
        }
    }

}
