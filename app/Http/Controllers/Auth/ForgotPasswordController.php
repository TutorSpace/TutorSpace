<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm(Request $request)
    {
        if($request->query('is_tutor')) {
            return view('auth.passwords.email_tutor');
        }
        else {
            return view('auth.passwords.email_student');
        }
    }

        /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // if the user does not have the identity, redirect them to the given route
        $existStudent = User::existStudent($request->input('email'));
        $existTutor = User::existTutor($request->input('email'));
        if($request->boolean('is_tutor') && !$existTutor) {
            return redirect()->route('password.request', ['is_tutor' => false])->with([
                'errorMsg' => 'You do not have a tutor account yet. Please try resetting password in your student account!'
            ]);
        }
        else if(!$request->boolean('is_tutor') && !$existStudent) {
            return redirect()->route('password.request', ['is_tutor' => true])->with([
                'errorMsg' => 'You do not have a student account yet. Please try resetting password in your tutor account!'
            ]);
        }

        // if the user is signed up using google, redirect them back
        if(User::registeredWithGoogle($request->input('email'))) {
            if($request->boolean('is_tutor')) {
                return redirect()->route('login.index.tutor')->with([
                    'errorMsg' => 'You can not reset password because you signed up using Google.'
                ]);
            }
            else {
                return redirect()->route('login.index.student')->with([
                    'errorMsg' => 'You can not reset password because you signed up using Google.'
                ]);
            }

        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);
    }

        /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'is_tutor');
    }

}
