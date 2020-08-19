<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableTime extends Model
{
    public $timestamps = false;
    protected $table = "available_times";
    protected $guarded = [];
}
