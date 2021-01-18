<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\InviteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InviteToBeTutorNotification;

class InviteController extends Controller
{

    public function inviteToBeTutor(User $user) {
        return $this->inviteHelper($user->email, true);
    }

    public function inviteToBeTutorWithEmail(Request $request) {
        $email = $request->input('email');
        return $this->inviteHelper($email, false);
    }

    public function index() {
        return view('invite.index');
    }

    private function inviteHelper($email, $ajax) {
        if(!User::existTutor($email)) {
            $invitedBefore = InviteUser::where('user_id', Auth::id())->where('invited_user_email', $email)->exists();
            $lastInvitation = InviteUser::where('user_id', Auth::id())->where('invited_user_email', $email)->first();
            // if sent within 1 day ago and have sent before
            if($invitedBefore && $lastInvitation->updated_at->diff(Carbon::now())->days < 1) {
                $result = [
                    'errorMsg' => 'You have already sent the invitation recently. Please try again tomorrow.'
                ];
            } else {
                $result = [
                    'successMsg' => 'Successfully sent the invitation.'
                ];
                if(!$invitedBefore) {
                    $lastInvitation = new InviteUser();
                    $lastInvitation->user_id = Auth::id();
                    $lastInvitation->invited_user_email = $email;
                }
                $lastInvitation->invite_code = uniqid();
                $lastInvitation->save();

                User::where('email', $email)->where('is_tutor', false)->first()->notify(new InviteToBeTutorNotification($lastInvitation->invite_code, Auth::user()));
            }
        } else {
            $result = [
                    'errorMsg' => 'The user already has a tutor account.'
            ];
        }

        return $ajax ? response()->json($result) : redirect()->route('invite.index')->with($result);
    }

}
