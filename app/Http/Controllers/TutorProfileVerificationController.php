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

    public function sendVerificationEmails(Request $request) {
        $request->validate([
            'tutor-verification-file' => [
                'required',
                'file',
                'mimes:jpeg,jpg,png,pdf,xls,xlsx,doc,docx,txt,rtf, odt,ppt,msg'
            ]
        ]);

        $mimeType = $request->file("tutor-verification-file")->getMimeType();
        dd($mimeType);
        // file exists
        if ($request->file("tutor-verification-file")){
            $user = Auth::user();
            // change tutor state to submitted
            $user->tutor_verification_status = "submitted";
            $user->save();

            // store user file
            $tutor_verification_file = $request->file('tutor-verification-file')->store('/tutor-verification-files');
            
            // send to user
            $user->notify(new TutorVerificationNotification(true, $tutor_verification_file, $mimeType));
            // send to tutorspace
            Notification::route('mail', "tutorspaceusc@gmail.com")
            ->notify(new TutorVerificationNotification(false, $tutor_verification_file, $mimeType));

            echo $mimeType;
        }
    }
}
