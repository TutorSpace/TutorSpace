<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Session;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
        'updated_at' => 'datetime:Y-m-d H:00'
    ];

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

    public function sessions() {
        if($this->is_tutor)
            return $this->hasMany('App\Session', 'tutor_id');
        else
            return $this->hasMany('App\Session', 'student_id');
    }

    public function bookmarks() {
        return $this->belongsToMany('App\User', 'bookmark_user', 'user_id', 'bookmarked_user_id');
    }

    public function tutor_requests() {
        if($this->is_tutor) {
            return $this->hasMany('App\Tutor_request', 'tutor_id');
        }
        else {
            return $this->hasMany('App\Tutor_request', 'student_id');
        }

    }


    // return users that are bookmarked
    public function users() {
        return $this->belongsToMany('App\User', 'bookmark_user', 'bookmarked_user_id', 'user_id');
    }

    public function upcomingSessions($num) {
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

    // check whether the subject with $subject_id is already faved by the current user
    public function favedCharacteristic($characteristic_id) {
        return $this->characteristics()->where('id', '=', $characteristic_id)->count() > 0;
    }

}
