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
    private static $RESULTS_PER_PAGE = 5;

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
                        'availableTimes'
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


        // if the user filtered with tutor level
        if($request->input('tutor-level')) {
            $tutorLevels = $request->input('tutor-level');
            $usersQuery = $usersQuery
                            ->join('tutor_levels', 'tutor_levels.id', '=', 'users.tutor_level_id');

            $usersQuery = $usersQuery->where(function($query) use ($tutorLevels) {
                for($i = 0; $i < count($tutorLevels); $i++) {
                    if($i == 0) {
                        $query->where('tutor_levels.id', $tutorLevels[$i]);
                    }
                    else {
                        $query->orWhere('tutor_levels.id', $tutorLevels[$i]);
                    }
                }
            });
        }



        // if the user does not search for any available time, do not consider time
        if($request->input('available-start-date') && $request->input('available-end-date')) {
            if(!in_array('specify-time', $request->input('available-time-range'))) {
                $availableTimeRange = $request->input('available-time-range');
                if(in_array('anytime', $availableTimeRange) || count($availableTimeRange) == 3) {
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
                $startTimes = [date("H:i:s", strtotime($request->input('available-start-time')))];

                $endTimes = [date("H:i:s", strtotime($request->input('available-end-time')))];
            }


            $numDays = Carbon::parse($request->input('available-end-date') . " " . $startTimes[0])->diffInDays(Carbon::parse($request->input('available-start-date') . " " . $startTimes[0]));
            $times = collect([]);
            for($i = 0; $i <= $numDays; $i++) {
                for($j = 0; $j < count($startTimes); $j++) {
                    $times->push([
                        Carbon::parse($request->input('available-start-date') . " " . $startTimes[$j])->addDays($i)->format('Y-m-d H:i:s'),
                        Carbon::parse($request->input('available-start-date') . " " . $endTimes[$j])->addDays($i)->format('Y-m-d H:i:s')
                    ]);
                }
            }

            $users = $usersQuery->distinct()->get();
            $results = collect([]);

            // TODO: check algorithm correctness
            foreach($users as $user) {

                $availableTimes = $user->availableTimes;

                for($i = 0; $i < count($times); $i++) {
                    $startTime = $times[$i][0];
                    $endTime = $times[$i][1];

                    $keep = false;
                    // iterate through all the available time of the user
                    foreach($availableTimes as $availableTime) {
                        $availableTimeStart = $availableTime->available_time_start;
                        $availableTimeEnd = $availableTime->available_time_end;

                        // if intersects, then possible to return it
                        if((
                            $startTime >= $availableTimeStart && $startTime <= $availableTimeEnd) ||
                            ($endTime >= $availableTimeStart && $endTime <= $availableTimeEnd) ||
                            ($startTime <= $availableTimeStart && $endTime >=$availableTimeEnd)
                        ) {
                            $keep = true;
                            break;
                        }
                    }
                    if($keep) {
                        $results->push($user);
                        break;
                    }
                }
            };

            return view('search.index', [
                'users' => $results->paginate(self::$RESULTS_PER_PAGE)
            ]);
        }


        return view('search.index', [
            'users' => $usersQuery->distinct()->get()->paginate(self::$RESULTS_PER_PAGE)
        ]);
    }
}
