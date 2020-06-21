<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Hash;

use App\User;
use App\Major;
use App\School_year;
use App\Rules\NotExistTutor;
use Illuminate\Http\Request;
use App\Rules\NotExistStudent;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Notification;
use App\Notifications\RegisterEmailVerification;


class RegisterController extends Controller
{
    public function sendVerificatioinEmail(Request $request) {
        $email = $request->session()->get('registerDataStudent')['email'];
        $firstName = $request->session()->get('registerDataStudent')['first-name'];
        $verificationCode = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        $request->session()->put('verificationCodeStudent', $verificationCode);
        Notification::route('mail', $email)
            ->notify(new RegisterEmailVerification($verificationCode, $firstName));

        return response()->json(
            [
                'successMsg' => 'Successfully sent the email!'
            ]
        );
    }

    public function indexStudent1(Request $request) {
        return view('admin.register_student_1');
    }

    // register using password (not Google)
    public function storeStudent1(Request $request) {
        $request->validate([
            'first-name' => ['
                required',
                'alpha'
            ],
            'last-name' => ['
                required',
                'alpha'
            ],
            'email' => [
                'required',
                'email:rfc'
            ],
            'password' => [
                'required',
                'min:6'
            ]
        ]);


        // TOTEST
        // email must not be registered as a student before
        $request->validate([
            'email' => [new NotExistStudent]
        ]);

        // clear all the session data for safety concerns (no one can play around with the email verification process)
        $request->session()->flush();

        // validate the information and stores in the session
        $request->session()->put('registerDataStudent', $request->all());


        // email verification
        $verificationCode = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        $request->session()->put('verificationCodeStudent', $verificationCode);
        Notification::route('mail', $request->input('email'))
            ->notify(new RegisterEmailVerification($verificationCode, $request->input('first-name')));

        // for testing only preview the notification
        // return (new RegisterEmailVerification("123abc"))
        //     ->toMail(User::find(1));

        return redirect()->route('register.index.student.2');
    }

    public function indexStudent2(Request $request) {
        return view('admin.register_student_2');
    }

    public function storeStudent2(Request $request) {
        $verificationCode = $request->session()->get('verificationCodeStudent');
        // validate the information
        $request->validate([
            'code-1' => [
                'required',
                Rule::in([$verificationCode[0]])
            ],
            'code-2' => [
                'required',
                Rule::in([$verificationCode[1]])
            ],
            'code-3' => [
                'required',
                Rule::in([$verificationCode[2]])
            ],
            'code-4' => [
                'required',
                Rule::in([$verificationCode[3]])
            ]
        ]);

        // users must not go to this page if they did not fill in the basic information in step 1
        if(!$request->session()->has('registerDataStudent')) {
            return redirect()->back();
        }

        $request->session()->put('emailVerifiedStudent', true);

        return redirect()->route('register.index.student.3');
    }

    public function indexStudent3() {
        return view('admin.register_student_3');
    }

    public function storeStudent3(Request $request) {
        $studentData = $request->session()->get('registerDataStudent');

        // session emailVerifiedStudent exists only if the student did all the previous steps
        if(!$request->session()->has('emailVerifiedStudent')) {
            return redirect()->back();
        }

        $request->validate([
            "first-major" => [
                'nullable',
                'exists:majors,major'
            ],
            "second-major" => [
                'nullable',
                'exists:majors,major'
            ],
            "school-year" => [
                'nullable',
                'exists:school_years,school_year'
            ]
        ]);


        echo "<h1>All the information is valid. I will create the user after finishing the google account register method</h1>";
        dd("success");


        // TODO: create the user
        $user = new User();

        // validate the data
        if($request->input('first-major')) {

        }
        if($request->input('second-major')) {

        }
        if($request->input('school-year')) {

        }

        // clear all the session data
        $request->session()->flush();

        // TODO: login the user


        return redirect()->route('home')->with([
            'successMsg' => 'registerSuccess'
        ]);
    }

    // public function show() {
    //     return view('authenticate.show_signup');
    // }

    // public function showStudent(Request $request) {
    //     return view('authenticate.show_signup_student');
    // }

    // public function showStudent_2 (Request $request) {
    //     return view('authenticate.show_signup_student_2', [
    //         'majors' => Major::all()
    //     ]);
    // }

    // public function showTutor() {
    //     return view('authenticate.show_signup_tutor');
    // }

    // public function showTutor_2 () {
    //     return view('authenticate.show_signup_tutor_2', [
    //         'majors' => Major::all()
    //     ]);
    // }



    // public function signupStudent(Request $request) {
    //     // checking for empty inputs, different passwords, wrong email formats, and existed email

    //     $request->validate([
    //         'fullName' => ['
    //             required'
    //         ],
    //         'email' => [
    //             'required',
    //             'email:rfc'
    //         ],
    //         'password' => [
    //             'required',
    //             'min:6',
    //             'alpha_num'
    //         ],
    //         'password-confirm' => [
    //             'required',
    //             'same:password'
    //         ]
    //     ]);

    //     // email can not exist in table for student nor tutor
    //     $request->validate([
    //         'email' => [new NotExistStudent, new NotExistTutor],
    //     ]);



    //     $request->session()->put('email', $request->input('email'));
    //     $request->session()->put('password', $request->input('password'));
    //     $request->session()->put('fullName', $request->input('fullName'));

    //     return redirect()
    //             ->route('signup_2');



    // }

    // public function signupStudent_2(Request $request) {
    //     // TODO: check for profile image
    //     $request->validate([
    //         'schoolYear' => [
    //             'required',
    //             'exists:school_years,school_year'
    //         ],
    //         'major' => [
    //             'required',
    //             'exists:majors,major'
    //         ],
    //         'minor' => [
    //             'nullable'
    //         ],
    //         'profile-pic' => [
    //             'file',
    //             'mimes:jpeg,bmp,png'
    //         ]
    //     ]);

    //     $email = $request->session()->get('email');
    //     $password = $request->session()->get('password');
    //     $fullName = $request->session()->get('fullName');

    //     if(!isset($email) || empty($email) || !isset($password) || empty($password) || !isset($fullName) || empty($fullName)) {
    //         return redirect()->route('signup');
    //     }

    //     $user = new User();
    //     $user->minor = $request->input('minor');
    //     $user->email = $email;
    //     $user->password = Hash::make($password);
    //     $user->full_name = $fullName;
    //     $user->is_tutor = false;

    //     $user->major_id = Major::where('major', '=', $request->input('major'))->first()->id;

    //     $user->school_year_id = School_year::where('school_year', '=', $request->input('schoolYear'))->first()->id;

    //     $this->saveProfilePic($request, $user);


    //     $user->save();

    //     $request->session()->flush();
    //     Auth::login($user);

    //     return redirect()->route('home')->with([
    //         'signupSuccess' => 'signupSuccess'
    //     ]);
    // }


    // private function saveProfilePic(&$request, &$user) {
    //     // if user uploaded the file
    //     if($request->file('profile-pic')) {
    //         $imgURL = $request->file('profile-pic')->store('');
    //         $user->profile_pic_url = $imgURL;
    //     }
    // }




    // public function signupTutor(Request $request) {
    //     // checking for empty inputs, different passwords, wrong email formats, and existed email

    //     $request->validate([
    //         'fullName' => ['
    //             required'
    //         ],
    //         'email' => [
    //             'required',
    //             'email:rfc'
    //         ],
    //         'password' => [
    //             'required',
    //             'min:6',
    //             'alpha_num'
    //         ],
    //         'password-confirm' => [
    //             'required',
    //             'same:password'
    //         ]
    //     ]);

    //     // email can not exist in table for student nor tutor
    //     $request->validate([
    //         'email' => [new NotExistStudent, new NotExistTutor],
    //     ]);



    //     $request->session()->put('email', $request->input('email'));
    //     $request->session()->put('password', $request->input('password'));
    //     $request->session()->put('fullName', $request->input('fullName'));

    //     return redirect()
    //             ->route('signup_tutor_2');
    // }

    // public function signupTutor_2(Request $request) {
    //     // TODO: check for profile image
    //     $request->validate([
    //         'schoolYear' => [
    //             'required',
    //             'exists:school_years,school_year'
    //         ],
    //         'major' => [
    //             'required',
    //             'exists:majors,major'
    //         ],
    //         'minor' => [
    //             'nullable'
    //         ],
    //         'hourlyRate' => [
    //             'required',
    //             'numeric'
    //         ],
    //         'gpa' => [
    //             'nullable',
    //             'numeric'
    //         ],
    //         'profile-pic' => [
    //             'file',
    //             'mimes:jpeg,bmp,png'
    //         ]
    //     ]);

    //     $email = $request->session()->get('email');
    //     $password = $request->session()->get('password');
    //     $fullName = $request->session()->get('fullName');

    //     if(!isset($email) || empty($email) || !isset($password) || empty($password) || !isset($fullName) || empty($fullName)) {
    //         return redirect()->route('signup_tutor');
    //     }

    //     $user = new User();
    //     $user->minor = $request->input('minor');
    //     $user->email = $email;
    //     $user->password = Hash::make($password);
    //     $user->full_name = $fullName;
    //     $user->is_tutor = true;
    //     $user->hourly_rate = substr($request->input('hourlyRate'), 0, 2);
    //     $user->gpa = substr($request->input('gpa'), 0, 4);




    //     $user->major_id = Major::where('major', '=', $request->input('major'))->first()->id;

    //     $user->school_year_id = School_year::where('school_year', '=', $request->input('schoolYear'))->first()->id;

    //     $this->saveProfilePic($request, $user);

    //     $user->save();

    //     $request->session()->flush();
    //     Auth::login($user);

    //     return redirect()->route('home')->with([
    //         'signupSuccess' => 'signupSuccess'
    //     ]);
    // }


}
