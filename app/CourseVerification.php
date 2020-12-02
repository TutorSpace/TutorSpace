<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseVerification extends Model
{
    //
    public $incrementing = true;
    public $timestamps = true;
    protected $attributes = [
        'verified' => false,
    ];

    public function tutor(){
        return $this->belongsTo('App\User');
    }

    public function course(){
        return $this->belongsTo('App\Course');
    }
}
