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
            // TODO: choose randomly from subjects and courses you user is interested in, and display three for each
            // $courses = $user->courses->toArray();
            // $subjects = $user->subjects->toArray();

            // $courses_subjects = array_merge($courses, $subjects);
            // $numRandom = count($courses_subjects);
            // // if there is > 2 courses_subjects, choose only two
            // if(count($courses_subjects) > 2)
            //     $numRandom = 2;

            // $rand_keys = array_rand($courses_subjects, $numRandom);
            // $recommendations = array();
            // for($i = 0; $i < $numRandom; $i++) {
            //     array_push($recommendations, $courses_subjects[$i]);
            // }
            // foreach($recommendations as $recommendation) {

            // }

            // dd($recommendations);
            
    

            // TODO: get upcoming sessions (at most 2)
            $upcomingSessions = $user->upcomingSessions();
            // dd($upcomingSessions);

            // TODO: get tutors of the past sessions (at most 2)

            // TODO: get data of the dashboard

            return view('home.home_student', [
                // 'recommendations' => $recommendations,
                'upcomingSessions' => $upcomingSessions
            ]);
        }
    }
}
