<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';


    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        if($request->query('is_tutor') == '1') {
            return view('auth.passwords.reset_tutor')->with(
                ['token' => $token, 'email' => $request->email]
            );
        }
        else if($request->query('is_tutor') == '0') {
            return view('auth.passwords.reset_student')->with(
                ['token' => $token, 'email' => $request->email]
            );
        }
        else {
            Log::debug('error in reset password controller.');
            return redirect()->route('index')->with([
                'errorMsg' => 'Something went wrong when resetting the password. Please contact tutorspacehelp@gmail.com for more details'
            ]);
        }
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {

        // should put the variable out of the forloop, because hash make is different even with the same content.
        $password = Hash::make($password);

        // reset the password of all the users with the same email
        foreach(User::where('email', $user->email)->get() as $tempUser) {
            $tempUser->password = $password;
            $tempUser->save();
        }

        event(new PasswordReset($user));

        request()->session()->put('successMsg', 'Successfully reset your password.');
        $this->guard()->login($user);
    }
}
