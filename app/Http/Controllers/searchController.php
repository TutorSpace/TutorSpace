<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Course;
use App\Subject;
use DB;

class searchController extends Controller
{
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
                                ->get();

            $results = $nameUserResults->merge($courseUserResults)->merge($subjectUserResults);
        }
        // if the user searches by going to the searching page
        else if($request->has('searchInput')){
            $searchInput = trim($request->input('searchInput'));

            if($user->is_tutor) {
                $yearInputs = $request->input('year');
                if(!$yearInputs)
                    $yearInputs = array();

                $ratingRangeLow = $request->input('rating-range-low');
                $ratingRangeHigh = $request->input('rating-range-high');

                // make suer low is really lower than high for rating
                if($ratingRangeHigh < $ratingRangeLow) {
                    $temp = $ratingRangeHigh;
                    $ratingRangeHigh = $ratingRangeLow;
                    $ratingRangeLow = $temp;
                }


                // get students/tutors that match the navInput in name, course, and subjects
                // 1. name
                // not left join, so if users don't have reviews yet, I will not display them in the search results
                $nameUserResults = User::select("users.*", DB::raw("AVG(reviews.star_rating)"))
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('users.full_name', 'like', "%{$searchInput}%")
                                ->where('users.is_tutor', '=', !$user->is_tutor)
                                ->groupby('users.id')
                                ->get();


                // 2. course
                // get all the courses with matched input
                $course_ids = Course::where('course', 'like', "%{$searchInput}%")->pluck('id');

                // get all the users who are interested in those courses
                $courseUserResults = Course::select('users.*', DB::raw("AVG(reviews.star_rating)"))
                                ->join('course_user', 'course_user.course_id', '=', 'courses.id')
                                ->join('users', 'users.id', '=', 'course_user.user_id')
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('courses.id', $course_ids)
                                ->groupby('users.id')
                                ->get();

                // 3. subject
                // get all the subjects with matched input
                $subject_ids = Subject::where('subject', 'like', "%{$searchInput}%")->pluck('id');

                // get all the users who are interested in those subjects
                $subjectUserResults = Subject::select('users.*', DB::raw("AVG(reviews.star_rating)"))
                                ->join('subject_user', 'subject_user.subject_id', '=', 'subjects.id')
                                ->join('users', 'users.id', '=', 'subject_user.user_id')
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('subjects.id', $subject_ids)
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
                $ratingRangeLow = $request->input('rating-range-low');
                $ratingRangeHigh = $request->input('rating-range-high');

                // // make suer low is really lower than high for price
                if($priceRangeHigh < $priceRangeLow) {
                    $temp = $priceRangeHigh;
                    $priceRangeHigh = $priceRangeLow;
                    $priceRangeLow = $temp;
                }
                // // make suer low is really lower than high for rating
                if($ratingRangeHigh < $ratingRangeLow) {
                    $temp = $ratingRangeHigh;
                    $ratingRangeHigh = $ratingRangeLow;
                    $ratingRangeLow = $temp;
                }


                // get students/tutors that match the navInput in name, course, and subjects
                // 1. name
                // not left join, so if users don't have reviews yet, I will not display them in the search results
                $nameUserResults = User::select("users.*", DB::raw("AVG(reviews.star_rating)"))
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('users.full_name', 'like', "%{$searchInput}%")
                                ->where('users.is_tutor', '=', !$user->is_tutor)
                                ->whereBetween('users.hourly_rate', [$priceRangeLow, $priceRangeHigh])
                                ->groupby('users.id')
                                ->get();


                // 2. course
                // get all the courses with matched input
                $course_ids = Course::where('course', 'like', "%{$searchInput}%")->pluck('id');

                // get all the users who are interested in those courses
                $courseUserResults = Course::select('users.*', DB::raw("AVG(reviews.star_rating)"))
                                ->join('course_user', 'course_user.course_id', '=', 'courses.id')
                                ->join('users', 'users.id', '=', 'course_user.user_id')
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('courses.id', $course_ids)
                                ->whereBetween('users.hourly_rate', [$priceRangeLow, $priceRangeHigh])
                                ->groupby('users.id')
                                ->get();


                // 3. subject
                // get all the subjects with matched input
                $subject_ids = Subject::where('subject', 'like', "%{$searchInput}%")->pluck('id');

                // get all the users who are interested in those subjects
                $subjectUserResults = Subject::select('users.*', DB::raw("AVG(reviews.star_rating)"))
                                ->join('subject_user', 'subject_user.subject_id', '=', 'subjects.id')
                                ->join('users', 'users.id', '=', 'subject_user.user_id')
                                ->join('school_years', 'school_years.id', '=', 'users.school_year_id')
                                ->join('reviews', 'users.id', '=', 'reviews.reviewee_id')
                                ->whereIn('school_years.school_year', $yearInputs)
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('subjects.id', $subject_ids)
                                ->whereBetween('users.hourly_rate', [$priceRangeLow, $priceRangeHigh])
                                ->groupby('users.id')
                                ->get();


                $results = $nameUserResults->merge($courseUserResults)->merge($subjectUserResults);

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
