<?php

namespace App;

use App\CustomTrait\Uuid;
use Illuminate\Database\Eloquent\Model;

class SessionBonus extends Model
{
    use Uuid;

    public $timestamp = true;

    public function session() {
        return $this->belongsTo('App\Session');
    }
}
