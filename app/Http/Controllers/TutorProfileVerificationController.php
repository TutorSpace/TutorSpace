<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TutorVerificationNotification;

class TutorProfileVerificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        echo 222;
        dd("ac");
        //
    }
    public function sendVerificationEmails(Request $request) {
        $request->validate([
            'tutor-verification-file' => [
                'required',
                'file',
                'mimes:jpeg,jpg,bmp,png,pdf'
            ]
        ]);

        $mimeType = $request->file("tutor-verification-file")->getMimeType();
        
        if ($request->file("tutor-verification-file")){
            // store user file
            $tutor_verification_file = $request->file('tutor-verification-file')->store('/tutor-verification-files');
         
            $user = Auth::user();
            // send to user
            $user->notify(new TutorVerificationNotification(true, $tutor_verification_file, $mimeType));
            // send to tutorspace
            Notification::route('mail', "huan773@usc.edu")
            ->notify(new TutorVerificationNotification(false, $tutor_verification_file, $mimeType));

            echo $mimeType;
        }
        
    }
}
