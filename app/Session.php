<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Session extends Model
{
    public function courseSubject() {
        if($this->is_course) {
            return $this->course->course;
        }
        else {
            return $this->subject->subject;
        }

    }

    public function course() {
        return $this->belongsTo('App\Course');
    }

    public function subject() {
        return $this->belongsTo('App\Subject');
    }



}
