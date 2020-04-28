<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Session;
use DB;
use App\Tutor_request;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d H:00',
    //     'updated_at' => 'datetime:Y-m-d H:00'
    // ];

    public static function getTime($date, $startTime) {
        $startTime = date("H:i", strtotime($startTime));
        $date = date('Y-m-d', strtotime($date));
        return "$date $startTime";
    }

    public function major() {
        return $this->belongsTo('App\Major');
    }

    public function school_year() {
        return $this->belongsTo('App\School_year');
    }

    public function subjects() {
        return $this->belongsToMany('App\Subject');
    }

    public function courses() {
        return $this->belongsToMany('App\Course');
    }

    public function characteristics() {
        return $this->belongsToMany('App\Characteristic');
    }

    // no need for this function seemingly
    // public function sessions() {
    //     if($this->is_tutor)
    //         return $this->hasMany('App\Session', 'tutor_id');
    //     else
    //         return $this->hasMany('App\Session', 'student_id');
    // }

    public function bookmarks() {
        return $this->belongsToMany('App\User', 'bookmark_user', 'user_id', 'bookmarked_user_id');
    }

    // whenever this function is called, we need to REMOVE the outdated tutor_requests
    public function tutor_requests() {
        $mytime = Carbon::now();

        $tutorRequests = Tutor_request::all();
        foreach($tutorRequests as $tutorRequest) {
            $requestTime = User::getTime($tutorRequest->tutor_session_date, $tutorRequest->start_time);
            if($requestTime <= $mytime) {
                $tutorRequest->delete();
            }
        }

        if($this->is_tutor) {
            return $this->hasMany('App\Tutor_request', 'tutor_id');
        }
        else {
            return $this->hasMany('App\Tutor_request', 'student_id');
        }
    }

    public function available_times() {
        return $this->hasMany('App\Available_time');
    }

    // return users who bookmarked the current user
    public function users() {
        return $this->belongsToMany('App\User', 'bookmark_user', 'bookmarked_user_id', 'user_id');
    }

    // return all the reviews written by the current user
    public function written_reviews() {
        return $this->hasMany('App\Review', 'reviewer_id');
    }

    // return all the reviews about the current user
    public function being_reviews() {
        return $this->hasMany('App\Review', 'reviewee_id');
    }


    // whenever calling this function, we need to turn the ones that are outdated to PAST
    public function upcomingSessions($num) {
        $mytime = Carbon::now();

        $outdatedSessions = Session::where('is_upcoming', 1)
                    ->where('is_canceled', 0)
                    ->get();

        foreach($outdatedSessions as $outdatedSession) {
            $sessionTime = User::getTime($outdatedSession->date, $outdatedSession->start_time);
            if($sessionTime <= $mytime) {
                $outdatedSession->is_upcoming = 0;
                $outdatedSession->save();
            }
        }

        if($this->is_tutor) {
            // the returned information is about the student
            $sessions = Session::select(DB::raw('sessions.id as session_id, is_course, course_id, subject_id, date, start_time, location, end_time, users.*'))
                ->join('users', 'sessions.student_id', '=', 'users.id')
                ->where('tutor_id', $this->id)
                ->where('is_upcoming', 1)
                ->where('is_canceled', 0)
                ->limit($num)
                ->get();

            return $sessions;
        }
        else {
            // the returned information is about the tutor
            $sessions = Session::select(DB::raw('sessions.id as session_id, is_course, course_id, subject_id, date, start_time, location, end_time, users.*'))
            ->join('users', 'sessions.tutor_id', '=', 'users.id')
            ->where('student_id', $this->id)
            ->where('is_upcoming', 1)
            ->where('is_canceled', 0)
            ->limit($num)
            ->get();

            return $sessions;
        }
    }

    public function pastSessions() {
        if($this->is_tutor) {
            // the returned information is about the student
            $sessions = Session::select(DB::raw('sessions.id as session_id, is_course, course_id, subject_id, date, start_time, location, end_time, users.*'))
                ->join('users', 'sessions.student_id', '=', 'users.id')
                ->where('tutor_id', $this->id)
                ->where('is_upcoming', 0)
                ->where('is_canceled', 0)
                ->get();

            return $sessions;
        }
        else {
            // the returned information is about the tutor
            $sessions = Session::select(DB::raw('sessions.id as session_id, is_course, course_id, subject_id, date, start_time, location, end_time, users.*'))
                ->join('users', 'sessions.tutor_id', '=', 'users.id')
                ->where('student_id', $this->id)
                ->where('is_upcoming', 0)
                ->where('is_canceled', 0)
                ->get();

            return $sessions;
        }
    }

    public function pastTutors($num) {
        $pastTutors = Session::select('*', DB::raw('count(*) as count, max(date) as date'))
                ->join('users', 'sessions.tutor_id', '=', 'users.id')
                ->where('student_id', $this->id)
                ->where('is_upcoming', 0)
                ->where('is_canceled', 0)
                ->groupBy('sessions.tutor_id')
                ->limit($num)
                ->orderBy('date', 'DESC')
                ->get();

        return $pastTutors;
    }

    // check whether the user with $user_id is bookmarked by the current user
    public function bookmarked($userId) {
        return $this->bookmarks()->where('id', '=', $userId)->count() > 0;
    }

    // check whether the subject with $subject_id is already faved by the current user
    public function favedSubject($subject_id) {
        return $this->subjects()->where('id', '=', $subject_id)->count() > 0;
    }

    // check whether the course with $course_id is already faved by the current user
    public function favedCourse($course_id) {
        return $this->courses()->where('id', '=', $course_id)->count() > 0;
    }

    // check whether the characteristic with $characteristic_id is already faved by the current user
    public function favedCharacteristic($characteristic_id) {
        return $this->characteristics()->where('id', '=', $characteristic_id)->count() > 0;
    }

    // get the rating of the user as the reviewee
    public function getRating() {
        $avg = User::join('reviews', 'reviewee_id', '=', 'users.id')
                    ->where('users.id', '=', $this->id)
                    ->avg('star_rating');

        return $avg ? number_format((float)$avg, 1, '.', '') : NULL;
    }

    // get the rating of the user as the reviewer
    public function getRatingAsReviewer() {
        $avg = User::join('reviews', 'reviewer_id', '=', 'users.id')
                    ->where('users.id', '=', $this->id)
                    ->avg('star_rating');

        return $avg ? number_format((float)$avg, 1, '.', '') : NULL;
    }



}
