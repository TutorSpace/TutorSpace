<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Course;
use App\Subject;
use DB;

class SearchController extends Controller
{
    public function index(Request $request) {
        // todo: load all the results
        $request->validate([
            'available-start-date' => [
                // 'nullable',
                'date'
            ],
            'available-end-date' => [
                // 'nullable',
                'date'
            ]
        ]);

        // dd($request->all());


        return view('search.index', [

        ]);
    }


    public function show(Request $request) {
        $user = Auth::user();
        $nameUserResults;
        $courseUserResults;
        $subjectUserResults;
        $results;

        // if the user searches using the nav bar
        if($request->has('navInput')) {
            $searchInput = trim($request->input('navInput'));

            // get students/tutors that match the navInput in name, course, and subjects
            // 1. name
            $nameUserResults = User::where('full_name', 'like', "%{$searchInput}%")
                            ->where('is_tutor', '=', !$user->is_tutor)
                            ->where('users.id', '!=', $user->id)
                            ->get();

            // 2. course
            // get all the courses with matched input
            $course_ids = Course::where('course', 'like', "%{$searchInput}%")->pluck('id');

            // get all the users who are interested in those courses
            $courseUserResults = Course::select('users.*')
                                ->join('course_user', 'course_user.course_id', '=', 'courses.id')
                                ->join('users', 'users.id', '=', 'course_user.user_id')
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('courses.id', $course_ids)
                                ->where('users.id', '!=', $user->id)
                                ->get();

            // 3. subject
            // get all the subjects with matched input
            $subject_ids = Subject::where('subject', 'like', "%{$searchInput}%")->pluck('id');

            // get all the users who are interested in those subjects
            $subjectUserResults = Subject::select('users.*')
                                ->join('subject_user', 'subject_user.subject_id', '=', 'subjects.id')
                                ->join('users', 'users.id', '=', 'subject_user.user_id')
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('subjects.id', $subject_ids)
                                ->where('users.id', '!=', $user->id)
                                ->get();

            $results = $nameUserResults->merge($courseUserResults)->merge($subjectUserResults);
        }
        // if the user searches by going to the searching page
        else if($request->has('searchInput')){
            $searchInput = trim($request->input('searchInput'));

            $ratingRangeLow = $request->input('rating-range-low');
            $ratingRangeHigh = $request->input('rating-range-high');

            // make suer low is really lower than high for rating
            if($ratingRangeHigh < $ratingRangeLow) {
                $temp = $ratingRangeHigh;
                $ratingRangeHigh = $ratingRangeLow;
                $ratingRangeLow = $temp;
            }

            if($user->is_tutor) {
                $yearInputs = $request->input('year');
                if(!$yearInputs)
                    $yearInputs = array();

                // get students/tutors that match the navInput in name, course, and subjects
                // 1. name
                // not left join, so if users don't have reviews yet, I will not display them in the search results
                $nameUserResults = User::select("users.*", DB::raw("AVG(reviews.star_rating) as rating"))
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('users.full_name', 'like', "%{$searchInput}%")
                                ->where('users.is_tutor', '=', !$user->is_tutor)
                                ->where('users.id', '!=', $user->id)
                                ->groupby('users.id')
                                ->get();


                // 2. course
                // get all the courses with matched input
                $course_ids = Course::where('course', 'like', "%{$searchInput}%")->pluck('id');

                // get all the users who are interested in those courses
                $courseUserResults = Course::select('users.*', DB::raw("AVG(reviews.star_rating) as rating"))
                                ->join('course_user', 'course_user.course_id', '=', 'courses.id')
                                ->join('users', 'users.id', '=', 'course_user.user_id')
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('courses.id', $course_ids)
                                ->where('users.id', '!=', $user->id)
                                ->groupby('users.id')
                                ->get();

                // 3. subject
                // get all the subjects with matched input
                $subject_ids = Subject::where('subject', 'like', "%{$searchInput}%")->pluck('id');

                // get all the users who are interested in those subjects
                $subjectUserResults = Subject::select('users.*', DB::raw("AVG(reviews.star_rating) as rating"))
                                ->join('subject_user', 'subject_user.subject_id', '=', 'subjects.id')
                                ->join('users', 'users.id', '=', 'subject_user.user_id')
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('subjects.id', $subject_ids)
                                ->where('users.id', '!=', $user->id)
                                ->groupby('users.id')
                                ->get();

                $results = $nameUserResults->merge($courseUserResults)->merge($subjectUserResults);
            }
            else {

                $yearInputs = $request->input('year');
                if(!$yearInputs)
                    $yearInputs = array();

                $priceRangeLow = $request->input('price-range-low');
                $priceRangeHigh = $request->input('price-range-high');


                // make suer low is really lower than high for price
                if($priceRangeHigh < $priceRangeLow) {
                    $temp = $priceRangeHigh;
                    $priceRangeHigh = $priceRangeLow;
                    $priceRangeLow = $temp;
                }


                // get students/tutors that match the navInput in name, course, and subjects
                // 1. name
                // not left join, so if users don't have reviews yet, I will not display them in the search results
                $nameUserResults = User::select("users.*", DB::raw("AVG(reviews.star_rating) as rating"))
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('users.full_name', 'like', "%{$searchInput}%")
                                ->where('users.is_tutor', '=', !$user->is_tutor)
                                ->whereBetween('users.hourly_rate', [$priceRangeLow, $priceRangeHigh])
                                ->where('users.id', '!=', $user->id)
                                ->groupby('users.id')
                                ->get();


                // 2. course
                // get all the courses with matched input
                $course_ids = Course::where('course', 'like', "%{$searchInput}%")->pluck('id');

                // get all the users who are interested in those courses
                $courseUserResults = Course::select('users.*', DB::raw("AVG(reviews.star_rating) as rating"))
                                ->join('course_user', 'course_user.course_id', '=', 'courses.id')
                                ->join('users', 'users.id', '=', 'course_user.user_id')
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('courses.id', $course_ids)
                                ->whereBetween('users.hourly_rate', [$priceRangeLow, $priceRangeHigh])
                                ->where('users.id', '!=', $user->id)
                                ->groupby('users.id')
                                ->get();


                // 3. subject
                // get all the subjects with matched input
                $subject_ids = Subject::where('subject', 'like', "%{$searchInput}%")->pluck('id');

                // get all the users who are interested in those subjects
                $subjectUserResults = Subject::select('users.*', DB::raw("AVG(reviews.star_rating) as rating"))
                                ->join('subject_user', 'subject_user.subject_id', '=', 'subjects.id')
                                ->join('users', 'users.id', '=', 'subject_user.user_id')
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('subjects.id', $subject_ids)
                                ->whereBetween('users.hourly_rate', [$priceRangeLow, $priceRangeHigh])
                                ->where('users.id', '!=', $user->id)
                                ->groupby('users.id')
                                ->get();


                $results = $nameUserResults->merge($courseUserResults)->merge($subjectUserResults);


                // select tutors of the available time
                $startTime = $request->input('startTime');
                $endTime = $request->input('endTime');

                // if the user does not search for any available time, do not consider time
                if($startTime && $endTime) {
                    $startTime = date('Y-m-d h:i:s', strtotime($startTime));
                    $endTime = date('Y-m-d h:i:s', strtotime($endTime));

                    foreach($results as $key => $item) {
                        $result = $results[$key];
                        $availableTimes = User::find($result->id)->available_times;

                        $keep = false;
                        // iterate through all the available time of the user
                        foreach($availableTimes as $availableTime) {
                            $availableTimeStart = $availableTime->available_time_start;
                            $availableTimeEnd = $availableTime->available_time_end;

                            // if intersects, then possible to return it
                            if(($startTime >= $availableTimeStart && $startTime <= $availableTimeEnd) || ($endTime >= $availableTimeStart && $endTime <= $availableTimeEnd)) {
                                // check whether this user has time conflict with any scheduled sessions
                                // Must not accept the tutor request if it conflicts with a scheduled session
                                $upcomingSessions = User::find($result->id)->upcomingSessions(1000);
                                $conflict = false;
                                foreach($upcomingSessions as $upcomingSession) {
                                    $upcomingSessionStartTime = User::getTime($upcomingSession->date, $upcomingSession->start_time);
                                    $upcomingSessionEndTime = User::getTime($upcomingSession->date, $upcomingSession->end_time);

                                    // if conflicts
                                    if(($startTime >= $upcomingSessionStartTime && $startTime <= $upcomingSessionEndTime) || ($endTime >= $upcomingSessionStartTime && $endTime <= $upcomingSessionEndTime)) {
                                        $conflict = true;
                                        break;
                                    }
                                }

                                if(!$conflict) {
                                    $keep = true;
                                    break;
                                }
                            }
                        }
                        if(!$keep) {
                            $results->forget($key);
                        }
                    };
                }
            }

            // select users with the correct rating
            foreach($results as $key => $item) {
                $result = $results[$key];
                if($result->rating < $ratingRangeLow || $result->rating > $ratingRangeHigh)  {
                    $results->forget($key);
                }
            }
        }
        else {
            return redirect()->route('home');
        }


        // merge will automatically get rid of the same elements


        if($user->is_tutor) {
            return view('search.search_for_student', [
                'user' => $user,
                'results' => $results
            ]);
        }
        else {
            return view('search.search_for_tutor', [
                'user' => $user,
                'results' => $results
            ]);
        }
    }
}
