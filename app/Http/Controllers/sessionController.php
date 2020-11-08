<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Session;
use Auth;
use App\User;

class SessionController extends Controller
{

    public function cancelSession(Request $request, Session $session) {
        $request->validate([
            'cancelReasonId' => [
                'required',
                'exists:session_cancel_reasons,id'
            ]
        ]);

        $session->is_canceled = true;

        $session->cancelReason()->associate($request->input('cancelReasonId'));

        $session->save();

        return response()->json(
            [
                'successMsg' => 'Successfully cancelled the tutor session!'
            ]
        );
    }


}
