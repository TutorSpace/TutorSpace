<?php

namespace App;

use App\CustomTrait\Uuid;
use Illuminate\Database\Eloquent\Model;

class CancellationPenalty extends Model
{
    use Uuid;
    public $timestamp = true;

    public function user() {
        return $this->belongsTo('App\User');
    }
}
