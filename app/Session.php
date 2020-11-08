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


}
