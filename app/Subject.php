<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    

    public function users() {
        return $this->belongsToMany('App\User');
    }
}
