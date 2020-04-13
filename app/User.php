<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Session;

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

    public function upcomingSessions() {
        if($this->is_tutor) {
            // the returned information is about the student
            $sessions = Session::join('users', 'sessions.student_id', '=', 'users.id')
                ->where('tutor_id', $this->id)
                ->get();
            
            return $sessions;
        }
        else {
            // the returned information is about the tutor
            $sessions = Session::join('users', 'sessions.tutor_id', '=', 'users.id')
            ->where('student_id', $this->id)
            ->get();
        
            return $sessions;
        }
        
        
        
    }
}
