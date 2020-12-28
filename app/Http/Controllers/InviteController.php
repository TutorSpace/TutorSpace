<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\InviteToBeTutorNotification;

class InviteController extends Controller
{

    // todo: modify the database and the relationship so that we only keep track of the emails instead of the user ids, because non-users can also be invited
    public function inviteToBeTutor(User $user) {
        if(!User::existTutor($user->email)) {
            if(Auth::user()->invitedUsers()->where('invited_user_id', $user->id)->exists()) {
                return response()->json(
                    [
                        'successMsg' => "This request has already been sent to $user->first_name $user->last_name"
                    ]
                );
            }
            else {
                Auth::user()->invitedUsers()->attach($user->id);
            }
            $user->notify(new InviteToBeTutorNotification(Auth::user()));
            return response()->json(
                [
                    'successMsg' => "Successfully invited $user->first_name $user->last_name to be a tutor!"
                ]
            );
        }
        else {
            return response()->json(
                [
                    'errorMsg' => 'The user already has a tutor account.'
                ]
            );
        }
    }

    public function inviteToBeTutorWithEmail(Request $request) {
        $email = $request->input('email');
        // todo: finish this function
    }

    public function index() {
        return view('invite.index');
    }

}
