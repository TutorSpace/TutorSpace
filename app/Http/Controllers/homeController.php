<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Session;


class homeController extends Controller
{
    public function show() {
        $user = Auth::user();


        if($user->is_tutor) {
            return view('home.home_tutor');
        }
        else {
            // TODO: choose randomly from subjects and courses the user is interested in, and display three for each. (If there is no courses/subjects the user interested, show nothing for that specific one)


            // get upcoming sessions (at most 2)
            $upcomingSessions = $user->upcomingSessions(2);


            // get tutors of the past sessions (at most 2)
            $pastTutors = $user->pastTutors(2);


            $user->bookmarked($pastTutors[1]->tutor_id);



            // TODO: get data of the dashboard

            return view('home.home_student', [
                // 'recommendations' => $recommendations,
                'upcomingSessions' => $upcomingSessions,
                'pastTutors' => $pastTutors
            ]);
        }
    }
}
