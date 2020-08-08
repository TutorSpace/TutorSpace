<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public $timestamps = false;

    public function viewable() {
        return $this->morphTo();
    }
}
