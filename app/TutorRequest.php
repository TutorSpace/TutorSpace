<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\TutorRequestDeclined;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class TutorRequest extends Model
{
    use Uuid;

    protected $table = "tutor_requests";

    protected $dates = ['created_at', 'updated_at', 'session_time_start', 'session_time_end'];

    protected $keyType = 'string';
    public $incrementing = false;

    public function course() {
        return $this->belongsTo('App\Course');
    }

    public function tutor() {
        return $this->belongsTo('App\User', 'tutor_id');
    }

    public function student() {
        return $this->belongsTo('App\User', 'student_id');
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

    // IMPORTANT: must run scheduler in prod env
    public static function changeTutorRequestStatusOnTimeout() {
        $tutorRequests = TutorRequest::where('status', 'pending')->get();
        foreach($tutorRequests as $tutorRequest) {

            // must accept the tutor request at least 60 minutes before the session starts
            if($tutorRequest->session_time_start <= Carbon::now()->addMinutes(60)) {
                $tutorRequest->status = 'declined';
                $tutorRequest->save();

                $tutorRequest->refresh();

                $tutorRequest->student->notify(new TutorRequestDeclined($tutorRequest));
            }
        }
    }
}
