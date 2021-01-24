<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $dates = ['viewed_at'];

    public function viewable() {
        return $this->morphTo();
    }
}
