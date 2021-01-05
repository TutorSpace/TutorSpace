<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TutorRequest extends Model
{
    protected $table = "tutor_requests";

    public function course() {
        return $this->belongsTo('App\Course');
    }

    public function tutor() {
        return $this->belongsTo('App\User', 'tutor_id');
    }

    public function student() {
        return $this->belongsTo('App\User', 'student_id');
    }

    // IMPORTANT: must run scheduler in prod env
    public function changeTutorRequestStatusOnTimeout() {
        $tutorRequests = TutorRequest::all();
        foreach($tutorRequests as $tutorRequest) {
            // must accept the tutor request at least 10 minutes before the session starts
            if($tutorRequest->session_time_start <= Carbon::now()->addMinutes(10)) {
                $tutorRequest->status = 'expired';
                $tutorRequest->save();
            }
        }
    }
}
