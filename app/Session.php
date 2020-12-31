<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Session extends Model
{

    public function course() {
        return $this->belongsTo('App\Course');
    }

    public function tutor() {
        return $this->belongsTo('App\User', 'tutor_id');
    }

    public function student() {
        return $this->belongsTo('App\User', 'student_id');
    }

    public function cancelReason() {
        return $this->belongsTo('App\SessionCancelReason', 'cancel_reason_id');
    }

    public function transaction() {
        return $this->hasOne('App\Transaction')->withDefault();
    }

    public function sessionBonus() {
        return $this->hasOne('App\SessionBonus')->withDefault();
    }

    // IMPORTANT: must run scheduler in prod env
    public function changeSessionStatusOnExpiry() {
        $sessions = Session::all();
        foreach($sessions as $session) {
            if($session->session_time_start <= Carbon::now()) {
                $session->is_upcoming = 0;
                $session->save();
            }
        }
    }


}
