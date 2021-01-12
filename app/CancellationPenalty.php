<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancellationPenalty extends Model
{
    public $timestamp = true;

    public function user() {
        return $this->belongsTo('App\User');
    }
}
