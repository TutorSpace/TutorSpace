<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard_post extends Model
{

    public function user() {
        return $this->belongsTo('App\User');
    }
}
