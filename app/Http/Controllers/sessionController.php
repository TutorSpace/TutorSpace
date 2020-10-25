<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Session;
use Auth;
use App\User;

class SessionController extends Controller
{


    // TODO: add validation
    public function cancelSession(Request $request) {
        $sessionId = $request->input('session_id');
        $session = Session::find($sessionId);
        $session->is_canceled = 1;
        $session->save();

        return response()->json(
            [
                'successMsg' => 'Successfully cancelled the tutor session!'
            ]
        );
    }


    // TODO: add validation
    public function viewSession(Request $request, Session $session) {
        $user = Auth::user();
        $from = $request->input('from');


        // if is upcoming session
        if($session->is_upcoming) {
            if($user->is_tutor) {
                $student = User::find($session->student_id);
                return view('session.view_upcoming_session_tutor', [
                    'user' => $user,
                    'student' => $student,
                    'from' => $from,
                    'session' => $session
                ]);
            }
            else {
                $tutor = User::find($session->tutor_id);

                return view('session.view_upcoming_session_student', [
                    'user' => $user,
                    'tutor' => $tutor,
                    'from' => $from,
                    'session' => $session
                ]);
            }

        }
        else {

            return "<h1>view past session functionality is upcoming!</h1>";
        }

    }

}
