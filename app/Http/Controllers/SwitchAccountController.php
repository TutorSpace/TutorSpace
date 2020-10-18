<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            if(!$request->session()->get('registerToBeTutor1')) {
                $user = User::where('email', $currUser->email)->where('is_tutor', true)->where('is_invalid', true)->first();
                if($user) {
                    Auth::login($user);
                } else {
                    Auth::login($currUser->createTutorIdentityFromStudent());
                }
                return view('home.profile', [
                    'registerToBeTutor1' => true
                ]);
            } else if($request->session()->get('registerToBeTutor1')) {
                return view('home.profile', [
                    'registerToBeTutor2' => true
                ]);
            }

        }
    }

    public function updateRegisterToBeTutor2(Request $request) {
        $validator = Validator::make($request->all(), [
            'hourly-rate' => [
                'required',
                'numeric',
                'min:10',
                'max:50'
            ]
        ]);

        if ($validator->fails()) {
            return view('home.profile', [
                'registerToBeTutor2' => true,
                'hourlyRateError' => true
            ]);
        }

        $currUser = Auth::user();
        $currUser->hourly_rate = $request->input('hourly-rate');

        if($currUser->is_tutor && $currUser->is_invalid && $currUser->first_major_id && $currUser->gpa && $currUser->hourly_rate && $currUser->school_year_id && $currUser->tutor_level_id) {
            $currUser->is_invalid = false;
            $currUser->invalid_reason = null;
            $currUser->invalid_redirect_route_name = null;
            $currUser->save();

            return redirect()->route('home.profile')->with('successMsg', 'You successfully created a tutor account!');
        }

        return redirect()->back();


    }

}
