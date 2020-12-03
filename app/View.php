<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function viewable() {
        return $this->morphTo();
    }
}
