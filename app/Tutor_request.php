<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tutor_request extends Model
{

	// IMPORTANT: must run scheduler in prod env
    public function changeTutorRequestStatusOnTimeout() {

        $tutorRequests = Tutor_request::all();
        foreach($tutorRequests as $tutorRequest) {
            if($tutorRequest->session_start_time <= Carbon::now()) {
                $tutorRequest->status = 'expired';
                $tutorRequest->save();
            }
        }
    }
}