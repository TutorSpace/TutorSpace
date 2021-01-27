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
        if (!$email || ctype_space($email)) {
            $result = [
                'errorMsg' => 'Please enter a valid email!'
            ];
        } else if(Auth::user()->email == $email) {
            $result = [
                'errorMsg' => 'You can not invite yourself to be a tutor.'
            ];
        } else if(!User::existTutor($email)) {
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

                if(User::existStudent($email)) {
                    User::where('email', $email)->where('is_tutor', false)->first()->notify(new InviteToBeTutorNotification($lastInvitation->invite_code, Auth::user(), true));
                } else {
                    // if not a user on our platform
                    Notification::route('mail', $email)
                    ->notify(new InviteToBeTutorNotification($lastInvitation->invite_code, Auth::user(), false));
                }
            }
        } else {
            $result = [
                    'errorMsg' => 'The user already has a tutor account.'
            ];
        }

        return $ajax ? response()->json($result) : redirect()->route('invite.index')->with($result);
    }

    public function attemptClaimBonus(Request $request, InviteUser $inviteUser) {
        $inviteUser->attempt_to_use = true;
        $inviteUser->save();

        // if already have a student identity
        if(User::where('email', $inviteUser->invited_user_email)->where('is_tutor', false)->exists()) {
            Auth::login(User::where('email', $inviteUser->invited_user_email)->where('is_tutor', false)->first());

            return redirect()->route('home')->with([
                'errorMsg' => 'You already have a student account. To claim the rewards, please use the switch account functionality in the toggle down menu by clicking your profile image.',
                'toSwitchAccount' => true
            ]);
        } else {
            return redirect()->route('register.index.tutor.1')->with([
                'successMsg' => 'You have successfully activated the invite code. Please register now to claim your rewards!'
            ]);
        }

    }

}
