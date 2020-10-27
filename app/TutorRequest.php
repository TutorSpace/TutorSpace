<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TutorRequest extends Model
{
    protected $table = "tutor_requests";

    // IMPORTANT: must run scheduler in prod env
    public function changeTutorRequestStatusOnTimeout() {
        $tutorRequests = TutorRequest::all();
        foreach($tutorRequests as $tutorRequest) {
            if($tutorRequest->session_time_start <= Carbon::now()->addMinutes(10)) {
                $tutorRequest->status = 'expired';
                $tutorRequest->save();
            }
        }
    }
}
