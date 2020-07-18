<?php

namespace App\Http\Controllers;

use DB;

use Auth;
use App\User;
use App\Course;
use App\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Facades\App\CustomClass\TimeFormatter;


class SearchController extends Controller
{

    public function index(Request $request) {
        $validator = Validator::make($request->all(), [
            // validate time
            'available-start-date' => [
                'nullable',
                'required_with:available-end-date',
                'required_with:available-time-range',
                'date_format:Y-m-d',
                'after_or_equal:today'
            ],
            'available-end-date' => [
                'nullable',
                'required_with:available-start-date',
                'required_with:available-time-range',
                'date_format:Y-m-d',
                'after_or_equal:today',
                'after_or_equal:available-start-date'
            ],
            'available-time-range' => [
                'nullable',
                'array',
                'required_with:available-start-date,available-end-date'
            ],
            'available-time-range.*' => [
                Rule::in(['morning', 'afternoon', 'evening', 'anytime', 'specify-time'])
            ],
            'available-start-time' => [
                function ($attribute, $value, $fail) use($request) {
                    if ($request->input('available-time-range') && in_array('specify-time', $request->input('available-time-range'))) {
                        if(!$value || Carbon::createFromFormat('g:ia', $value) === false) {
                            $fail('Start Time is required if the specify-time option is checked.');
                        }
                    }
                }
            ],
            'available-end-time' => [
                function ($attribute, $value, $fail) use($request) {
                    if ($request->input('available-time-range') && in_array('specify-time', $request->input('available-time-range'))) {
                        if(!$value || Carbon::createFromFormat('g:ia', $value) === false ) {
                            $fail('End Time is required if the specify-time option is checked');
                        }
                        else if(Carbon::createFromFormat('g:ia', $value)->lte(Carbon::createFromFormat('g:ia', $request->input('available-start-time')))) {
                            $fail('End Time must be after the Start Time');
                        }
                    }
                }
            ],

            // validate price
            'price-low' => [
                'nullable',
                'numeric',
                'required_with:price-high'
            ],
            'price-high' => [
                'nullable',
                'numeric',
                'required_with:price-low',
                'gte:price-low'
            ],

            // validate tutor level
            'tutor-level' => [
                'nullable',
                'array'
            ],
            'tutor-level.*' => [
                'exists:tutor_levels,id'
            ]
        ]);

        $request->session()->flashInput($request->all());


        if ($validator->fails()) {
            $request->session()->flash('filterErrors', $validator->errors());

            return view('search.index');
        }

        $usersQuery = User::with([
                        'firstMajor',
                        'tutorLevel',
                        'courses',
                        'about_reviews',
                        'available_times'
                    ])
                    ->withCount([
                        'about_reviews'
                    ])
                    ->where('users.is_tutor', true)
                    ->join('course_user', 'course_user.user_id', '=', 'users.id')
                    ->join('courses', 'courses.id', 'course_user.course_id')
                    ->where(function ($query) use($request) {
                        $numbers = preg_replace('/[^0-9]/', '', $request->input('nav-search-content'));
                        $letters = preg_replace('/[^a-zA-Z]/', '', $request->input('nav-search-content'));
                        $courseNumber = $letters . " " . $numbers;
                        $query
                            ->where('users.first_name', 'like', "%{$request->input('nav-search-content')}%")
                            ->orWhere('users.last_name', 'like', "%{$request->input('nav-search-content')}%")
                            ->orWhere('courses.course', 'like', "%{$courseNumber}%");
                    });


        // if the user filtered with price
        if($request->input('price-low') && $request->input('price-high')) {
            $usersQuery = $usersQuery
                            ->whereBetween('users.hourly_rate', [
                                min($request->input('price-low'), $request->input('price-high')),
                                max($request->input('price-low'), $request->input('price-high'))
                            ]);
        }


        // TODO: if the user filtered with tutor level




        // TODO: if the user does not search for any available time, do not consider time
        if($request->input('available-start-date') && $request->input('available-end-date')) {
            if(!in_array('specify-time', $request->input('available-time-range'))) {
                $availableTimeRange = $request->input('available-time-range');
                if($availableTimeRange == 'anytime' || count($availableTimeRange) == 3) {
                    $startTimes = ["6:00:00"];
                    $endTimes = ["23:00:00"];
                }
                else if(count($availableTimeRange) == 1) {
                    if(in_array('morning', $availableTimeRange)) {
                        $startTimes = ["6:00:00"];
                        $endTimes = ["11:59:59"];
                    }
                    else if(in_array('afternoon', $availableTimeRange)) {
                        $startTimes = ["12:00:00"];
                        $endTimes = ["16:59:59"];
                    }
                    else if(in_array('evening', $availableTimeRange)) {
                        $startTimes = ["17:00:00"];
                        $endTimes = ["23:00:00"];
                    }
                }
                else if(count($availableTimeRange) == 2) {
                    if(in_array('morning', $availableTimeRange) && in_array('afternoon', $availableTimeRange)) {
                        $startTimes = ["6:00:00"];
                        $endTimes = ["16:59:59"];
                    }
                    else if(in_array('morning', $availableTimeRange) && in_array('evening', $availableTimeRange)) {
                        $startTimes = ["6:00:00", "17:00:00"];
                        $endTimes = ["11:59:59", "23:00:00"];
                    }
                    else if(in_array('afternoon', $availableTimeRange) && in_array('evening', $availableTimeRange)) {
                        $startTimes = ["12:00:00"];
                        $endTimes = ["23:00:00"];
                    }
                }
            }
            // if the user specified detailed time in the filter
            else {
                $startTimes = [date("h:i:s", strtotime($request->input('available-start-time')))];


                $endTimes = [date("h:i:s", strtotime($request->input('available-end-time')))];
            }


            $numDays = Carbon::parse($request->input('available-end-date') . " " . $startTimes[0])->diffInDays(Carbon::parse($request->input('available-start-date') . " " . $startTimes[0]));
            $times = collect([]);
            for($i = 0; $i <= $numDays; $i++) {
                for($j = 0; $j < count($startTimes); $j++) {
                    $times->push([
                        Carbon::parse($request->input('available-start-date') . " " . $startTimes[$j])->addDays($i),
                        Carbon::parse($request->input('available-start-date') . " " . $endTimes[$j])->addDays($i)
                    ]);
                }
            }


            $users = $usersQuery->distinct()->get();
            $results = collect([]);
            foreach($users as $user) {

                $availableTimes = $user->available_times;
                for($i = 0; $i < count($times); $i++) {
                    $startTime = $times[$i][0];
                    $endTime = $times[$i][1];

                    $keep = false;
                    // iterate through all the available time of the user
                    foreach($availableTimes as $availableTime) {
                        $availableTimeStart = $availableTime->available_time_start;
                        $availableTimeEnd = $availableTime->available_time_end;


                        // if intersects, then possible to return it
                        if(($startTime >= $availableTimeStart && $endTime <= $availableTimeEnd)) {
                            // we still need to check whether this user has time conflict with any already scheduled sessions
                            $upcomingSessions = $user->upcomingSessions;
                            $conflict = false;
                            foreach($upcomingSessions as $upcomingSession) {
                                $upcomingSessionStartTime = TimeFormatter::getTime($upcomingSession->date, $upcomingSession->start_time);
                                $upcomingSessionEndTime = TimeFormatter::getTime($upcomingSession->date, $upcomingSession->end_time);

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
                    if($keep) {
                        $results->push($user);
                        break;
                    }
                }
            };

            return view('search.index', [
                'users' => $results
            ]);
        }


        return view('search.index', [
            'users' => $usersQuery->distinct()->get()
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
