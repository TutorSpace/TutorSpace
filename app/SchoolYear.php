<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $table = "school_years";
    public $timestamps = false;

    public function users() {
        return $this->hasMany('App\User');
    }
}
