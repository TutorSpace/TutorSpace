<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamp = true;

    public function session() {
        return $this->belongsTo('App\Session');
    }
}
