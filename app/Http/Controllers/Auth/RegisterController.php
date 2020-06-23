<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Hash;

use App\User;
use App\Major;
use App\School_year;
use App\Rules\EmailUSC;
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
        $verificationCode = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);

        if($request->session()->has('registerDataStudent')) {
            $email = $request->session()->get('registerDataStudent')['email'];
            $firstName = $request->session()->get('registerDataStudent')['first-name'];
            $request->session()->put('verificationCodeStudent', $verificationCode);
            Notification::route('mail', $email)
            ->notify(new RegisterEmailVerification($verificationCode, $firstName));
        }
        else if($request->session()->has('registerDataTutor')) {
            $email = $request->session()->get('registerDataTutor')['email'];
            $firstName = $request->session()->get('registerDataTutor')['first-name'];
            $request->session()->put('verificationCodeTutor', $verificationCode);
            Notification::route('mail', $email)
            ->notify(new RegisterEmailVerification($verificationCode, $firstName));
        }

        return response()->json(
            [
                'successMsg' => 'Successfully sent the email!'
            ]
        );
    }

    // first page of student register
    public function indexStudent1(Request $request) {
        return view('auth.register_student_1');
    }

    // first page of tutor register
    public function indexTutor1(Request $request) {
        return view('auth.register_tutor_1');
    }

    // register student using password (not Google)
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

        // email must not be registered as a student before and must be a USC email
        $request->validate([
            'email' => [new NotExistStudent, new EmailUSC]
        ]);

        // if the user is registered as a tutor before, he should be redirected to the specific page that is specifically designed for him
        if(User::where('email', '=', $request->input('email'))->where('is_tutor', true)->count() != 0) {
            echo "<h1>if the user is registered as a tutor before, he should be redirected to the specific page that is specifically designed for him</h1>";
            dd("if the user is registered as a tutor before, he should be redirected to the specific page that is specifically designed for him");
        }

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

    // register tutor using password (not Google)
    public function storeTutor1(Request $request) {
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

        // email must not be registered as a tutor before and must be a USC email
        $request->validate([
            'email' => [new NotExistTutor, new EmailUSC]
        ]);

        // if the user is registered as a student before, he should be redirected to the specific page that is specifically designed for him
        if(User::where('email', '=', $request->input('email'))->where('is_tutor', false)->count() != 0) {
            echo "<h1>if the user is registered as a student before, he should be redirected to the specific page that is specifically designed for him</h1>";
            dd("if the user is registered as a student before, he should be redirected to the specific page that is specifically designed for him");
        }

        // clear all the session data for safety concerns (no one can play around with the email verification process)
        $request->session()->flush();

        // validate the information and stores in the session
        $request->session()->put('registerDataTutor', $request->all());


        // email verification
        $verificationCode = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        $request->session()->put('verificationCodeTutor', $verificationCode);
        Notification::route('mail', $request->input('email'))
            ->notify(new RegisterEmailVerification($verificationCode, $request->input('first-name')));

        // for testing only preview the notification
        // return (new RegisterEmailVerification("123abc"))
        //     ->toMail(User::find(1));

        return redirect()->route('register.index.tutor.2');
    }

    public function indexStudent2(Request $request) {
        return view('auth.register_student_2');
    }

    public function indexTutor2(Request $request) {
        return view('auth.register_tutor_2');
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

        // users would not be able to not submit their information in the step if they did not fill in the basic information in step 1
        if(!$request->session()->has('registerDataStudent')) {
            return redirect()->back();
        }

        $request->session()->put('emailVerifiedStudent', true);

        return redirect()->route('register.index.student.3');
    }

    public function storeTutor2(Request $request) {
        $verificationCode = $request->session()->get('verificationCodeTutor');
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

        // users would not be able to not submit their information in the step if they did not fill in the basic information in step 1
        if(!$request->session()->has('registerDataTutor')) {
            return redirect()->back();
        }

        $request->session()->put('emailVerifiedTutor', true);

        return redirect()->route('register.index.tutor.3');
    }

    public function indexStudent3() {
        return view('auth.register_student_3');
    }

    public function indexTutor3() {
        // dd(request()->session());
        return view('auth.register_tutor_3');
    }



    public function storeStudent3(Request $request) {
        $studentData = $request->session()->get('registerDataStudent');

        // session emailVerifiedStudent exists only if the student did all the previous steps, including with Google
        if(!$request->session()->has('emailVerifiedStudent')) {
            return redirect()->back()->with([
                'errorMsg' => 'Something went wrong with your registration process either because your information is not yet verified or you already created the account.'
            ]);
        }

        $request->validate([
            "first-major" => [
                'nullable',
                'exists:majors,id',
                'required_with:second-major'
            ],
            "second-major" => [
                'nullable',
                'exists:majors,id'
            ],
            "school-year" => [
                'nullable',
                'exists:school_years,id'
            ]
        ]);


        echo "<h1>All the information is valid. I will create the user after finishing the google account register method</h1>";

        // create the user
        $user = new User();

        // stores the data
        if($request->input('first-major')) {
            $user->firstMajor()->associate(Major::find($request->input('first-major')));
        }
        if($request->input('second-major')) {
            $user->secondMajor()->associate(Major::find($request->input('second-major')));
        }
        if($request->input('school-year')) {
            $user->school_year()->associate(School_year::find($request->input('school-year')));
        }

        if(isset($studentData['google-id'])) {
            $user->google_id = $studentData['google-id'];
        }
        else {
            $user->password = Hash::make($studentData['password']);
        }

        $user->first_name = $studentData['first-name'];
        $user->last_name = $studentData['last-name'];
        $user->is_tutor = false;

        // todo: comment back and set email in db to not null
        $user->email = $studentData['email'];
        $user->save();

        // clear all the session data
        $request->session()->flush();

        // login the user
        Auth::login($user);

        return redirect()->route('home')->with([
            'registerSuccess' => true
        ]);
    }

    public function storeTutor3(Request $request) {
        $tutorData = $request->session()->get('registerDataTutor');

        // session emailVerifiedTutor exists only if the tutor did all the previous steps, including with Google
        if(!$request->session()->has('emailVerifiedTutor')) {
            return redirect()->back()->with([
                'errorMsg' => 'Something went wrong with your registration process. Please make sure you completed all the registration steps.'
            ]);
        }

        $request->validate([
            "first-major" => [
                'required',
                'exists:majors,id',
                'required_with:second-major'
            ],
            "second-major" => [
                'nullable',
                'exists:majors,id',

            ],
            "school-year" => [
                'required',
                'exists:school_years,id'
            ],
            "gpa" => [
                'required',
                'numeric',
                'min:1',
                'max:4'
            ]
        ]);

        $request->session()->put('registerDataTutor', array_merge($tutorData, $request->all()));

        return redirect()->route('register.index.tutor.4');
    }

    public function indexTutor4() {
        return view('auth.register_tutor_4');
    }

    public function storeTutor4(Request $request) {
        $tutorData = $request->session()->get('registerDataTutor');

        // session emailVerifiedTutor exists only if the tutor did all the previous steps, including with Google
        if(!$request->session()->has('emailVerifiedTutor')) {
            return redirect()->back()->with([
                'errorMsg' => 'Something went wrong with your registration process. Please make sure you completed all the registration steps.'
            ]);
        }

        $request->validate([
            'hourly-rate' => [
                'required',
                'numeric',
                'min:10',
                'max:50'
            ],
            'courses' => [
                'required',
                'array',
                'min:1'
            ],
            'courses.*' => [
                'exists:courses,id'
            ]
        ]);

        $request->session()->put('registerDataTutor', array_merge($tutorData, $request->all()));

        return redirect()->route('register.index.tutor.5');
    }

    public function indexTutor5() {
        return view('auth.register_tutor_5');
    }

    public function storeTutor5(Request $request) {
        $tutorData = $request->session()->get('registerDataTutor');

        // session emailVerifiedTutor exists only if the tutor did all the previous steps, including with Google
        if(!$request->session()->has('emailVerifiedTutor')) {
            return redirect()->back()->with([
                'errorMsg' => 'Something went wrong with your registration process. Please make sure you completed all the registration steps.'
            ]);
        }

        $request->validate([
            'profile-pic' => [
                'file',
                'mimes:jpeg,bmp,png'
            ]
        ]);

        echo "<h1>All the information is valid. I will create the user after finishing the google account register method</h1>";



        // create the user
        $user = new User();

        // stores the data
        $user->firstMajor()->associate(Major::find($tutorData['first-major']));

        if(isset($tutorData['second-major'])) {
            $user->secondMajor()->associate(Major::find($tutorData['second-major']));
        }
        $user->school_year()->associate(School_year::find($tutorData['school-year']));

        if(isset($tutorData['google-id'])) {
            $user->google_id = $tutorData['google-id'];
        }
        else {
            $user->password = Hash::make($tutorData['password']);
        }

        $user->first_name = $tutorData['first-name'];
        $user->last_name = $tutorData['last-name'];
        $user->is_tutor = true;
        $user->email = $tutorData['email'];
        $user->gpa = $tutorData['gpa'];
        $user->hourly_rate = $tutorData['hourly-rate'];

        // if user uploaded the file
        if($request->file('profile-pic')) {
            $user->deleteImage();
            $imgURL = $request->file('profile-pic')->store('');
            $user->profile_pic_url = $imgURL;
        }

        $user->save();

        $user->courses()->attach($tutorData['courses']);

        // clear all the session data
        $request->session()->flush();

        // login the user
        Auth::login($user);

        return redirect()->route('home')->with([
            'registerSuccess' => true
        ]);
    }

}
