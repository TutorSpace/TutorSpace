<?php

namespace App;

use Carbon\Carbon;
use App\Transaction;
use App\CustomTrait\Uuid;
use Illuminate\Database\Eloquent\Model;


class Session extends Model
{
    use Uuid;

    protected $dates = ['created_at', 'updated_at', 'session_time_start', 'session_time_end'];

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
        return Transaction::where('session_id', $this->id)->first();
    }

    public function transactionStatus() {
        return $this->transaction()->invoice_status;
    }

    public function paidSuccess() {
        return $this->transaction()->invoice_status == 'paid';
    }

    public function sessionBonus() {
        return $this->hasOne('App\SessionBonus');
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

    // Calculate the duration in hour (with two decimal places)
    public function getDurationInHour() {
        $startTimeInTime = strtotime($this->session_time_start);
        $endTimeInTime = strtotime($this->session_time_end);
        return round(abs($endTimeInTime - $startTimeInTime) / 3600, 2);
    }

    public function calculateSessionFee() {
        $hourlyRate = $this->hourly_rate;
        $sessionFee = $this->getDurationInHour() * $hourlyRate;
        return $sessionFee;
    }
}
