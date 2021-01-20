<?php

namespace App;

use App\Review;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\UnratedTutorNotification;
use App\Notifications\UpcomingSessionNotification;
use App\Notifications\TutorSessionFinishedNotification;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;


class Session extends Model
{
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;
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

    public function review() {
        return $this->belongsTo('App\Review');
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

    // IMPORTANT: must run scheduler in prod env
    public static function changeSessionStatusOnExpiry() {
        $sessions = Session::where('is_canceled', false)->where('is_upcoming', true)->get();
        foreach($sessions as $session) {
            // IMPORTANT: use session_time_end here, because otherwise a long session will not appear on calendar
            if($session->session_time_end <= Carbon::now()) {
                $session->is_upcoming = false;
                $session->save();

                $session->tutor->notify(new TutorSessionFinishedNotification($session));
            }
        }
    }

    // notify users 1 hour before the session starts
    public static function notifyUpcomingSessions() {
        $sessions = Session::where('is_canceled', false)->get();
        foreach($sessions as $session) {
            if(Carbon::now()->addHours(1) >= $session->session_time_start && !$session->is_notified) {
                $session->tutor->notify(new UpcomingSessionNotification($session));
                $session->student->notify(new UpcomingSessionNotification($session));

                $session->is_notified = true;
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


    // // todo: should not bother user too often
    // public static function requestReviewForTutor() {
    //     $sessions = Session::where('is_canceled', false)->where('is_upcoming', false)->get();

    //     foreach($sessions as $session) {
    //         if(Review::where('session_id', $session->id)->doesntExist()) {
    //             $session->student->notify(new UnratedTutorNotification($session));
    //         }
    //     }
    // }

}
