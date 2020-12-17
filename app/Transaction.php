<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function session() {
        return $this->belongsTo('App\Session');
    }
}
