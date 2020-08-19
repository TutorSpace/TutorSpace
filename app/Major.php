<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    public $timestamps = false;

    public function users() {
        return $this->hasMany('App\User');
    }
}
